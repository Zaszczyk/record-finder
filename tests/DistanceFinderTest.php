<?php
use MateuszBlaszczyk\RecordFinder\Finder\DistanceFinder;

class DistanceFinderTest extends PHPUnit_Framework_TestCase
{
    /** @var  DistanceFinder */
    public $finder;

    protected function setUp()
    {
        $this->finder = new DistanceFinder();
    }

    protected function tearDown()
    {
        $this->finder = null;
    }

    public function getArrayFromJsonFile($filename)
    {
        $json = file_get_contents(__DIR__ . '/data/' . $filename);
        return json_decode($json, true);
    }

    public function testFindRecord1KmInLongPath()
    {
        $finder = $this->finder->setData($this->getArrayFromJsonFile('longPath.json'));
        $record = $finder->findRecordByDistance(1);
        $this->assertInstanceOf('MateuszBlaszczyk\RecordFinder\Record\DistanceRecord', $record);
    }

    public function testFindRecord1KmInEndomondoPath()
    {
        $finder = $this->finder->setData($this->getArrayFromJsonFile('endomondoPath.json'));
        $record = $finder->findRecordByDistance(1);
        $this->assertInstanceOf('MateuszBlaszczyk\RecordFinder\Record\DistanceRecord', $record);
    }


    public function testFindRecord1KmInKrystianPath()
    {
        $finder = $this->finder->setData($this->getArrayFromJsonFile('krystianPath.json'));
        $record = $finder->findRecordByDistance(1);
        $this->assertTrue($record->measuredDistance >= 1);
        $this->assertTrue($record->seconds < 9999);
    }

    public static function shortPathProvider()
    {
        return [
            [[
                [
                    'timestamp' => 0,
                    'distance' => 0
                ],
                [
                    'timestamp' => 10,
                    'distance' => 1,
                ],
                [
                    'timestamp' => 12,
                    'distance' => 2
                ],
                [
                    'timestamp' => 15,
                    'distance' => 3
                ],
                [
                    'timestamp' => 19,
                    'distance' => 4
                ],
                [
                    'timestamp' => 25,
                    'distance' => 5
                ],
            ], 2, 1, 2, 1, 1, 10],
            [[
                [
                    'timestamp' => 0,
                    'distance' => 0
                ],
                [
                    'timestamp' => 10,
                    'distance' => 1,
                ],
                [
                    'timestamp' => 12,
                    'distance' => 2
                ],
                [
                    'timestamp' => 13,
                    'distance' => 3
                ],
                [
                    'timestamp' => 19,
                    'distance' => 4
                ],
                [
                    'timestamp' => 25,
                    'distance' => 5
                ],
            ], 1, 2, 3, 1, 2, 12],
            [[
                [
                    'timestamp' => 0,
                    'distance' => 0
                ],
                [
                    'timestamp' => 1,
                    'distance' => 1,
                ],
                [
                    'timestamp' => 10,
                    'distance' => 2
                ],
                [
                    'timestamp' => 15,
                    'distance' => 3
                ],
                [
                    'timestamp' => 20,
                    'distance' => 4
                ],
                [
                    'timestamp' => 25,
                    'distance' => 5
                ],
            ], 1, 0, 1, 1, 0, 0],
        ];
    }

    /**
     * @dataProvider shortPathProvider
     */
    public function testFindRecord1KmManualPath($data, $expectedSeconds, $expectedPointKeyStart, $expectedPointKeyEnd, $measuredDistance, $startDistance, $startTime)
    {
        $record = $this->finder->setData($data)->findRecordByDistance(1);
        $this->assertEquals(1, $record->distance);
        $this->assertEquals($expectedSeconds, $record->seconds);
        $this->assertEquals($expectedPointKeyStart, $record->pointKeyStart);
        $this->assertEquals($expectedPointKeyEnd, $record->pointKeyEnd);
        $this->assertEquals($measuredDistance, $record->measuredDistance);
        $this->assertEquals($startDistance, $record->recordDistanceStart);
        $this->assertEquals($startTime, $record->recordTimeStart);
    }
}
