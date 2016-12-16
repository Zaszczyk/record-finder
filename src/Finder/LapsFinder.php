<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

use MateuszBlaszczyk\RecordFinder\Record\Lap;

class LapsFinder extends AbstractFinder
{
    /** @var Lap[] */
    public $laps = [];

    public function get($groupBy)
    {
        $this->laps = [];

        $lastLappedDistance = 0;
        $startingDuration = 0;
        foreach ($this->data as $key => $point) {

            if ($point['distance'] - $lastLappedDistance >= $groupBy) {
                $this->laps[] = $this->createLap($this->getDurationDelta($startingDuration, $point['timestamp']), $groupBy);
                $startingDuration = $point['timestamp'];
                $lastLappedDistance = $point['distance'];
            }
        }

        $this->setFastest();
        $this->setSlowest();

        return $this->laps;
    }

    public function getDurationDelta($startingDuration, $nowDuration)
    {
        return $nowDuration - $startingDuration;
    }

    public function createLap($duration, $distance)
    {
        $lap = new Lap($duration, $distance);
        $lap->pace = $this->countPace($duration, $distance);
        $lap->speed = $this->countSpeedInKmh($duration, $distance);

        return $lap;
    }

    public function setFastest()
    {
        $fastestLap = null;
        foreach ($this->laps as $lap) {
            if ($lap->duration !== null && ($fastestLap === null || $fastestLap->duration > $lap->duration)) {
                if ($fastestLap) {
                    $fastestLap->fastest = false;
                }

                $lap->fastest = true;
                $fastestLap = $lap;
            }
        }
    }

    public function setSlowest()
    {
        $slowestLap = null;
        foreach ($this->laps as $lap) {
            if ($lap->duration !== null && ($slowestLap === null || $slowestLap->duration < $lap->duration)) {
                if ($slowestLap) {
                    $slowestLap->slowest = false;
                }

                $lap->slowest = true;
                $slowestLap = $lap;
            }
        }
    }

    public function countPace($durationInSeconds, $distanceInKm)
    {
        return round($durationInSeconds / $distanceInKm, 3);
    }

    public function countSpeedInKmh($durationInSeconds, $distanceInKm)
    {
        return round(($distanceInKm / $durationInSeconds) * 3600, 3);
    }

}