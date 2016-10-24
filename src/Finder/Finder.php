<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class Finder
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
        return $this;
    }

    public function setJsonData($json)
    {
        $this->data = json_decode($json, true);
        return $this;
    }

    public function getOffset()
    {
        $firstElement = array_values($this->data)[0];
        return $firstElement['timestamp'];
    }
}