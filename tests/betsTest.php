<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/resourceTest.php';

class BetsTest extends ResourceTest {
    // ...
    const RESOURCE_NAME = 'bets';
    
    var $expectedData = ['name' => 'Thursday Day Money',
                         'defAmount' => 30
                        ];
    
    protected function assertByIdTests($responseData, $expectedData) {
        //echo('In BetsTest->assertTests');
        
        $this->assertEquals($responseData->name, $expectedData['name']); //, 'Test for bet->name failed, expected ' . $expectedData['name'] .' got ' . $responseData->name);
        $this->assertEquals($responseData->defAmount, $expectedData['defAmount']); 
    }
    
    public function testGet() {
        
        parent::GetTest(self::RESOURCE_NAME, 1, $this->expectedData);

    }
    
    public function testGetById() {
         
        parent::GetByIdTest(self::RESOURCE_NAME, 1, $this->expectedData);

    }
    
//    public function testPost() {
//        // mock up a new item
//        $inputData = ['name' => 'Test Bet'];
//    
//        parent::PostTest(self::RESOURCE_NAME, $inputData);
//    }
//    
//    public function testPut() {
//        // mock up modified item
//        $updateData = ['name' => 'Modified Test Bet'];
//        
//        parent::PutTest(self::RESOURCE_NAME, $mId, $updateData);
//    }
//    
//    public function testDelete() {
//        parent::DeleteTest(self::RESOURCE_NAME, $mId);
//    }
    
    public function testCRUD() {
        // mock up a new item
        $inputData = ['name' => 'Test Bet',
                      'defAmount' => 50
                     ];
        
        // mock up modified item
        $updateData = ['name' => 'Modified Test Bet',
                      'defAmount' => 100
                     ];

        parent::CRUDTest(self::RESOURCE_NAME, $inputData, $updateData);
    }
    
}







