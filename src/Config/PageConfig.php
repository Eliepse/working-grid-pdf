<?php


namespace Eliepse\WorkingGrid\Config;


use Eliepse\WorkingGrid\FillAttributes;

class PageConfig
{

	use FillAttributes;

	public $page_height = 295;

	public $page_width = 210;

	/** @var int $header_height Set the header height in millimeters */
	public $header_height = 0;

	/** @var int $footer_height Set the footer height in millimeters */
	public $footer_height = 0;

	public $padding_top = 5;

	public $padding_right = 20;

	public $padding_bottom = 5;

	public $padding_left = 20;


	public function __construct(array $attributes = [])
	{
		$this->fill($attributes);
	}


	/**
	 * Set the page paddings
	 *
	 * @param float $top The top padding of pages
	 * @param float|null $right The right padding of pages
	 * @param float|null $bottom The bottom padding of pages
	 * @param float|null $left The left padding of pages
	 *
	 * @return PageConfig
	 */
	public function setPaddings(float $top, float $right = null, float $bottom = null, float $left = null): self
	{
		$this->padding_top = $top;
		$this->padding_right = $right ?? $this->padding_top;
		$this->padding_bottom = $bottom ?? $this->padding_right;
		$this->padding_left = $left ?? $this->padding_bottom;

		return $this;
	}


	public function setHeaderHeight(float $mm): self
	{
		$this->header_height = $mm;

		return $this;
	}


	public function setFooterHeight(float $mm): self
	{
		$this->footer_height = $mm;

		return $this;
	}


	public function getBodyHeight(): float
	{
		return $this->page_height
			- $this->padding_top
			- $this->padding_bottom
			- $this->header_height
			- $this->footer_height;
	}


	public function getBodyWidth(): float
	{
		return $this->page_width - $this->padding_left - $this->padding_right;
	}
}