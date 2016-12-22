<?php
use MateuszBlaszczyk\RecordFinder\Finder\LapsFinder;
use MateuszBlaszczyk\RecordFinder\Record\Lap;

/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 15.12.2016
 * Time: 16:23
 */
class LapsFinderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  LapsFinder */
    public $finder;

    protected function setUp()
    {
        $this->finder = new LapsFinder();
    }

    protected function tearDown()
    {
    }

    public function getArrayFromJsonFile($filename)
    {
        $json = file_get_contents(__DIR__ . '/data/' . $filename);
        return json_decode($json, true);
    }


    /**
     * @dataProvider createNewLapProvider
     */
    public function testLapConstructor($duration, $distance, $expectedDuration, $expectedDistance)
    {
        $lap = new Lap($duration, $distance);

        $this->assertEquals($expectedDistance, $lap->distance);
        $this->assertEquals($expectedDuration, $lap->duration);
    }

    public function createNewLapProvider()
    {
        return [
            [1, 2, 1, 2],
            [1.1, 22.2, 1.1, 22.2],
        ];
    }

    /**
     * @dataProvider countPaceProvider
     */
    public function testCountPace($duration, $distance, $expected)
    {
        $pace = $this->finder->countPace($duration, $distance);

        $this->assertEquals($expected, $pace);
    }

    public function countPaceProvider()
    {
        return [
            [60, 1, 60],
            [120, 1, 120],
            [120, 2, 60],
            [60, 2, 30],
            [3600, 10, 360],
            [3601, 10, 360.1],
            [3601, 0, '-'],
        ];
    }

    /**
     * @dataProvider countSpeedProvider
     */
    public function testCountSpeed($duration, $distance, $expected)
    {
        $speed = $this->finder->countSpeedInKmh($duration, $distance);

        $this->assertEquals($expected, $speed);
    }

    public function countSpeedProvider()
    {
        return [
            [60, 1, 60],
            [120, 1, 30],
            [120, 2, 60],
            [60, 2, 120],
            [3600, 10, 10],
            [3601, 10, 9.997],
            [3599, 10, 10.003],
            [0, 10, '-'],
        ];
    }

    /**
     * @dataProvider getDurationDeltaProvider
     */
    public function testGetDurationDelta($startingDuration, $nowDuration, $expectedDelta)
    {
        $results = $this->finder->getDurationDelta($startingDuration, $nowDuration);

        $this->assertEquals($expectedDelta, $results);
    }

    public function getDurationDeltaProvider()
    {
        return [
            [0, 300, 300],
            [150, 300, 150],
            [150, 300, 150],
        ];
    }


    public function testSetFastestAndSetSlowest1()
    {
        $laps = [
            new Lap(0, 1),
            new Lap(1, 1),
            new Lap(999, 1),
            new Lap(100, 1),
        ];

        $this->finder->laps = $laps;
        $this->finder->setFastest();
        $this->finder->setSlowest();
        $this->assertEquals(true, $this->finder->laps[0]->fastest);
        $this->assertEquals(false, $this->finder->laps[1]->fastest);
        $this->assertEquals(false, $this->finder->laps[2]->fastest);
        $this->assertEquals(false, $this->finder->laps[3]->fastest);

        $this->assertEquals(false, $this->finder->laps[0]->slowest);
        $this->assertEquals(false, $this->finder->laps[1]->slowest);
        $this->assertEquals(true, $this->finder->laps[2]->slowest);
        $this->assertEquals(false, $this->finder->laps[3]->slowest);
    }


    public function testSetFastestAndSetSlowest2()
    {
        $laps = [
            new Lap(1, 1),
            new Lap(100, 1),
            new Lap(null, 1),
            new Lap(999, 1),
        ];

        $this->finder->laps = $laps;
        $this->finder->setFastest();
        $this->finder->setSlowest();
        $this->assertEquals(true, $this->finder->laps[0]->fastest);
        $this->assertEquals(false, $this->finder->laps[1]->fastest);
        $this->assertEquals(false, $this->finder->laps[2]->fastest);
        $this->assertEquals(false, $this->finder->laps[3]->fastest);

        $this->assertEquals(false, $this->finder->laps[0]->slowest);
        $this->assertEquals(false, $this->finder->laps[1]->slowest);
        $this->assertEquals(false, $this->finder->laps[2]->slowest);
        $this->assertEquals(true, $this->finder->laps[3]->slowest);
    }


    public function testSetFastestAndSetSlowest3()
    {
        $laps = [
            new Lap(10, 1),
            new Lap(100, 1),
            new Lap(1, 1),
            new Lap(101, 1),
        ];

        $this->finder->laps = $laps;
        $this->finder->setFastest();
        $this->finder->setSlowest();
        $this->assertEquals(false, $this->finder->laps[0]->fastest);
        $this->assertEquals(false, $this->finder->laps[1]->fastest);
        $this->assertEquals(true, $this->finder->laps[2]->fastest);
        $this->assertEquals(false, $this->finder->laps[3]->fastest);

        $this->assertEquals(false, $this->finder->laps[0]->slowest);
        $this->assertEquals(false, $this->finder->laps[1]->slowest);
        $this->assertEquals(false, $this->finder->laps[2]->slowest);
        $this->assertEquals(true, $this->finder->laps[3]->slowest);
    }

    public function testSetFastestAndSetSlowest4()
    {
        $laps = [
            new Lap(null, 1),
            new Lap(100, 1),
            new Lap(1, 1),
            new Lap(100, 1),
        ];

        $this->finder->laps = $laps;
        $this->finder->setFastest();
        $this->finder->setSlowest();
        $this->assertEquals(false, $this->finder->laps[0]->fastest);
        $this->assertEquals(false, $this->finder->laps[1]->fastest);
        $this->assertEquals(true, $this->finder->laps[2]->fastest);
        $this->assertEquals(false, $this->finder->laps[3]->fastest);

        $this->assertEquals(false, $this->finder->laps[0]->slowest);
        $this->assertEquals(true, $this->finder->laps[1]->slowest);
        $this->assertEquals(false, $this->finder->laps[2]->slowest);
        $this->assertEquals(false, $this->finder->laps[3]->slowest);
    }


    public function testGet1()
    {

        $this->finder->setData($this->get1Provider());
        $laps = $this->finder->get(10);

        $this->assertEquals(10, $laps[0]->distance);
        $this->assertEquals(1080, $laps[0]->duration);
        $this->assertEquals(false, $laps[0]->fastest);
        $this->assertEquals(false, $laps[0]->slowest);

        $this->assertEquals(10, $laps[1]->distance);
        $this->assertEquals(1440, $laps[1]->duration);
        $this->assertEquals(false, $laps[1]->fastest);
        $this->assertEquals(true, $laps[1]->slowest);

        $this->assertEquals(10, $laps[2]->distance);
        $this->assertEquals(360, $laps[2]->duration);
        $this->assertEquals(36, $laps[2]->pace);
        $this->assertEquals(100, $laps[2]->speed);
        $this->assertEquals(false, $laps[2]->fastest);
        $this->assertEquals(false, $laps[2]->slowest);

        $this->assertEquals(10, $laps[3]->distance);
        $this->assertEquals(180, $laps[3]->duration);
        $this->assertEquals(false, $laps[3]->fastest);
        $this->assertEquals(false, $laps[3]->slowest);

        $this->assertEquals(10, $laps[4]->distance);
        $this->assertEquals(10, $laps[4]->duration);
        $this->assertEquals(true, $laps[4]->fastest);
        $this->assertEquals(false, $laps[4]->slowest);

    }

    public function testGetWithLongPath()
    {
        $this->finder->setData($this->getArrayFromJsonFile('movesPath.json'));
        $laps = $this->finder->get(1);

        $this->assertEquals(1, $laps[0]->distance);
        $this->assertEquals(722, $laps[0]->duration);
        $this->assertEquals(false, $laps[0]->fastest);
        $this->assertEquals(true, $laps[0]->slowest);

        $this->assertEquals(1, $laps[1]->distance);
        $this->assertEquals(655, $laps[1]->duration);
        $this->assertEquals(true, $laps[1]->fastest);
        $this->assertEquals(false, $laps[1]->slowest);
    }

    private function get1Provider()
    {
        return [
            [
                'timestamp' => 0,
                'distance' => 0
            ],
            [
                'timestamp' => 360,
                'distance' => 1,
            ],
            [
                'timestamp' => 720,
                'distance' => 5
            ],
            [
                'timestamp' => 1080,
                'distance' => 10
            ],
            [
                'timestamp' => 1440,
                'distance' => 11
            ],
            [
                'timestamp' => 1800,
                'distance' => 12
            ],
            [
                'timestamp' => 2160,
                'distance' => 13
            ],
            [
                'timestamp' => 2520,
                'distance' => 20
            ],
            [
                'timestamp' => 2880,
                'distance' => 30
            ],
            [
                'timestamp' => 3060,
                'distance' => 40
            ],
            [
                'timestamp' => 3240,
                'distance' => 49
            ],
            [
                'timestamp' => 3070,
                'distance' => 50
            ]
        ];
    }

}
