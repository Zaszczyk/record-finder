<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class GeneralFinder extends AbstractFinder
{
    public function findRecordByDistance($distanceOfRecordInKm)
    {
        $finder = new DistanceFinder();
        return $finder->findRecordByDistance($distanceOfRecordInKm);
    }

    public function findRecordByTime($durationOfRecordInSeconds)
    {
        $finder = new DurationFinder();
        return $finder->findRecordByTime($durationOfRecordInSeconds);
    }
}