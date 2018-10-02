<?php


namespace Eliepse\WorkingGrid;


use Error;
use Mpdf\Mpdf;

class WorkingGridCompiler
{

    /** @var WorkingGrid|CustomizableHeader|CustomizableFooter $grid */
    private $grid;

    /** @var Mpdf $pdf */
    private $pdf;


    /**
     * WorkingGridCompiler constructor.
     * @param WorkingGridBase $grid The grid to be generated.
     */
    public function __construct(WorkingGridBase $grid)
    {
        $this->grid = $grid;
    }


    /**
     * Generate a new PDF, write all elements on it and return it.
     * @return Mpdf The drew element
     * @throws \Mpdf\MpdfException
     */
    public function compile(): Mpdf
    {
        $this->pdf = $this->createPDF();

        $totalPage = $this->getPageCount();

        $chunks = array_chunk($this->grid->getCharacters(), $this->getLinesPerPage());

        for ($i = 0; $i < count($chunks); $i++) {

            $this->drawPage(new PageInfo($i + 1, $totalPage, $chunks[ $i ]));

        }

        return $this->pdf;
    }


    /**
     * Generate a new, empty and clean PDF and return it.
     * @return Mpdf
     * @throws \Mpdf\MpdfException
     */
    private function createPDF(): Mpdf
    {
        $pdf = new Mpdf();

        $pdf->title = $this->grid->title;
        $pdf->cellPaddingT = 0;
        $pdf->cellPaddingR = 0;
        $pdf->cellPaddingB = 0;
        $pdf->cellPaddingL = 0;

        $pdf->autoPageBreak = false;
        $pdf->autoPadding = false;
        $pdf->autoMarginPadding = false;

        $pdf->SetFont("GB");

        return $pdf;
    }


    /**
     * Calculate and return the height of lines.
     * @return float The height of a signle line
     */
    private function getLineHeight(): float
    {
        // Row height calculated from columns per row
        $heightFromColumns = ($this->getBodyMaxWidth() / $this->grid->columns) + $this->getStrokeOrderBoxHeight();


        if ($this->hasLinesConstraint()) {

            // Row heigh calculated from lines per page
            $heightFromLines = $this->getBodyMaxHeight() / $this->grid->linesPerPage;

            // If using lines require thinner row, we choose the result from it
            if ($heightFromLines < $heightFromColumns)
                return $heightFromLines;

        }

        // Otherwise, the result from columns is used
        return $heightFromColumns;
    }


    /**
     * Calculate and return the size of a single cell (cells are squared).
     * @return float The size of a single cell
     */
    private function getCellSize(): float
    {
        return $this->getLineHeight() - $this->getStrokeOrderBoxHeight();
    }


    /**
     * Calcumate and return the width of the body.
     * @return float The width of the body
     */
    private function getBodyWidth(): float
    {
        return $this->hasLinesConstraint() ? $this->getCellSize() * $this->grid->columns : $this->getBodyMaxWidth();
    }


    /**
     * Calcumate and return the hight of the box where the strokes order is drawn
     * @return float The height of the box. Return 0 if the feature is not activated.
     */
    private function getStrokeOrderBoxHeight(): float
    {
        return $this->grid->withStrokeOrder ? $this->grid->strokeOrderSize * 1.5 : 0;
    }


    /**
     * Calculate and return the number of lines per page.
     * @return int The number of lines per pages
     */
    private function getLinesPerPage(): int
    {
        if ($this->hasLinesConstraint()) {

            return $this->grid->linesPerPage;

        } else {
            return floor($this->getBodyMaxHeight() / $this->getLineHeight());
        }

    }


    /**
     * Calculate and return the max height of the body.
     * @return float The max height of the body
     */
    private function getBodyMaxHeight(): float
    {
        return 297 - $this->grid->getPagePaddingTop() - $this->grid->getPagePaddingBottom()
            - $this->grid->headerHeight - $this->grid->footerHeight;
    }


    /**
     * Calculate and return the max width of the body.
     * @return float The max width of the body
     */
    private function getBodyMaxWidth(): float
    {
        return 210 - $this->grid->getPagePaddingLeft() - $this->grid->getPagePaddingRight();
    }


    /**
     * Calculate and return the needed number of pages in the PDF.
     * @return int The number of pages in the PDF
     */
    private function getPageCount(): int
    {
        return ceil(count($this->grid->getCharacters()) / $this->getLinesPerPage());
    }


    /**
     * Compile a svg template and return it as a HTML string.
     * @param string $filename The template filename
     * @param array $_args The values to pass to the template
     * @return string The compiled template
     */
    private function getSVGTemplate(string $filename, $_args = []): string
    {
        try {

            extract($_args);

            ob_start();

            /** @noinspection PhpIncludeInspection */
            require __DIR__ . "/../resources/templates/$filename";

            return ob_get_clean();


        } catch (Error $e) {

            return "";

        }
    }


