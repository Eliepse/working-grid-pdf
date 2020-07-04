<?php


namespace Eliepse\WorkingGrid;


class DrawableCell extends Cell
{

	/** @var Drawable $drawable */
	protected $drawable;


	public function __construct(int $x, int $y, Drawable $drawable)
	{
		parent::__construct($x, $y);

		$this->drawable = $drawable;
	}


	public function getStrokes(): array
	{
		return $this->drawable->getStrokes();
	}
}