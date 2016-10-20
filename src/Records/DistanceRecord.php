<?php

namespace MateuszBlaszczyk\RecordFinder\Records;

class DistanceRecord extends Record
{
    public $measuredDistance = null;
    public $distanceStart = null;

    /**
     * RecordByDistance constructor.
     * @param null $distance
     */
    public function __construct($distance)
    {
        $this->distance = $distance;
    }
}