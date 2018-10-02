<?php


namespace Eliepse\WorkingGrid;


class WorkingGrid extends WorkingGridBase
{
    public $headerHeight = 0;
    public $footerHeight = 0;
    public $withStrokeOrder;
    public $columns;
    public $models;
    public $linesPerPage;
    public $strokeOrderSize = 5.33;


    /**
     * WorkingGrid constructor.
     * @param string $title
     * @param bool $withStrokeOrder
     * @param int $columns
     * @param int|null $linesPerPage
     */
    public function __construct(string $title, bool $withStrokeOrder = false, int $columns = 9, int $linesPerPage = null)
    {
        $this->title = $title;
        $this->withStrokeOrder = $withStrokeOrder;
        $this->columns = $columns;
        $this->linesPerPage = $linesPerPage;
    }

}