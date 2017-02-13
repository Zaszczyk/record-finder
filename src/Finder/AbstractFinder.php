<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

abstract class AbstractFinder
{
    protected $data;

    protected $offset;

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        if (count($this->data) < 1) {
            throw new \InvalidArgumentException('Data of path is empty.');
        }
        return $this;
    }

    public function setJsonData($json)
    {
        $this->data = json_decode($json, true);
        if (count($this->data) < 1) {
            throw new \InvalidArgumentException('Data of path is empty.');
        }
        return $this;
    }

    public function getOffset()
    {
        $firstElement = array_values($this->data)[0];
        return $firstElement['timestamp'];
    }
}