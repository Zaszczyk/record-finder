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

    /*public function testFindRecord1KmInLongPath()
    {
        $finder = new Finder($this->getArrayFromJsonFile('longPath.json'));
        $record = $finder->findRecord(1);
        $this->assertInstanceOf('MateuszBlaszczyk\RecordFinder\Record', $record);
    }*/

    public function testFindRecord1KmInEndomondoPath()
    {
        $finder = $this->finder->setData($this->getArrayFromJsonFile('endomondoPath.json'));
        $record = $finder->findRecordByDistance(1);
        $this->assertInstanceOf('MateuszBlaszczyk\RecordFinder\Record\DistanceRecord', $record);
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
            ], 2, 2, 1, 1],
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
            ], 1, 3, 1, 2],
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
            ], 1, 1, 1, 0],
        ];
    }

    /**
     * @dataProvider shortPathProvider
     */
    public function testFindRecord1KmManualPath($data, $expectedSeconds, $expectedPointKey, $measuredDistance, $startDistance)
    {
        $record = $this->finder->setData($data)->findRecordByDistance(1);
        $this->assertEquals(1, $record->distance);
        $this->assertEquals($expectedSeconds, $record->seconds);
        $this->assertEquals($expectedPointKey, $record->pointKey);
        $this->assertEquals($measuredDistance, $record->measuredDistance);
        $this->assertEquals($startDistance, $record->distanceStart);
    }
}
