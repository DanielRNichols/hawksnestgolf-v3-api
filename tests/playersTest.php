<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/resourceTest.php';

class PlayersTest extends ResourceTest {
    // ...
    
    const RESOURCE_NAME = 'players';
    
    var $expectedData = ['name' => 'Holly',
                         'userName' => 'Holly',
                         'email' => 'hmlbrla@bellsouth.net',
                         'email2' => '',
                         'isAdmin' => false
                        ];

    
    protected function assertByIdTests($responseData, $expectedData) {
        parent::assertTests($responseData, $expectedData);
        
        //echo('In PlayersTest->assertTests');
        
        $this->assertEquals($responseData->name, $expectedData['name']);
        $this->assertEquals($responseData->userName, $expectedData['userName']);
        $this->assertEquals($responseData->email, $expectedData['email']);
        $this->assertEquals($responseData->email2, $expectedData['email2']);
        $this->assertEquals($responseData->isAdmin, $expectedData['isAdmin']);
    }
    
    public function testGet() {
        
        parent::GetTest(self::RESOURCE_NAME, 1, $this->expectedData);
    }
    
    public function testGetById() {
        
        parent::GetByIdTest(self::RESOURCE_NAME, 1, $this->expectedData);
    }
    
    public function testCRUD() {
        // mock up a new item
        $inputData = ['name' => 'John', 
                      'userName' => 'JohnD',
                      'password' => '123',
                      'email' => 'jDoe@something.net',
                      'email2' => 'jDoe@somethingElse.net',
                      'isAdmin' => false
                     ];
        
        // mock up modified item
        $updateData = ['name' => 'Jack', 
                      'userName' => 'JackD',
                      'password' => '12345',
                      'email' => 'jDoe@somethingNew.net',
                      'email2' => 'jDoe@somethingElseNew.net',
                      'isAdmin' => true
                     ];

        parent::CRUDTest(self::RESOURCE_NAME, $inputData, $updateData);
    }
    

}





