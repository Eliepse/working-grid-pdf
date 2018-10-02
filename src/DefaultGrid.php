<?php


namespace Eliepse\WorkingGrid;


use TCPDF;

class DefaultGrid extends WorkingGrid implements CustomizableHeader, CustomizableFooter
{

    public $headerHeight = 12;
    public $footerHeight = 12;
    public $withStrokeOrder = true;
    public $models = 3;


    public function header(TCPDF $pdf, PageInfo $infos)
    {
        $pdf->SetFontSize(16);
        $pdf->Cell(210, 0, $this->title, false, false, 'C', 0, 0, 0, '', 'T', 'T');
    }


    public function footer(TCPDF $pdf, PageInfo $infos)
    {
        $pdf->SetFontSize(10);
        $pdf->Cell(210, $this->footerHeight, "{$infos->getIndex()} / {$infos->getTotal()}", false, false, 'C', 0, 0, 0, '', 'T', 'B');
    }

}