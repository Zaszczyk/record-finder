<?php
use MateuszBlaszczyk\RecordFinder\Finder\DurationFinder;

class DurationFinderTest extends PHPUnit_Framework_TestCase
{
    /** @var  DurationFinder */
    public $finder;

    protected function setUp()
    {
        $this->finder = new DurationFinder();
    }

    protected function tearDown()
    {
        $this->finder = null;
    }

    public function testFindRecordByTime()
    {
        $tests = ['shortPathProvider1', 'shortPathProvider2', 'shortPathProvider3'];
        foreach ($tests as $test){
            $data = self::$test();
            $finder = $this->finder->setData($data->path);
            $record = $finder->findRecordByTime($data->time);
            $this->assertInstanceOf('MateuszBlaszczyk\RecordFinder\Record\DurationRecord', $record);
            $this->assertEquals($record->distance, $data->expectedRecordDistance);
            $this->assertEquals($record->recordTimeStart, $data->expectedRecordTimeStart);
            $this->assertEquals($record->recordDistanceStart, $data->expectedRecordDistanceStart);
            $this->assertEquals($record->pointKey, $data->expectedRecordPointKey);
        }
    }

    public static function shortPathProvider1()
    {
        $result = new stdClass();
        $result->time = 720;
        $result->expectedRecordDistance = 200;
        $result->expectedRecordTimeStart = 2520;
        $result->expectedRecordDistanceStart = 120;
        $result->expectedRecordPointKey = 10;
        $result->path = [
            [
                'timestamp' => 0,
                'distance' => 0
            ],
            [
                'timestamp' => 360,
                'distance' => 10,
            ],
            [
                'timestamp' => 720,
                'distance' => 60
            ],
            [
                'timestamp' => 1080,
                'distance' => 110
            ],
            [
                'timestamp' => 1440,
                'distance' => 111
            ],
            [
                'timestamp' => 1800,
                'distance' => 112
            ],
            [
                'timestamp' => 2160,
                'distance' => 113
            ],
            [
                'timestamp' => 2520,
                'distance' => 120
            ],
            [
                'timestamp' => 2880,
                'distance' => 220
            ],
            [
                'timestamp' => 3060,
                'distance' => 270
            ],
            [
                'timestamp' => 3240,
                'distance' => 320
            ],
            [
                'timestamp' => 3600,
                'distance' => 321
            ],
            [
                'timestamp' => 3960,
                'distance' => 322
            ]
        ];

        return $result;
    }

    public static function shortPathProvider2()
    {
        $result = new stdClass();
        $result->time = 3600;
        $result->expectedRecordDistance = 2600;
        $result->expectedRecordTimeStart = 5400;
        $result->expectedRecordDistanceStart = 1100;
        $result->expectedRecordPointKey = 15;
        $result->path = [
            [
                'timestamp' => 0,
                'distance' => 200
            ],
            [
                'timestamp' => 600,
                'distance' => 300,
            ],
            [
                'timestamp' => 1200,
                'distance' => 400
            ],
            [
                'timestamp' => 1800,
                'distance' => 500
            ],
            [
                'timestamp' => 2400,
                'distance' => 600
            ],
            [
                'timestamp' => 3000,
                'distance' => 700
            ],
            [
                'timestamp' => 3600,
                'distance' => 800
            ],
            [
                'timestamp' => 4200,
                'distance' => 900
            ],
            [
                'timestamp' => 4800,
                'distance' => 1000
            ],
            [
                'timestamp' => 5400,
                'distance' => 1100
            ],
            [

                'timestamp' => 6000,
                'distance' => 1200
            ],
            [
                'timestamp' => 6600,
                'distance' => 1700
            ],
            [
                'timestamp' => 7200,
                'distance' => 2200
            ],
            [
                'timestamp' => 7800,
                'distance' => 2700
            ],
            [
                'timestamp' => 8400,
                'distance' => 3200
            ],
            [
                'timestamp' => 9000,
                'distance' => 3700

            ],
            [
                'timestamp' => 9600,
                'distance' => 3800
            ],
            [
                'timestamp' => 10200,
                'distance' => 3900
            ],
            [
                'timestamp' => 10800,
                'distance' => 4000
            ]
        ];

        return $result;
    }

    public static function shortPathProvider3()
    {
        $result = new stdClass();
        $result->time = 3600;
        $result->expectedRecordDistance = 3100;
        $result->expectedRecordTimeStart = 0;
        $result->expectedRecordDistanceStart = 0;
        $result->expectedRecordPointKey = 6;
        $result->path = [
            [
                'timestamp' => 0,
                'distance' => 500
            ],
            [
                'timestamp' => 600,
                'distance' => 1000,
            ],
            [
                'timestamp' => 1200,
                'distance' => 1500
            ],
            [
                'timestamp' => 1800,
                'distance' => 2000
            ],
            [
                'timestamp' => 2400,
                'distance' => 2500
            ],
            [
                'timestamp' => 3000,
                'distance' => 3000
            ],
            [
                'timestamp' => 3600,
                'distance' => 3100
            ],
            [
                'timestamp' => 4200,
                'distance' => 3200
            ],
            [
                'timestamp' => 4800,
                'distance' => 3300
            ],
            [
                'timestamp' => 5400,
                'distance' => 3400
            ],
            [
                'timestamp' => 6000,
                'distance' => 3500
            ],
            [
                'timestamp' => 6600,
                'distance' => 3600
            ],
            [
                'timestamp' => 7200,
                'distance' => 3700
            ],
            [
                'timestamp' => 7800,
                'distance' => 3800
            ],
            [
                'timestamp' => 8400,
                'distance' => 3900
            ],
            [
                'timestamp' => 9000,
                'distance' => 4000
            ],
            [
                'timestamp' => 9600,
                'distance' => 4100
            ],
            [
                'timestamp' => 10200,
                'distance' => 4200
            ],
            [
                'timestamp' => 10800,
                'distance' => 4300
            ]
        ];

        return $result;
    }
}
