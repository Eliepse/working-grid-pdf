<?php


namespace Eliepse;


use Error;
use TCPDF;

class PDFWorkingGrid
{

    /** @var TCPDF $pdf */
    private $pdf;

    /** @var string $title */
    private $title;

    /** @var float $maxWidth */
    private $maxWidth = 170;

    /** @var float $maxHeight */
    private $maxHeight = 250;

    private $bodyOffsetY = 20;

    /** @var int $columns */
    private $columns = 10;

    /** @var int $linesPerPage */
    private $linesPerPage;

    /** @var int $models */
    private $models = 3;

    /** @var bool $withStrokeOrder */
    private $withStrokeOrder = false;

    /** @var array $characters */
    private $characters = [];

    /** @var float $strokesOrderBoxSize */
    private $strokesOrderBoxSize = 8;


    public function __construct(string $title = "New grid", $withStrokeOrder = false, $columns = 9, $linesPerPage = null)
    {

        $this->title = $title;
        $this->withStrokeOrder = $withStrokeOrder;
        $this->columns = $columns;
        $this->linesPerPage = $linesPerPage;

        $this->initPDF();

    }


    private function initPDF()
    {
        $this->pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $this->pdf->SetTitle($this->title);
//		$this->pdf->SetCreator('Eliepse');
//		$this->pdf->SetAuthor('Eliepse');
//		$this->pdf->SetSubject('TCPDF Tutorial');
//		$this->pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $this->pdf->SetFillColor(255, 255, 255);
        $this->pdf->SetFontSize(43);
        $this->pdf->setCellPaddings(0, 0, 0, 0);
        $this->pdf->setCellMargins(0, 0, 0, 0);

        $this->pdf->SetAutoPageBreak(false, PDF_MARGIN_BOTTOM);
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->pdf->setFontSubsetting(true);

        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
    }


    /**
     * @param int $models
     */
    public function setModels(int $models): void
    {
        $this->models = $models;
    }


    public function addCharacter(Character $character)
    {
        array_push($this->characters, $character);
    }


    public function drawHeader()
    {
        $this->pdf->SetFontSize(18);
        $this->pdf->SetXY(0, 0, true);
        $this->pdf->SetAbsY(15);
        $this->pdf->Cell(210, 0, $this->title, false, false, 'C', 0, 0, 0, '', 'B', 'M');
        $this->pdf->SetFontSize(43);
    }


    /**
     * @throws \Throwable
     */
    public function output()
    {
        $this->drawAll();

        $this->pdf->Output("{$this->title}.pdf", 'I');
    }


    /**
     * @throws \Throwable
     */
    public function download()
    {
        $this->drawAll();

        $this->pdf->Output("{$this->title}.pdf", 'D');
    }


    /**
     * @throws \Throwable
     */
    public function getFileContent(): string
    {
        $this->drawAll();

        return $this->pdf->Output("{$this->title}.pdf", 'S');
    }


    /**
     * @param float $maxWidth
     */
    public function setMaxWidth(float $maxWidth): void
    {
        $this->maxWidth = $maxWidth;
    }


    /**
     * @param float $maxHeight
     */
    public function setMaxHeight(float $maxHeight): void
    {
        $this->maxHeight = $maxHeight;
    }


    /**
     * @param float $strokesOrderBoxSize
     */
    public function setStrokesOrderBoxSize(float $strokesOrderBoxSize): void
    {
        $this->strokesOrderBoxSize = $strokesOrderBoxSize;
    }


    private function getWidth(): float
    {
        return $this->linesPerPage ? $this->getCellSize() * $this->columns : $this->maxWidth;
    }


    private function getCellSize(): float
    {
        return $this->getRowHeight() - ($this->withStrokeOrder ? $this->strokesOrderBoxSize : 0);
    }


