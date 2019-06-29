<?php


namespace Eliepse\WorkingGrid;


class Character implements Drawable
{

    /** @var string $character */
    private $character;

    /** @var array $strokes */
    private $strokes;

    /** @var string $pinyin */
    private $pinyin;


    /**
     * Character constructor.
     * @param string $character The character in his normal "textual" form
     * @param array $svgStrokes The strokes of the character, as a list of SVG that represent the drawing order
     * @param string $pinyin
     */
    public function __construct(string $character, array $svgStrokes, string $pinyin = '')
    {
        $this->character = $character;
        $this->strokes = $svgStrokes;
        $this->pinyin = $pinyin;
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
     * Return the caracter as a multibyte string
     * @return string
     */
    public function getText(): string
    {
        return $this->character;
    }


    /**
     * Return the pinyin of the caracter
     * @return string
     */
    public function getPinyin(): string
    {
        return $this->pinyin;
    }
}