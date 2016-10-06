<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 24.04.2016
 * Time: 23:32
 */

namespace MateuszBlaszczyk\RecordFinder;


class Record
{
    public $measuredDistance = null;

    public $distance = null;

    public $seconds = null;

    public $pointKey = null;

    public $distanceStart = null;

    /**
     * Record constructor.
     * @param null $distance
     */
    public function __construct($distance)
    {
        $this->distance = $distance;
    }
}