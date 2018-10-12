<?php


namespace Eliepse\WorkingGrid;


class WorkingGrid extends WorkingGridBase
{
    /** @var int $headerHeight Set the header height in millimeters */
    public $headerHeight = 0;

    /** @var int $footerHeight Set the footer height in millimeters */
    public $footerHeight = 0;

    /** @var bool $withStrokeOrder Determine if you want to show helps for writing character in the right order */
    public $withStrokeOrder;

    /** @var int $columns The number of cells (columns) per line, influence the size of cells */
    public $columns;

    /** @var int $models The number of cells that keep a light gray character as a helping model */
    public $models;

    /** @var int|null $linesPerPage The number of lines per page. Inluence the size of cells in order to fit all lines */
    public $linesPerPage;

    /** @var float $strokeOrderSize The size, in millimeters, of characters for the helping stroke orders (if activated) */
    public $strokeOrderSize = 5.33;

    /** @var string $strokeColor Set the color of the first drawn character */
    public $strokeColor = "#333333";

    /** @var string $modelColor Set the color the characters dranw as models */
    public $modelColor = "#b3b3b3";

    /** @var string $guideColor Set the color of guide strokes (background) */
    public $guideColor = "#b3b3b3";


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