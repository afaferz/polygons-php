<?php

namespace Polygons\Php\Model;

use Polygons\Php\Model\TypePolygons\SimplePolygon;
use Polygons\Php\Traits\GetterProps;

final class Rectangle extends SimplePolygon
{
    use GetterProps;
    public const SIDES = 4;
    private array $valuesOfSides;
    private bool $validRectangle;
    private float|int $area;

    public function __construct(array $valuesOfSides)
    {
        parent::__construct(self::SIDES, $valuesOfSides);
        $this->valuesOfSides = $valuesOfSides;
        $this->isValid();
        if (!$this->validRectangle) {
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
            echo "Invalid values to create a rectangle" . PHP_EOL;
            $this->validRectangle = false;
            return false;
        }

        $validRectangleWithUniqValues = array_unique($this->valuesOfSides);

        if (count($validRectangleWithUniqValues) != 2) {
            echo "Invalid values to create a rectangle" . PHP_EOL;
            $this->validRectangle = false;
            return false;
        }

        $this->validRectangle = true;
        return true;
    }
}
