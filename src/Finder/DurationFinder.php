<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

use MateuszBlaszczyk\RecordFinder\Record\DurationRecord;

class DurationFinder extends AbstractFinder
{
    public function findRecordByTime($durationOfRecordInSeconds)
    {
        $record = new DurationRecord($durationOfRecordInSeconds);

        $this->offset = $this->getOffset();

        if (!$this->isDurationGreaterThanLookingRecord($durationOfRecordInSeconds)) {
            return null;
        }

        foreach ($this->data as $key => $point) {
            if ($point['timestamp'] >= ($this->offset + $durationOfRecordInSeconds)) {
                if ($this->isItFirstIteration($record)) {
                    $record->distance = $point['distance'];
                    $record->pointKeyStart = 0;
                    $record->pointKeyEnd = $key;
                    $record->recordTimeStart = 0;
                    $record->recordDistanceStart = 0;
                    $probablyRecordMeasuredDuration = ($point['timestamp'] - $this->offset);
                } else {
                    $pointDistance = $point['distance'];
                    $pointTimestamp = $point['timestamp'];
                    $probablyRecord = 0;

                    for ($i = ($key - 1); $i > 0 && $pointTimestamp > 0; $i--) {
                        $delta = $pointTimestamp - ($this->offset + $this->data[$i]['timestamp']);
                        if ($delta >= $durationOfRecordInSeconds) {
                            $probablyRecord = $pointDistance - $this->data[$i]['distance'];
                            $probablyRecordTimeStart = ($this->data[$i]['timestamp'] - $this->offset);
                            $probablyRecordDistanceStart = $this->data[$i]['distance'];
                            $probablyRecordPointKeyStart = $i;
                            $probablyRecordMeasuredDuration = $delta;
                            break;
                        }
                    }

                    if ($this->isProbablyRecordBetterThanActual($probablyRecord, $record)) {
                        $record->distance = $probablyRecord;
                        $record->pointKeyStart = $probablyRecordPointKeyStart;
                        $record->pointKeyEnd = $key;
                        $record->recordTimeStart = $probablyRecordTimeStart;
                        $record->recordDistanceStart = $probablyRecordDistanceStart;
                        $record->measuredDuration = $probablyRecordMeasuredDuration;
                    }
                }
            }
        }

        return $record;
    }

    public function isProbablyRecordBetterThanActual($probablyRecord, DurationRecord $record)
    {
        return $probablyRecord > 0 && $probablyRecord > $record->distance;
    }

    public function isItFirstIteration(DurationRecord $record)
    {
        return $record->distance === null;
    }

    public function isDurationGreaterThanLookingRecord($durationOfRecordInSeconds)
    {
        $array = array_slice($this->data, -1);
        $lastElement = array_pop($array);
        return $lastElement['timestamp'] >= ($this->offset + $durationOfRecordInSeconds);
    }
}