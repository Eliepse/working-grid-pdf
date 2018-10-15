<?php


namespace Eliepse\WorkingGrid\Template;


use Eliepse\WorkingGrid\Config\GridConfig;
use Eliepse\WorkingGrid\Config\PageConfig;
use Eliepse\WorkingGrid\WorkingGrid;

class Template
{
    /** @var string $title The title of the document */
    public $title;

    /** @var int|null $row_max The number of lines per page. Inluence the size of cells in order to fit all lines */
    public $row_max;

    /** @var int $columns_amount */
    public $columns_amount = 9;

    /** @var int $model_amount */
    public $model_amount;

    /** @var float $tutorial_size The size, in millimeters, of characters for the helping stroke orders (if activated) */
    public $tutorial_height = 6;

    /** @var string $stroke_color Set the color of the first drawn character */
    public $stroke_color = "#333333";

    /** @var string $model_color Set the color the characters dranw as models */
    public $model_color = "#b3b3b3";

    /** @var string $guide_color Set the color of guide strokes (background) */
    public $guide_color = "#b3b3b3";

    public $header_height;

    public $footer_height;

    public $paddings;


    public function generate(array $words = []): WorkingGrid
    {
        return (new WorkingGrid($this->title, $this->extractGridConfig(), $this->extractPageConfig(), $this))
            ->addWords($words);
    }


    /**
     * @return GridConfig
     */
    private function extractGridConfig(): GridConfig
    {
        return new GridConfig([
            "draw_tutorial"   => boolval(array_keys(class_implements($this), WithDrawingTutorial::class, true)),
            "tutorial_height" => $this->tutorial_height,
            "columns_amount"  => $this->columns_amount,
            "models_amount"   => $this->model_amount,
            "row_max"         => $this->row_max,]);
    }


    /**
     * @return PageConfig
     */
    private function extractPageConfig(): PageConfig
    {
        $config = new PageConfig([
            "header_height" => $this->header_height,
            "footer_height" => $this->footer_height,]);

        if (is_array($this->paddings) && count($this->paddings) > 0) {

            $config->setPaddings($this->paddings[0] ?? null,
                $this->paddings[1] ?? null,
                $this->paddings[2] ?? null,
                $this->paddings[3] ?? null);

        }

        return $config;
    }


}