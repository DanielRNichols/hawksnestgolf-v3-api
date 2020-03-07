<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/resourceTest.php';

class MessagesTest extends ResourceTest {
    // ...
    const RESOURCE_NAME = 'messages';
    
    protected function assertByIdTests($responseData, $expectedData) {
        parent::assertTests($responseData, $expectedData);

        //echo('In MessageTest->assertTests');

        $this->assertEquals($responseData->playerId, $expectedData['playerId']);
        $this->assertEquals($responseData->message, $expectedData['message']);
    }
    
    public function testCRUD() {
        // mock up a new item
        $inputData = ['playerId' => 1,
                      'message' => 'Hello, Everyone'
                     ];
        
        // mock up modified item
        $updateData = ['playerId' => 2,
                      'message' => 'Hello, World'
                     ];

        parent::CRUDTest(self::RESOURCE_NAME, $inputData, $updateData);
    }
    
}







