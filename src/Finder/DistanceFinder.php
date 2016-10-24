<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

use MateuszBlaszczyk\RecordFinder\Record\DistanceRecord;

class DistanceFinder extends Finder
{
    public function findRecordByDistance($distanceOfRecordInKm)
    {
        $record = new DistanceRecord($distanceOfRecordInKm);

        $this->offset = $this->getOffset();

        if (!$this->isDistanceGreaterThanLookingRecord($distanceOfRecordInKm)) {
            return null;
        }

        foreach ($this->data as $key => $point) {
            if ($point['distance'] >= $distanceOfRecordInKm) {
                if ($this->isItFirstIteration($record)) {
                    $record->seconds = $point['timestamp'];
                    $record->pointKey = $key;
                    $record->recordDistanceStart = 0;
                    $record->recordTimeStart = 0;
                    $record->measuredDistance = $point['distance'];
                } else {
                    $pointDistance = $point['distance'];
                    $pointTimestamp = $point['timestamp'];
                    $probablyRecord = 0;

                    for ($i = ($key - 1); $i > 0 && $pointDistance > 0; $i--) {
                        $delta = $pointDistance - $this->data[$i]['distance'];
                        if ($delta >= $distanceOfRecordInKm) {
                            $probablyRecord = $pointTimestamp - $this->data[$i]['timestamp'];
                            $probablyRecordDistanceStart = $this->data[$i]['distance'];
                            $probablyRecordTimeStart = ($this->data[$i]['timestamp'] - $this->offset);
                            $probablyRecordMeasuredDistance = $delta;
                            break;
                        }
                    }

                    if ($this->isProbablyRecordBetterThanActual($probablyRecord, $record)) {
                        $record->seconds = $probablyRecord;
                        $record->pointKey = $key;
                        $record->recordDistanceStart = $probablyRecordDistanceStart;
                        $record->recordTimeStart = $probablyRecordTimeStart;
                        $record->measuredDistance = $probablyRecordMeasuredDistance;
                    }
                }
            }
        }

        return $record;
    }

    public function isProbablyRecordBetterThanActual($probablyRecord, DistanceRecord $record)
    {
        return $probablyRecord > 0 && $probablyRecord < $record->seconds;
    }

    public function isItFirstIteration(DistanceRecord $record)
    {
        return $record->seconds === null;
    }

    public function isDistanceGreaterThanLookingRecord($distanceOfRecordInKm)
    {
        $array = array_slice($this->data, -1);
        $lastElement = array_pop($array);
        return $lastElement['distance'] >= $distanceOfRecordInKm;
    }
}