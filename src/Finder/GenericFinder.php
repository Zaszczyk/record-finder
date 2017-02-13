<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class GenericFinder
{
    public function findRecordByDistance($distanceOfRecordInKm, $data)
    {
        $finder = new DistanceFinder();
        try {
            $finder->setData($data);
            return $finder->findRecordByDistance($distanceOfRecordInKm);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    public function findRecordByTime($durationOfRecordInSeconds, $data)
    {
        $finder = new DurationFinder();
        try {
            $finder->setData($data);
            return $finder->findRecordByTime($durationOfRecordInSeconds);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }
}