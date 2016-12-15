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
                $this->laps[] = new Lap($this->getDurationDelta($startingDuration, $point['timestamp']), $groupBy);
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
        $lap->speed = $this->countSpeed($duration, $distance);
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

    public function countPace($duration, $distance)
    {
        return round($duration / $distance, 3);
    }

    public function countSpeed($duration, $distance)
    {
        return round($distance / $duration, 3);
    }

}