<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/resourceTest.php';

class GolfersTest extends ResourceTest {
    // ...
    
    const RESOURCE_NAME = 'golfers';
    
    var $expectedData = ['name' => 'Jordan Spieth',
                         'pgaTourId' => 34046, 
                         'selectionName' => 'SPIETH',
                         'country' => 'USA',
                         'image' => 'JordanSpieth.jpg'
                         ];
    
    protected function assertByIdTests($responseData, $expectedData) {
        parent::assertTests($responseData, $expectedData);
        
        $this->assertEquals($responseData->name, $expectedData['name']);
        $this->assertEquals($responseData->pgaTourId, $expectedData['pgaTourId']);
        $this->assertEquals($responseData->selectionName, $expectedData['selectionName']);
        $this->assertEquals($responseData->country, $expectedData['country']);
        $this->assertEquals($responseData->image, $expectedData['image']);
        
        if(array_key_exists('worldRanking', $expectedData)) {
            $this->assertEquals($responseData->worldRanking, $expectedData['worldRanking']);
        }
        else {
            $this->assertGreaterThan(0, $responseData->worldRanking);
        }
                
        if(array_key_exists('fedExRanking', $expectedData)) {
            $this->assertEquals($responseData->fedExRanking, $expectedData['fedExRanking']);
        }
        else {
             $this->assertGreaterThan(0, $responseData->fedExRanking);
        }
                
    }
    
    public function testGet() {
        
        parent::GetTest(self::RESOURCE_NAME, 753, $this->expectedData);
    }
    
    public function testGetById() {
        
        parent::GetByIdTest(self::RESOURCE_NAME, 753, $this->expectedData);
    }
    
    public function testCRUD() {
        // mock up a new item
        $inputData = ['name' => 'Joe Jackson Jr',
                         'pgaTourId' => 987654, 
                         'selectionName' => 'Jackson, J.J.',
                         'country' => 'USA',
                         'image' => 'JoeJacksonJr.jpg',
                         'worldRanking' => 1000,
                         'fedExRanking' => 1001
            
                         ];
        
        // mock up modified item
        $updateData = ['name' => 'Joe Jackson',
                         'pgaTourId' => 876543, 
                         'selectionName' => 'Jackson, J.',
                         'country' => 'ENG',
                         'image' => 'JoeJackson.jpg',
                         'worldRanking' => 1002,
                         'fedExRanking' => 1003
                         ];

        parent::CRUDTest(self::RESOURCE_NAME, $inputData, $updateData);
    }
    

}





