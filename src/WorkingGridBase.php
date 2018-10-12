<?php


namespace Eliepse\WorkingGrid;


use Mpdf\Output\Destination;

class WorkingGridBase
{
    /** @var string $title The title of the document */
    public $title;

    /** @var array $pagePaddings Set the padding of pages in millimeters. Formated as CSS : top, right, bottom, left */
    public $pagePaddings = [5, 20, 5, 20];

    /** @var array $characters */
    protected $characters = [];


    /**
     * Set the page paddings
     * @param float $top The top padding of pages
     * @param float|null $right The right padding of pages
     * @param float|null $bottom The bottom padding of pages
     * @param float|null $left The left padding of pages
     * @return WorkingGrid
     */
    public function setPagePaddings(float $top, float $right = null, float $bottom = null, float $left = null): self
    {
        $this->pagePaddings[0] = $top;
        $this->pagePaddings[1] = $right ?? $this->pagePaddings[0];
        $this->pagePaddings[2] = $bottom ?? $this->pagePaddings[1];
        $this->pagePaddings[3] = $left ?? $this->pagePaddings[2];

        return $this;
    }


    /**
     * Add a character to the list of characters to draw. Characters are drawn in the order added.
     * @param Character $character The character to add to the list
     */
    public function addCharacter(Character $character): void
    {
        array_push($this->characters, $character);
    }


    /**
     * Return the list of characters to draw.
     * @return array The characters list
     */
    public function getCharacters(): array
    {
        return $this->characters;
    }


    /**
     * Return the top padding of pages
     * @return float The top padding of pages
     */
    public function getPagePaddingTop(): float { return $this->pagePaddings[0]; }


    /**
     * Return the right padding of pages
     * @return float The right padding of pages
     */
    public function getPagePaddingRight(): float { return $this->pagePaddings[1]; }


    /**
     * Return the bottom padding of pages
     * @return float The bottom padding of pages
     */
    public function getPagePaddingBottom(): float { return $this->pagePaddings[2]; }


    /**
     * Return the left padding of pages
     * @return float The left padding of pages
     */
    public function getPagePaddingLeft(): float { return $this->pagePaddings[3]; }


    /**
     * Propose to download the PDF.
     * @throws \Mpdf\MpdfException
     */
    public function download(): void
    {
        (new WorkingGridCompiler($this))->compile()->Output($this->title . '.pdf', Destination::DOWNLOAD);
    }


    /**
     * Show the PDF in the browser if supported or propose to download it.
     * @throws \Mpdf\MpdfException
     */
    public function print(): void
    {
        (new WorkingGridCompiler($this))->compile()->Output($this->title . '.pdf', Destination::INLINE);
    }


    /**
     * Return the PDF file content as a string
     * @throws \Mpdf\MpdfException
     */
    public function content(): string
    {
        (new WorkingGridCompiler($this))->compile()->Output($this->title . '.pdf', Destination::STRING_RETURN);
    }
}