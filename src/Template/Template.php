<?php


namespace Eliepse\WorkingGrid\Template;


use Eliepse\WorkingGrid\Config\GridConfig;
use Eliepse\WorkingGrid\Config\PageConfig;
use Eliepse\WorkingGrid\WorkingGrid;

class Template
{
	/**
	 * @var string $title The title of the document
	 */
	public $title;

	/**
	 * @var int $columns_amount
	 */
	public $columns_amount = 9;

	/**
	 * @var int $model_amount
	 */
	public $model_amount = 3;

	/**
	 * @var float $tutorial_size The size, in millimeters, of characters for the helping stroke orders (if activated)
	 */
	public $tutorial_height = 6;

	/**
	 * @var string $tutorial_color Set the color of the tutorial strokes
	 */
	public $tutorial_color = "#333333";

	/**
	 * @var string $stroke_color Set the color of the first drawn character
	 */
	public $stroke_color = "#333333";

	/**
	 * @var string $model_color Set the color the characters drawn as models
	 */
	public $model_color = "#b3b3b3";

	/**
	 * @var string $grid_color Set the color of the grid
	 */
	public $grid_color = "#333333";

	/**
	 * @var string $guide_color Set the color of guide strokes (background)
	 */
	public $guide_color = "#b3b3b3";

	/**
	 * @var float $header_height Set the header height in millimeters
	 */
	public $header_height;

	/**
	 * @var float Set the footer height in millimeters
	 */
	public $footer_height;

	/**
	 * @var array Set the padding of pages in millimeters. Formated as CSS : top, right, bottom, left
	 */
	public $paddings;


	public function generate(array $words = []): WorkingGrid
	{
		return (new WorkingGrid($this->title, $this->extractGridConfig(), $this))->addWords($words);
	}


	/**
	 * @return GridConfig
	 */
	private function extractGridConfig(): GridConfig
	{
		return new GridConfig(
			$this->extractPageConfig(),
			[
				"draw_tutorial" => boolval(array_keys(class_implements($this), WithDrawingTutorial::class, true)),
				"pinyin" => boolval(array_keys(class_implements($this), WithPinyin::class, true)),
				"tutorial_height" => $this->tutorial_height,
				"columns_amount" => $this->columns_amount,
				"models_amount" => $this->model_amount,
				"tutorial_color" => $this->tutorial_color,
				"stroke_color" => $this->stroke_color,
				"model_color" => $this->model_color,
				"guide_color" => $this->guide_color,
				"grid_color" => $this->grid_color,]
		);
	}


	/**
	 * @return PageConfig
	 */
	private function extractPageConfig(): PageConfig
	{
		$config = new PageConfig([
			"header_height" => $this->header_height,
			"footer_height" => $this->footer_height,
		]);

		if (is_array($this->paddings) && count($this->paddings) > 0) {
			$config->setPaddings($this->paddings[0] ?? null,
				$this->paddings[1] ?? null,
				$this->paddings[2] ?? null,
				$this->paddings[3] ?? null);
		}

		return $config;
	}


}