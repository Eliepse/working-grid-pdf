<?php


namespace Eliepse\WorkingGrid;


use Error;
use TCPDF;

class WorkingGridCompiler
{

    /** @var WorkingGrid|CustomizableHeader|CustomizableFooter $grid */
    private $grid;

    /** @var TCPDF $pdf */
    private $pdf;


    public function __construct(WorkingGridBase $grid)
    {
        $this->grid = $grid;
    }


    public function compile(): TCPDF
    {
        $this->pdf = $this->createPDF();

        $totalPage = $this->getPageCount();

//        echo "<pre>" . var_dump($this->hasLinesConstraint()) . "</pre>"; exit(0);

        $chunks = array_chunk($this->grid->getCharacters(), $this->getLinesPerPage());


        for ($i = 0; $i < count($chunks); $i++) {

            $this->drawPage(new PageInfo($i + 1, $totalPage, $chunks[ $i ]));

        }

        $this->pdf->lastPage();

        return $this->pdf;
    }


    private function createPDF(): TCPDF
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//        $fontname = \TCPDF_FONTS::addTTFfont(__DIR__ . "/../resources/assets/fonts/SourceHanSansSC-Regular.otf", "CID0CS", "", 32, __DIR__ . "/../resource/assets/fontsB/");

//        $pdf->SetFont("sourceHan", '', null, __DIR__ . "/../resources/assets/fonts/SourceHanSansSC-Regular.otf", true);
//        $pdf->AddFont($fontname, null, null, true);

        $pdf->SetTitle($this->grid->title);
//		$pdf->SetCreator('Eliepse');
//		$pdf->SetAuthor('Eliepse');
//		$pdf->SetSubject('TCPDF Tutorial');
//		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFontSize(43);
        $pdf->setCellPaddings(0, 0, 0, 0);
        $pdf->setCellMargins(0, 0, 0, 0);

        $pdf->SetAutoPageBreak(false, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);

        $pdf->SetFontSize(16);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        return $pdf;
    }


    private function getRowHeight(): float
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


    private function getCellSize(): float
    {
        return $this->getRowHeight() - $this->getStrokeOrderBoxHeight();
    }


    private function getBodyWidth(): float
    {
        return $this->hasLinesConstraint() ? $this->getCellSize() * $this->grid->columns : $this->getBodyMaxWidth();
    }


    private function getStrokeOrderBoxHeight(): float
    {
        return $this->grid->withStrokeOrder ? $this->grid->strokeOrderSize * 1.5 : 0;
    }


    private function getLinesPerPage(): int
    {
        if ($this->hasLinesConstraint()) {

            return $this->grid->linesPerPage;

        } else {
            return floor($this->getBodyMaxHeight() / $this->getRowHeight());
        }

    }


    private function getBodyMaxHeight(): float
    {
        return 297 - $this->grid->getPagePaddings()[0] - $this->grid->getPagePaddings()[2]
            - $this->grid->headerHeight - $this->grid->footerHeight;
    }


    private function getBodyMaxWidth(): float
    {
        return 210 - $this->grid->getPagePaddings()[1] - $this->grid->getPagePaddings()[3];
    }


    private function getPageCount(): int
    {
        return ceil(count($this->grid->getCharacters()) / $this->getLinesPerPage());
    }


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


    public function hasLinesConstraint(): bool
    {
        return $this->grid->linesPerPage !== null;
    }


    private function drawPage(PageInfo $infos)
    {
        $this->pdf->AddPage();

        $this->drawHeader($infos);
        $this->drawBody($infos);
        $this->drawFooter($infos);
    }


    private function drawBody(PageInfo $infos)
    {
        $offsetY = $this->grid->headerHeight + $this->grid->getPagePaddings()[0];

        /** @var Character $character */
        foreach ($infos->getCharacters() as $index => $character) {

            $this->drawLine($character, ($index * $this->getRowHeight()) + $offsetY);

        }
    }


    private function drawLine(Character $character, float $y)
    {
        $offsetX = (210 - $this->getBodyWidth()) / 2;
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

            $this->pdf->ImageSVG("@$html", $x + ((count($strokes) - .5) * ($size + .5)), $y + $offesetY, $characterSize, $characterSize);

        }
    }


    private function drawCell(float $x, float $y, Character $character = null, string $fill = "#333333")
    {
        $size = $this->getCellSize();

        $offset = $character ? $size * .25 : 0;

        $strokes = $character ? $character->getStrokes() : null;

        $html = $this->getSVGTemplate($character ? 'svg-stroke.php' : 'svg-background.php', compact('strokes', 'fill'));

        $this->pdf->ImageSVG("@$html", $x + ($offset / 2), $y + ($offset / 2), $size - $offset, $size - $offset);

        $this->pdf->Rect($x, $y, $size, $size);
    }


    /**
     * @param PageInfo $infos
     */
    private function drawHeader(PageInfo $infos)
    {
        if (is_a($this->grid, CustomizableHeader::class)) {
            $this->pdf->SetAbsXY(0, $this->grid->getPagePaddings()[0]);
            $this->grid->header($this->pdf, $infos);
        }
    }


    private function drawFooter(PageInfo $infos)
    {
        if (is_a($this->grid, CustomizableFooter::class)) {
            $this->pdf->SetAbsXY(0, 297 - $this->grid->getPagePaddings()[2] - $this->grid->footerHeight);
            $this->grid->footer($this->pdf, $infos);
        }
    }

}