<?php
namespace HawksNestGolf\Resources\Field;

class FieldController extends \HawksNestGolf\Resources\Base\BaseController {

    public function __construct() {
        parent::__construct();
        $this->repositoryHandler = $this->repository->Field;
        $this->golfersController = new \HawksNestGolf\Resources\Golfers\GolfersController();
   }

    public function getModel($params) {
        return new FieldEntry($params);
    }
    
    public function clear() {
        return $this->repositoryHandler->clear();
    }

//    public function getView($success, $data, $statusCode=null) {
//		return new FieldView($success, $data, $statusCode);
//    }

    // Override the get method so that the related objects can be included
    public function get ($id, $params, $response=null) {
         $theField = parent::get($id, $params);
        if($theField) {
            // Add includeGolfer objects if desired, default is to include them
            $includeRelated = isset($params['includeRelated']) ? $params['includeRelated'] : true;
            //var_dump($params);
            if($includeRelated) {
               $tmpParams = array('includeRelated' => $includeRelated);
               foreach($theField as $fieldEntry) {
                    if($fieldEntry->golferId > 0) {
                        $golfers = $this->golfersController->get($fieldEntry->golferId, $tmpParams);
                        if($golfers)
                            $fieldEntry->golfer = $golfers[0];
                    }
                }
            }

        }
        if($response) {
            $renderData = ($id && $theField) ? $theField[0] : $theField;
            $statusCode = $renderData ? 200 : 404;
            return $this->render($response, true, $renderData, $statusCode);
         }

        return $theField;
    }

    public function updateFromCSV($params, $response=null) {
        
        $fieldEntries = $this->getFieldFromCSV();
        
        //var_dump($fieldEntries);
        
        $success = $this->repositoryHandler->addMultiple($fieldEntries);

        if($success) {
            $retData = array('result' => "Updated The Field"); //$this->get($item->id, array(), false);
            $statusCode = 201;
        }
        else {
            $retData = "Error Updating The Field";
            $statusCode = 400;
        }
        return $this->render($response, $success, $retData, $statusCode);
    }


    function getFieldFromCSV()
    {
        //echo("In getOddsFromCSV");
        $fileName = "M:\\TPCTheFieldWithOdds.csv";
        //echo($fileName);
        $data = $this->csv_to_array($fileName);
        //var_dump($data);
        
        $numInField = count($data);

        for($i=0; $i < $numInField; $i++)
        {
            $item = $data[$i];

            $golferId = $item['GolferId'];
            $pgaTourId = $item['PGATourId'];
            $name = $item['GolferName'];
            $oddsText = $data[$i]['Odds'];
            $oddsRank = $data[$i]['OddsRank'];

            if($golferId <=0) {
                $errMsg = 'Error getting golferId in getOdds for '.$name;
                var_dump($errMsg);
            }
            
            $field[] = new FieldEntry((object)[
                                       'golferId' => $golferId,
                                       'pgaTourId' => $pgaTourId,
                                       'odds' => $oddsText,
                                       'oddsRank' => $oddsRank
                                      ]);
        }

        return($field);
    }

    function csv_to_array($filename='', $delimiter=',', $enclosure='"')
    {
        if(!file_exists($filename) || !is_readable($filename))
        {
           echo ('<br><span style="color:red">Unable to open odds file '.$filename.'</span>');
           return 0;
        }

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            $i = 0;
            while (($row = fgetcsv($handle, 1000, $delimiter, $enclosure)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[$i++] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

}
