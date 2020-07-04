<?php

namespace Eliepse\WorkingGrid;


interface Drawable
{

	/**
	 * Return the string format of the content
	 *
	 * @return string
	 */
	public function getText(): string;


	/**
	 * Return the ordered strokes data to draw in SVG
	 *
	 * @return array
	 */
	public function getStrokes(): array;

}