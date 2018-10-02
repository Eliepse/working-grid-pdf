<?php


namespace Eliepse\WorkingGrid;


class WorkingGridBase
{
    public $title;

    protected $pagePaddings = [5, 20, 5, 20];
    protected $characters = [];


    public function getCharacters(): array
    {
        return $this->characters;
    }


    /**
     * Set the page paddings
     * @param float $top
     * @param float|null $right
     * @param float|null $bottom
     * @param float|null $left
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


    public function getPagePaddings(): array
    {
        return $this->pagePaddings;
    }


    public function getPagePaddingTop(): float { return $this->pagePaddings[0]; }


    public function getPagePaddingRight(): float { return $this->pagePaddings[1]; }


    public function getPagePaddingBottom(): float { return $this->pagePaddings[2]; }


    public function getPagePaddingLeft(): float { return $this->pagePaddings[3]; }


    public function addCharacter(Character $character)
    {
        array_push($this->characters, $character);
    }


    protected function getPDFTitle(): string
    {
        return $this->title;
    }


    /**
     * @todo
     */
    public function download()
    {
        // TODO
    }


    /**
     * @throws \Mpdf\MpdfException
     */
    public function print()
    {
        (new WorkingGridCompiler($this))->compile()->Output($this->getPDFTitle() . '.pdf', 'I');
    }


    /**
     * @todo
     */
    public function content(): string
    {
        // TODO
    }
}