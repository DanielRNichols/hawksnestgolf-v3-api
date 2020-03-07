<?php

require_once __DIR__ . '/../vendor/autoload.php';

class ResourceTest extends PHPUnit_Framework_TestCase {
    // ...

    public function testDummyTest()
    {
        $this->assertEquals(1,1);
    }

    private function createClient()
    {
        return new GuzzleHttp\Client(['base_uri' => 'localhost:9080/hawksnestgolf.aurelia/api/']);
    }

    private function getUrl($resource, $id=null) {
        return ($resource . ($id ? '/' . $id : ''));

    }

    protected function assertTests($responseData, $expectedData)
    {
    }

    protected function assertByIdTests($responseData, $expectedData)
    {
    }

    private function FindItemById($array, $id) {
        $item = null;
        foreach($array as $currItem) {
            if ($id == $currItem->id) {
                $item = $currItem;
                break;
            }
        }

        return $item;
    }

     protected function GetTest($resource, $id, $expectedData) {
        $client = $this->createClient();
        $res = $client->get($this->getUrl($resource));
        $this->assertEquals($res->getStatusCode(), 200);

        $responseData = json_decode($res->getBody($resource));

        $item = $this->FindItemById($responseData, $id);

        $this->assertNotNull($item, 'Item with id = ' . $id . ' was not found');
        $this->assertByIdTests($item, $expectedData);

        return $responseData;
    }

    protected function GetByIdTest($resource, $id, $expectedData) {
        // create the http client
       $client = $this->createClient();
       return $this->getWithIdTest($client, $resource, $id, $expectedData);
    }

    protected function CRUDTest($resource, $inputData, $updateData) {
        // create the http client
        $client = $this->createClient();

        // run the create test
        $id = $this->createTest($client, $resource, $inputData);

        // run the update test
        $this->updateTest($client, $resource, $id, $updateData);

        // run the delete test
        $this->deleteTest($client, $resource, $id);

    }

    protected function getWithIdTest($client, $resource, $id, $expectedData) {
        //echo($this->getUrl($resource, $id));
        $res = $client->get($this->getUrl($resource, $id));
        $this->assertEquals($res->getStatusCode(), 200);

        $responseData = json_decode($res->getBody());

        $this->assertByIdTests($responseData, $expectedData);

        return $responseData;
    }

    protected function getWithIdExpectNotFoundTest($client, $resource, $id) {
        try {
            $getRes = $client->get($this->getUrl($resource, $id));
        }
        catch (GuzzleHttp\Exception\ClientException $e) {
            $getRes = $e->getResponse();
        }
        $this->assertEquals($getRes->getStatusCode(), 404);

    }

    protected function createTest($client, $resource, $inputData) {
        $res = $client->post($this->getUrl($resource), ['json' => $inputData]);
        $this->assertEquals($res->getStatusCode(), 201);

        $data = json_decode($res->getBody());
        $this->assertObjectHasAttribute('id', $data);

        // make sure that we can get the newly created item
        $this->getWithIdTest($client, $resource, $data->id, $inputData);

        return $data->id;
    }

    protected function updateTest($client, $resource, $id, $updateData) {
        $res = $client->put($this->getUrl($resource, $id), ['json' => $updateData]);
        $this->assertEquals($res->getStatusCode(), 201);

        $responseData = json_decode($res->getBody());

        $this->assertTests($responseData, $updateData);

        // make sure that we can get the newly modified item
        $this->getWithIdTest($client, $resource, $id, $updateData);


        return ($responseData);
     }

    protected function deleteTest($client, $resource, $id) {
        $delRes = $client->delete($this->getUrl($resource, $id));
        $this->assertEquals($delRes->getStatusCode(), 201);

        $resData = json_decode($delRes->getBody());
        $this->assertEquals($resData->success, true);

        // make sure that we cannot get the item any longer
        $this->getWithIdExpectNotFoundTest($client, $resource, $id);

    }

}
