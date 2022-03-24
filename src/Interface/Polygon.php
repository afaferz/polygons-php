<?php

namespace Polygons\Php\Interface;

interface Polygon
{
    public function calculateDiagonals(): void;
    public function calculateSumOfAngles(): void;
    public function calculatePerimeter(): void;
    public function calculateArea(): void;
}
