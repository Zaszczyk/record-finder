<?php

namespace MateuszBlaszczyk\RecordFinder\Record;

class DurationRecord extends Record
{
    public $measuredDuration = null;

    /**
     * RecordByDuration constructor.
     * @param null $duration
     */
    public function __construct($duration)
    {
        $this->seconds = $duration;
    }
}