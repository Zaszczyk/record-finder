<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class GenericFinder
{
    public $finder;

    public function findRecordByDistance($distanceOfRecordInKm)
    {
        $this->finder = new DistanceFinder();
        return $this->finder->findRecordByDistance($distanceOfRecordInKm);
    }

    public function findRecordByTime($durationOfRecordInSeconds)
    {
        $this->finder = new DurationFinder();
        return $this->finder->findRecordByTime($durationOfRecordInSeconds);
    }
}