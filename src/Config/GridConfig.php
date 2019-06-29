<?php


namespace Eliepse\WorkingGrid\Config;


use Eliepse\WorkingGrid\FillAttributes;

class GridConfig
{
    use FillAttributes;

    /** @var bool $draw_tutorial Determine if you want to show helps for writing character in the right order */
    public $draw_tutorial = false;

    /** @var int $columns_amount The number of columns per line (influence the size of the grid) */
    public $columns_amount;

    /** @var int|null $lines_max The number of lines per page. Inluence the size of cells in order to fit all lines */
    public $lines_max;

    /** @var int $models_amount The number of cells that keep a light gray character as a helping model */
    public $models_amount;

    /** @var string $stroke_color Set the color of the first drawn character */
    public $stroke_color = "#333333";

    /** @var string $model_color Set the color the characters drawn as models */
    public $model_color = "#b3b3b3";

    /** @var string $guide_color Set the color of guide strokes (background) */
    public $guide_color = "#b3b3b3";

    /** @var string $grid_color Set the color of the grid */
    public $grid_color = "#333333";

    /** @var int $tutorial_height Set the size of the tutorial strokes */
    public $tutorial_height = 6;

    /** @var bool $pinyin Determine if you want to show pinyin of caracters */
    public $pinyin = false;


    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }


    public function getWordsPerPage(PageConfig $page_config)
    {
        // If line not defined, find an adapted number of row per page
        return max(floor($page_config->getBodyHeight() / $this->getRowHeight($page_config)), 1);
    }


    public function getUnitSize(PageConfig $page_config): float
    {
        $ratioPerWidth = $page_config->getBodyWidth() / $this->columns_amount;

        $ratioPerMaxLine = ($page_config->getBodyHeight() / ($this->lines_max ?? 1)) - $this->getTutorialHeight();

        return min($ratioPerWidth, $ratioPerMaxLine);
    }


    public function getRowHeight(PageConfig $page_config): float
    {
        return $this->getUnitSize($page_config) + $this->getTutorialHeight();
    }


    public function getTutorialHeight(): float
    {
        return $this->draw_tutorial || $this->pinyin ? $this->tutorial_height : 0;
    }

}