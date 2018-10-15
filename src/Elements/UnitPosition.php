<?php


namespace Eliepse\WorkingGrid\Elements;


trait UnitPosition
{
    /**
     * @var int
     */
    protected $x;

    /**
     * @var int
     */
    protected $y;


    public function getX(): int { return $this->x; }


    public function getY(): int { return $this->y; }
}