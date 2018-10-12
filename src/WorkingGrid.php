<?php


namespace Eliepse\WorkingGrid;


class WorkingGrid extends WorkingGridBase
{
    /** @var int $headerHeight */
    public $headerHeight = 0;

    /** @var int $footerHeight */
    public $footerHeight = 0;

    /** @var bool $withStrokeOrder */
    public $withStrokeOrder;

    /** @var int $columns */
    public $columns;

    /** @var int $models */
    public $models;

    /** @var int|null $linesPerPage */
    public $linesPerPage;

    /** @var float $strokeOrderSize */
    public $strokeOrderSize = 5.33;


    /**
     * WorkingGrid constructor.
     * @param string $title The title of the document
     * @param bool $withStrokeOrder Determine if a helping line with the stroke order has to be drawn or not
     * @param int $columns The number of columns (or cells) to draw per line
     * @param int|null $linesPerPage The maximum number of lines per page. This can affect the size of the content to let
     * it fit. When set to null, the number of page automatically calculated
     */
    public function __construct(string $title, bool $withStrokeOrder = false, int $columns = 9, int $linesPerPage = null)
    {
        $this->title = $title;
        $this->withStrokeOrder = $withStrokeOrder;
        $this->columns = $columns;
        $this->linesPerPage = $linesPerPage;
    }

}