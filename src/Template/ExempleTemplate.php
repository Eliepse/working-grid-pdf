<?php


namespace Eliepse\WorkingGrid\Template;

use Eliepse\WorkingGrid\PageInfo;
use Mpdf\Mpdf;

class ExempleTemplate extends Template implements CustomizableHeader, CustomizableFooter, WithDrawingTutorial
{

    public $title = "Exemple grid 中文";

    public $header_height = 20;

    public $footer_height = 12;


    public function header(Mpdf $pdf, PageInfo $infos): void
    {
        $pdf->SetFontSize(16);
        $pdf->Cell(210, 0, $this->title, false, false, 'C', 0, 0, 0, '', 'T', 'T');
    }


    public function footer(Mpdf $pdf, PageInfo $infos): void
    {
        $pdf->SetFontSize(10);
        $pdf->Cell(210, $this->footer_height, "{$infos->getIndex()} / {$infos->getTotal()}", false, false, 'C', 0, 0, 0, '', 'T', 'B');
    }

}