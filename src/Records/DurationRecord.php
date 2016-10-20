<?php

namespace MateuszBlaszczyk\RecordFinder\Records;

class DurationRecord extends Record
{
    public $measuredDuration = null;
    public $recordTimeStart = null;

    /**
     * RecordByDuration constructor.
     * @param null $duration
     */
    public function __construct($duration)
    {
        $this->seconds = $duration;
    }
}