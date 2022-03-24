<?php

namespace Polygons\Php\Traits;

trait GetterProps
{
    public function __get(string $attr): string
    {
        $method = 'get' . ucfirst($attr);
        return $this->$method();
    }
}
