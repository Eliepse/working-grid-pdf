<?php


namespace Eliepse\WorkingGrid\Template\Examples;

use Eliepse\WorkingGrid\PageInfo;
use Eliepse\WorkingGrid\Template\CustomizableFooter;
use Eliepse\WorkingGrid\Template\CustomizableHeader;
use Eliepse\WorkingGrid\Template\Template;
use Mpdf\Mpdf;

class DefaultTemplate extends Template implements CustomizableHeader, CustomizableFooter
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