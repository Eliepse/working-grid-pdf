<?php


namespace Eliepse\WorkingGrid;


use Eliepse\WorkingGrid\Elements\UnitPosition;

class Cell
{
    use UnitPosition;


    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }


    public function getStrokes(): array
    {
        return null;
    }
}