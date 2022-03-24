<?php

namespace Polygons\Php\Model;

use Polygons\Php\Model\TypePolygons\SimplePolygon;
use Polygons\Php\Traits\GetterProps;

final class Square extends SimplePolygon
{
    use GetterProps;
    public const SIDES = 4;
    private array $valuesOfSides;
    private bool $validSquare;
    private float|int $area;

    public function __construct(array $valuesOfSides)
    {
        parent::__construct(self::SIDES, $valuesOfSides);
        $this->valuesOfSides = $valuesOfSides;
        $this->isValid();
        if (!$this->validSquare) {
            exit();
        }
    }
    public function calculateArea(): void
    {
        $this->area = array_sum($this->valuesOfSides);
    }

    public function getArea(): float|int
    {
        return $this->area;
    }

    public function executeAll(): void
    {
        self::calculateArea();
        parent::calculatePerimeter();
        parent::calculateDiagonals();
        parent::calculateSumOfAngles();
    }

    protected function isValid(): bool
    {
        if (count($this->valuesOfSides) != 4) {
            echo "Invalid values to create a square" . PHP_EOL;
            $this->validSquare = false;
            return false;
        }

        $validSquareWithUniqValues = array_unique($this->valuesOfSides);
        
        if (count($validSquareWithUniqValues) != 1) {
            echo "Invalid values to create a square" . PHP_EOL;
            $this->validSquare = false;
            return false;
        }

        $this->validSquare = true;
        return true;
    }
}
