<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

use MateuszBlaszczyk\RecordFinder\Record\Lap;

class LapsFinder extends AbstractFinder
{
    /** @var Lap[] */
    public $laps = [];

    public function get($groupBy)
    {
        $offset = $this->getOffset();
        $this->laps = [];

        $lastLappedDistance = 0;
        $startingDuration = 0;
        foreach ($this->data as $key => $point) {
            if (is_numeric($point['timestamp']) && $point['distance'] - $lastLappedDistance >= $groupBy) {
                $this->laps[] = $this->createLap($this->getDurationDelta($startingDuration, $point['timestamp'] - $offset), $groupBy);
                $startingDuration = $point['timestamp'] - $offset;
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
        if (count($this->laps) <= 1) {
            return false;
        }

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
        if (count($this->laps) <= 1) {
            return false;
        }

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
        if ($distanceInKm == 0) {
            return '-';
        }
        return round($durationInSeconds / $distanceInKm, 3);
    }

    public function countSpeedInKmh($durationInSeconds, $distanceInKm)
    {
        if ($durationInSeconds == 0) {
            return '-';
        }
        return round(($distanceInKm / $durationInSeconds) * 3600, 3);
    }

}