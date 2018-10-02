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
     * @param int $index The index of the page
     * @param int $total The number of pages in the PDF
     * @param array $characters The characters drew on the page
     */
    public function __construct(int $index, int $total, array $characters)
    {
        $this->index = $index;
        $this->total = $total;
        $this->characters = $characters;
    }


    /**
     * The index of the page
     * @return int
     */
    public function getIndex(): int { return $this->index; }


    /**
     * The number of pages in the document
     * @return int
     */
    public function getTotal(): int { return $this->total; }


    /**
     * The characters used in the page
     * @return array
     */
    public function getCharacters(): array { return $this->characters; }
}