    private function getRowHeight(): float
    {

        // Row height calculated from columns per row
        $heightFromColumns = ($this->maxWidth / $this->columns) + ($this->withStrokeOrder ? $this->strokesOrderBoxSize : 0);


        if ($this->linesPerPage) {

            // Row heigh calculated from lines per page
            $heightFromLines = $this->maxHeight / $this->linesPerPage;

            // If using lines require thinner row, we choose the result from it
            if ($heightFromLines < $heightFromColumns)
                return $heightFromLines;

        }

        // Otherwise, the result from columns is used
        return $heightFromColumns;
    }


    private function getMaxLinesPerPage(): int
    {
        return $this->linesPerPage ?: floor($this->maxHeight / $this->getRowHeight());
    }


    /**
     * @throws \Throwable
     */
    private function drawAll()
    {
        $maxLinesPerPage = $this->getMaxLinesPerPage();
        $charactersCount = count($this->characters);

        $this->clear();

//		$this->pdf->Rect((210 - $this->getWidth()) / 2, $this->bodyOffsetY, $this->getWidth(), $this->maxHeight);

        for ($i = 0, $pageLinesCount = 0; $i < $charactersCount; $i++, $pageLinesCount = $i % $maxLinesPerPage) {

            $character = $this->characters[ $i ];

            if ($pageLinesCount == 0) {

                $this->pdf->AddPage();
                $this->drawHeader();

            }

            $this->drawRow($character, $this->bodyOffsetY + ($pageLinesCount * $this->getRowHeight()));


        }

        $this->pdf->lastPage();
    }


    /**
     * @param Character $character
     * @param float $offsetY
     * @throws \Throwable
     */
    private
    function drawRow(Character $character, float $offsetY)
    {
        $offsetX = (210 - $this->getWidth()) / 2;
        $size = $this->getCellSize();
        $fill = '#333333';
        $strokes = $character->getStrokes();

        if ($this->withStrokeOrder) {

            $hSize = $this->strokesOrderBoxSize;
            $helpSize = $hSize * .8;
            $helpOffsetY = $hSize * .1;

            $this->pdf->Rect($offsetX, $offsetY, $this->getWidth(), $hSize);

            $helpStrokes = [];

            foreach ($strokes as $stroke) {
                $helpStrokes[] = $stroke;

                $html = $this->getSVGTemplate('svg-stroke.php', ['strokes' => $helpStrokes, 'fill' => $fill]);
                $this->pdf->ImageSVG("@$html", $offsetX + ((count($helpStrokes) - .5) * ($helpSize + .5)), $offsetY + $helpOffsetY, $helpSize, $helpSize);
            }

            $offsetY += $hSize;

        }

        for ($i = 0; $i < $this->columns; $i++) {

            $x = ($i * $size) + $offsetX;
            $y = $offsetY;

            if ($i > 0)
                $fill = '#cccccc';

            $this->drawCell(null, $x, $y);

            if ($i <= $this->models) {

                $this->drawCell($strokes, $x, $y, $fill);

            }

            $this->pdf->Rect($x, $y, $size, $size);

        }
    }


    private
    function drawCell(array $strokes = null, $x, $y, $fill = "#333333")
    {
        $size = $this->getCellSize();

        $html = $this->getSVGTemplate($strokes ? 'svg-stroke.php' : 'svg-background.php', compact('strokes', 'fill'));
        $this->pdf->ImageSVG("@$html", $x, $y, $size, $size);
    }


    private
    function getSVGTemplate(string $filename, $_args = [])
    {
        try {

            extract($_args);

            ob_start();

            /** @noinspection PhpIncludeInspection */
            require __DIR__ . "/../resources/templates/$filename";

            return ob_get_clean();


        } catch (Error $e) {

            throw $e;

        }
    }


    private
    function clear()
    {
        $this->initPDF();
    }


    /**
     * @param bool $withStrokeOrder
     */
    public
    function setWithStrokeOrder(bool $withStrokeOrder): void
    {
        $this->withStrokeOrder = $withStrokeOrder;
    }

}