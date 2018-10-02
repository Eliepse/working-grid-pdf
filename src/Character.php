<?php


namespace Eliepse\WorkingGrid;


class Character
{

    /** @var string $character */
    private $character;

    /** @var array $strokes */
    private $strokes;


    /**
     * Character constructor.
     * @param string $character The character in his normal "textual" form
     * @param array $svgStrokes The strokes of the character, as a list of SVG that represent the drawing order
     */
    public function __construct(string $character, array $svgStrokes)
    {
        $this->character = $character;
        $this->strokes = $svgStrokes;
    }


    /**
     * Get the character as a string
     * @return string
     */
    public function getCharacter(): string
    {
        return $this->character;
    }


    /**
     * Get the strokes of the character as a list of SVG that represent the drawing order
     * @return array
     */
    public function getStrokes(): array
    {
        return $this->strokes;
    }

}