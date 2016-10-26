<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class GenericFinder
{
    public function findRecordByDistance($distanceOfRecordInKm, $data)
    {
        $finder = new DistanceFinder();
        $finder->setData($data);
        return $finder->findRecordByDistance($distanceOfRecordInKm);
    }

    public function findRecordByTime($durationOfRecordInSeconds, $data)
    {
        $finder = new DurationFinder();
        $finder->setData($data);
        return $finder->findRecordByTime($durationOfRecordInSeconds);
    }
}