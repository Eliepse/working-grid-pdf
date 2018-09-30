<?php


namespace Eliepse;


class Character
{

	/** @var string $character */
	private $character;

	/** @var array $strokes */
	private $strokes;


	public function __construct(string $character, array $svgStrokes)
	{
		$this->character = $character;
		$this->strokes = $svgStrokes;
	}


	/**
	 * @return string
	 */
	public function getCharacter(): string
	{
		return $this->character;
	}


	/**
	 * @return array
	 */
	public function getStrokes(): array
	{
		return $this->strokes;
	}

}