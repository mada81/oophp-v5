<?php

namespace Mada\Dice;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
    * Add the serie.
    *
    * @return array with the serie.
    */
    public function addSerie($point)
    {
        array_push($this->serie, $point);
    }



    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function getAsText() : string
    {
        $result = "";
        $allRoll = $this->getSerie();

        $keys = array("1", "2", "3", "4", "5", "6");
        $face = array_fill_keys($keys, 0);

        foreach ($allRoll as $key => $value) {
            $face[$value] ++;
        }
        ksort($face);

        foreach ($face as $key => $value) {
            $starString = str_repeat("*", $value);
            $result = $result . $key . ": " . $starString . "<br>";
        }
        return $result;
    }
}
