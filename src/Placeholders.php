<?php

namespace Tylercd100\Placeholders;

use Exception;

class Placeholders
{
    protected $replacements = [];
    protected $config = [];
    protected $start;
    protected $end;
    protected $thorough;

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * Sets a global replacement for a placeholder
     * @param string $string The placeholder to set a value for
     * @param mixed  $value  The value to replace it with
     */
    public function set($string, $value)
    {
        $this->replacements[$string] = (string) $value;
    }

    /**
     * Checks a string for placeholders and then replaces them with the appropriate values
     * @param  string $string       A string containing placeholders
     * @param  array  $replacements An array of key/value replacements
     * @return string               The new string
     */
    public function parse($string, $replacements = [])
    {
        $replacements = array_merge($this->replacements, $replacements);
        foreach ($replacements as $key => $val) {
            $string = str_ireplace($this->getStart().$key.$this->getEnd(), $val, $string);
        }

        $this->catchSkippedPlaceholders($string);

        return $string;
    }

    /**
     * Checks for any placeholders that are in the
     * string and then throws an Exception if one exists
     * @param  string $string The string to check
     */
    protected function catchSkippedPlaceholders(string $string)
    {
        if ($this->getThorough() === true) {
            $matches = [];
            $pattern = "/".$this->getStart(true).".*?".$this->getEnd(true)."/";
            preg_match($pattern, $string, $matches);

            if (count($matches) > 0) {
                throw new Exception("Could not find a replacement for ".$matches[0], 1);
            }
        }
    }

    public function setStyle($start, $end)
    {
        $this->setStart($start);
        $this->setEnd($end);
    }

    public function setThorough($x)
    {
        $this->thorough = $x;
    }

    public function setStart($x)
    {
        $this->start = $x;
    }

    public function setEnd($x)
    {
        $this->end = $x;
    }

    public function getThorough()
    {
        return isset($this->thorough) ? $this->thorough : $this->config['thorough'];
    }

    public function getStart($escaped = false)
    {
        $x = $this->start ? $this->start : $this->config['start'];
        return $escaped ? preg_quote($x) : $x;
    }

    public function getEnd($escaped = false)
    {
        $x = $this->end ? $this->end : $this->config['end'];
        return $escaped ? preg_quote($x) : $x;
    }
}
