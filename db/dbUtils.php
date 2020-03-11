<?php

namespace HawksNestGolf\Db;

Class DbUtils
{
    private static function assocArrayAsObject($arr) {
        $object = new \stdClass();
        foreach($arr as $key => $value)
            $object->{$key} = $value;
        
        return $object;
    }
    public static function getQueryData($con, $query, $asObjects=false ) {
        if ($result = $con->query($query)) {

            /* fetch associative array */
            while ($row = $result->fetch_assoc()) {
                $qData[] = ($asObjects ? self::assocArrayAsObject($row) : $row);
            }

            /* free result set */
            $result->free();
        }

        return(isset($qData) ? $qData : null);
    }
    
    public static function getQueryString($select, $whereClause, $params, $applyFilters) { 
        //var_dump($params);
        $filter = isset($params['filter']) ? $params['filter'] : null; 
        if($filter) {
          $useWildCards = !isset($params['wildcards']) || ($params['wildcards'] != '0' && strtolower($params['wildcards']) != 'false') ;
          if($useWildCards) {
            $filter = str_replace("*", "%", $filter);
          }
        }
        $orderBy = isset($params['orderby']) ? $params['orderby'] : null; 
        $top =  isset($params['top']) ? $params['top'] : null; 
        $skip = isset($params['skip']) ? $params['skip'] : null; 

        
        if($applyFilters && $filter)
            $whereClause = ($whereClause ? $whereClause." and " : "where ").$filter;
        else if(!$whereClause)
            $whereClause = '';
        
        $orderByClause = '';
        if($orderBy)
             $orderByClause = "order by ".$orderBy;
        
        $limitClause = '';
        if($top || $skip) {
            if(!$top)
                $top = 100000; //18446744073709551615; //pow(2, 64);
            if(!$skip)
                $skip = 0;
            $limitClause = "limit ".$skip.",".$top;
        }
        
        $queryStr = $select." ".$whereClause." ".$orderByClause." ".$limitClause;
        
        //var_dump ($queryStr);
        return $queryStr;
    }
    
    public static function insert ($con, $insertQuery) {
        $queryresult = $con->query($insertQuery);

         if($queryresult && ($con->affected_rows > 0))
             $newId = $con->insert_id;
         else
             $newId = 0;

         return($newId);

    }

    public static function update ($con, $updateQuery) {
        //var_dump($updateQuery);
        $queryresult = $con->query($updateQuery);
        
        if($queryresult)
            return $con->affected_rows;
        else if($con->errorno == 0)
           return 0;
        else
           return -1;

    }
    
    public static function delete ($con, $deleteQuery) {
        $queryresult = $con->query($deleteQuery);
         
         if($queryresult)
            return $con->affected_rows;
         else
             return 0;
    }

}