    /**
     * Check if the grid have a line per page constraint.
     * @return bool Return true if there is a constraint, false otherwise.
     */
    public function hasLinesConstraint(): bool
    {
        return $this->grid->linesPerPage !== null;
    }


    /**
     * Draw the given page to the PDF.
     * @param PageInfo $infos The page to draw
     */
    private function drawPage(PageInfo $infos)
    {
        $this->pdf->AddPage();

        $this->drawHeader($infos);
        $this->drawBody($infos);
        $this->drawFooter($infos);
    }


    /**
     * Draw the body of the given page to the PDF.
     * @param PageInfo $infos The page to draw
     */
    private function drawBody(PageInfo $infos)
    {
        $offsetY = $this->grid->headerHeight + $this->grid->getPagePaddingTop();

        /** @var Character $character */
        foreach ($infos->getCharacters() as $index => $character) {

            $this->drawLine($character, ($index * $this->getLineHeight()) + $offsetY);

        }
    }


    /**
     * Draw a single line on the active page to the PDF.
     * @param Character $character The character to draw on the line
     * @param float $y The Y position to draw the line
     */
    private function drawLine(Character $character, float $y)
    {
        $offsetX = $this->grid->getPagePaddingLeft();
        $offsetY = 0;

        if ($this->grid->withStrokeOrder) {
            $this->drawStrokeOrder($offsetX, $y + $offsetY, $character);
            $offsetY += $this->getStrokeOrderBoxHeight();
        }


        for ($i = 0; $i < $this->grid->columns; $i++) {

            $this->drawCell(($i * $this->getCellSize()) + $offsetX, $y + $offsetY);

            if ($i === 0) {

                $this->drawCell(($i * $this->getCellSize()) + $offsetX, $y + $offsetY, $character);

            } else if ($i <= $this->grid->models) {

                $this->drawCell(($i * $this->getCellSize()) + $offsetX, $y + $offsetY, $character, "#cccccc");

            }


        }

    }


    /**
     * Draw the writing steps box (strokes order) to the PDF.
     * @param float $x The X position to draw the box
     * @param float $y The Y position to draw the box
     * @param Character $character The character to decompose
     * @param string $fill The color of the strokes
     */
    private function drawStrokeOrder(float $x, float $y, Character $character, string $fill = "#333333")
    {
        $size = $this->getStrokeOrderBoxHeight();
        $characterSize = $this->grid->strokeOrderSize;
        $offesetY = ($size - $characterSize) / 2;

        $this->pdf->Rect($x, $y, $this->getBodyWidth(), $size);

        $strokes = [];

        foreach ($character->getStrokes() as $stroke) {

            $strokes[] = $stroke;

            $html = $this->getSVGTemplate('svg-stroke.php', ['strokes' => $strokes, 'fill' => $fill]);

            $this->pdf->WriteFixedPosHTML($html, $x + ((count($strokes) - .5) * ($size + .5)), $y + $offesetY, $characterSize, $characterSize);
        }
    }


    /**
     * Draw a single cell to the PDF.
     * @param float $x The X position to draw the cell
     * @param float $y The Y position to draw the cell
     * @param Character|null $character The character to draw in the cell. If null, only the background is printed.
     * @param string $fill The color of the strokes
     */
    private function drawCell(float $x, float $y, Character $character = null, string $fill = "#333333")
    {
        $size = $this->getCellSize();

        $offset = $character ? $size * .25 : 0;

        $strokes = $character ? $character->getStrokes() : null;

        $html = $this->getSVGTemplate($character ? 'svg-stroke.php' : 'svg-background.php', compact('strokes', 'fill'));

        $this->pdf->WriteFixedPosHTML($html, $x + ($offset / 2), $y + ($offset / 2), $size - $offset, $size - $offset);

        $this->pdf->Rect($x, $y, $size, $size);
    }


    /**
     * Draw the header of the given page.
     * @param PageInfo $infos The page to draw
     */
    private function drawHeader(PageInfo $infos)
    {
        if (is_a($this->grid, CustomizableHeader::class)) {
            $this->pdf->SetXY(0, $this->grid->getPagePaddingTop());
            $this->grid->header($this->pdf, $infos);
        }
    }


    /**
     * Draw the footer of the given page.
     * @param PageInfo $infos The page to draw
     */
    private function drawFooter(PageInfo $infos)
    {
        if (is_a($this->grid, CustomizableFooter::class)) {
            $this->pdf->SetXY(0, 297 - $this->grid->getPagePaddingBottom() - $this->grid->footerHeight);
            $this->grid->footer($this->pdf, $infos);
        }
    }

}