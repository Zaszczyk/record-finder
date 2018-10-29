<?php

namespace MateuszBlaszczyk\RecordFinder\Record;


class DistanceRecordStack
{
    /** @var array Record[] */
    protected $records = [];

    public function push(DistanceRecord $s)
    {
        $this->records[] = $s;
    }

    public function pop(): ?DistanceRecord
    {
        return array_pop($this->records);
    }

    public function peek(): ?DistanceRecord
    {
        return end(array_values($this->records));
    }

    public function isempty()
    {
        return empty($this->records);
    }

    public function getRecords(): array
    {
        $this->sort();
        return $this->records;
    }

    /**
     * By the least seconds
     */
    protected function sort(): void
    {
        usort($this->records, function (DistanceRecord $a, DistanceRecord $b) {
            return $a->seconds < $b->seconds;
        });
    }
}