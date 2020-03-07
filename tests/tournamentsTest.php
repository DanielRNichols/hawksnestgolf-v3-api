<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/resourceTest.php';

class TournamentsTest extends ResourceTest {
    // ...
    const RESOURCE_NAME = 'tournaments';
    
    var $expectedData = ['name' => 'Masters',
                         'isOfficial' => true,
                         'url' => 'http://www.pgatour.com/data/r/014/leaderboard-v2.json',
                         'url2' => 'http://www.pgatour.com/data/r/014/leaderboard.json'
                        ];

    
    protected function assertByIdTests($responseData, $expectedData) {
        parent::assertTests($responseData, $expectedData);
        
        //echo('In TournamentsTest->assertTests');
        
        $this->assertEquals($responseData->name, $expectedData['name']);
        $this->assertEquals($responseData->isOfficial, $expectedData['isOfficial']);
        $this->assertEquals($responseData->url, $expectedData['url']);
        $this->assertEquals($responseData->url2, $expectedData['url2']);
    }
    
    public function testGet() {
        
        parent::GetTest(self::RESOURCE_NAME, 1, $this->expectedData);
    }
    
    public function testGetById() {
        
        parent::GetByIdTest(self::RESOURCE_NAME, 1, $this->expectedData);
    }
    
    public function testCRUD() {
        // mock up a new item
        $inputData = ['name' => 'Test Tournament',
                      'isOfficial' => false,
                      'url' => 'http://www.pgatour.com/data/r/998/leaderboard-v2.json',
                      'url2' => 'http://www.pgatour.com/data/r/998/leaderboard.json'
                     ];
        
        // mock up modified item
        $updateData = ['name' => 'Modified Test Tournament',
                       'isOfficial' => true,
                       'url' => 'http://www.pgatour.com/data/r/999/leaderboard-v2.json',
                       'url2' => 'http://www.pgatour.com/data/r/999/leaderboard.json'
                     ];

        parent::CRUDTest(self::RESOURCE_NAME, $inputData, $updateData);
    }
    
}







