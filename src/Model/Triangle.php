<?php

namespace Polygons\Php\Model;

use Polygons\Php\Model\TypePolygons\SimplePolygon;
use Polygons\Php\Traits\GetterProps;

final class Triangle extends SimplePolygon
{
    use GetterProps;
    public const SIDES = 3;
    private array $valuesOfSides;
    private bool $validTriangle;
    private string $type;
    private float|int $area;

    public function __construct(array $valuesOfSides)
    {
        parent::__construct(self::SIDES, $valuesOfSides);
        $this->valuesOfSides = $valuesOfSides;
        $this->isValid();
        if (!$this->validTriangle) {
            exit();
        }
        self::calculateArea();
    }
    public function calculateArea(): void
    {
        [$A, $B, $C] = $this->valuesOfSides;
        $semiperimeter = array_sum($this->valuesOfSides) / 2;

        $this->area = sqrt($semiperimeter * ($semiperimeter - $A) * ($semiperimeter - $B) * ($semiperimeter - $C));
    }

    public function getArea(): float|int
    {
        return $this->area;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function executeAll(): void
    {
        self::calculateArea();
        parent::calculatePerimeter();
        parent::calculateDiagonals();
        parent::calculateSumOfAngles();
    }

    private function setType(): void
    {
        [$A, $B, $C] = $this->valuesOfSides;

        $equilateral = $A == $B && $B == $C;
        $isosceles = $A == $B || $A == $C || $B == $C;
        $right = $A ** 2 + $B ** 2 == $C ** 2;
        $scalene = $A != $B && $B != $C && $A != $C;

        if ($equilateral) {
            $this->type = "Equilateral";
            return;
        };
        if ($isosceles) {
            $this->type = "Isosceles";
            return;
        };
        if (!$right && $scalene) {
            $this->type = "Scalene";
            return;
        };
        if ($right && $scalene) {
            $this->type = "Right";
            return;
        };
    }
    protected function isValid(): bool
    {
        [$A, $B, $C] = $this->valuesOfSides;

        $conditional1 = ($A + $B) > $C;
        $conditional2 = ($A + $C) > $B;
        $conditional3 = ($B + $C) > $A;

        if ($conditional1 && $conditional2 && $conditional3) {
            $this->validTriangle = true;
            $this->setType();
            return true;
        } else {
            echo "Os valores não formam um triângulo" . PHP_EOL;
            $this->validTriangle = false;
            return false;
        }
    }
}
