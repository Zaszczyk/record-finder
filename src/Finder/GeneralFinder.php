<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class GeneralFinder extends AbstractFinder
{
    public function findRecordByDistance($distanceOfRecordInKm)
    {
        $finder = new DistanceFinder();
        $finder->setData($this->data);
        return $finder->findRecordByDistance($distanceOfRecordInKm);
    }

    public function findRecordByTime($durationOfRecordInSeconds)
    {
        $finder = new DurationFinder();
        $finder->setData($this->data);
        return $finder->findRecordByTime($durationOfRecordInSeconds);
    }
}