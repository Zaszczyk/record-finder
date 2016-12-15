<?php

namespace MateuszBlaszczyk\RecordFinder\Record;


class Lap
{
    public $duration = null;

    public $distance = null;

    public $fastest = false;

    public $slowest = false;

    public $pace = null;

    public $speed = null;

    /**
     * Lap constructor.
     * @param null $duration
     * @param null $distance
     */
    public function __construct($duration, $distance)
    {
        $this->duration = $duration;
        $this->distance = $distance;
    }
}