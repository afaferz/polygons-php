<?php

namespace Polygons\Php\Model\TypePolygons;

use Polygons\Php\Interface\Polygon;
use Polygons\Php\Traits\GetterProps;

abstract class SimplePolygon implements Polygon
{
    use GetterProps;
    private int $numberOfSides;
    private array $valuesOfSides;

    private int $numberOfDiagonals;
    private int $sumOfAngles;
    private float|int $perimeter;

    public function __construct(int $numberOfSides, array $valuesOfSides)
    {
        if ($numberOfSides < 3) {
            // throw new Exception("It's not a polygon", 1);
            echo "It's not a polygon" . PHP_EOL;
            exit();
        }
        $this->numberOfSides = $numberOfSides;
        $this->valuesOfSides = $valuesOfSides;
    }

    public function calculateDiagonals(): void
    {
        $this->numberOfDiagonals = ($this->numberOfSides * ($this->numberOfSides - 3)) / 2;
    }

    public function calculateSumOfAngles(): void
    {
        $this->sumOfAngles = ($this->numberOfSides - 2) * 180;
    }

    public function calculatePerimeter(): void
    {
        $this->perimeter = array_sum($this->valuesOfSides);
    }

    public function getNumberOfDiagonals(): int
    {
        return $this->numberOfDiagonals;
    }

    public function getSumOfAngles(): int
    {
        return $this->sumOfAngles;
    }

    public function getPerimeter(): int|float
    {
        return $this->perimeter;
    }

    abstract function calculateArea(): void;

    abstract protected function isValid(): bool;
}
