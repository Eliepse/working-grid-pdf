<?php


namespace Eliepse\WorkingGrid;


class Character implements Drawable
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
     * Get the strokes of the character as a list of SVG that represent the drawing order
     * @return array
     */
    public function getStrokes(): array
    {
        return $this->strokes;
    }


    /**
     * Return the string format of the content
     * @return string
     */
    public function getText(): string
    {
        return $this->character;
    }
}