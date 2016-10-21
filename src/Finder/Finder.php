<?php

namespace MateuszBlaszczyk\RecordFinder\Finder;

class Finder
{
    protected $data;

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
}