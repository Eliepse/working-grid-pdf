<?php


namespace Eliepse\WorkingGrid;


class PageInfo
{

    /** @var int $index */
    private $index;

    /** @var int $total */
    private $total;

    /** @var array $characters */
    private $characters;


    /**
     * PageInfo constructor.
     * @param int $index
     * @param int $total
     * @param array $characters
     */
    public function __construct(int $index, int $total, array $characters)
    {
        $this->index = $index;
        $this->total = $total;
        $this->characters = $characters;
    }


    /**
     * The current page number
     * @return int
     */
    public function getIndex(): int { return $this->index; }


    /**
     * The number pages in the document
     * @return int
     */
    public function getTotal(): int { return $this->total; }


    /**
     * The characters used in the current page
     * @return array
     */
    public function getCharacters(): array { return $this->characters; }
}