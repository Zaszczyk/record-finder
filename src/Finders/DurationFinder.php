<?php

namespace MateuszBlaszczyk\RecordFinder\Finders;

use MateuszBlaszczyk\RecordFinder\Records\DurationRecord;

class DurationFinder extends Finder
{
    private $offset;

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
                    $record->pointKey = $key;
                } else {
                    $pointDistance = $point['distance'];
                    $pointTimestamp = $point['timestamp'];
                    $probablyRecord = 0;

                    for ($i = ($key - 1); $i > 0 && $pointTimestamp > 0; $i--) {
                        $delta = $pointTimestamp - ($this->offset + $this->data[$i]['timestamp']);
                        if ($delta >= $durationOfRecordInSeconds) {
                            $probablyRecord = $pointDistance - $this->data[$i]['distance'];
                            $probablyRecordTimeStart = ($this->data[$i]['timestamp'] - $this->offset);
                            $probablyRecordMeasuredDuration = $delta;
                            break;
                        }
                    }

                    if ($this->isProbablyRecordBetterThanActual($probablyRecord, $record)) {
                        $record->distance = $probablyRecord;
                        $record->pointKey = $key;
                        $record->recordTimeStart = $probablyRecordTimeStart;
                        $record->measuredDistance = $probablyRecordMeasuredDuration;
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

    public function getOffset()
    {
        $firstElement = array_values($this->data)[0];
        return $firstElement['timestamp'];
    }
}