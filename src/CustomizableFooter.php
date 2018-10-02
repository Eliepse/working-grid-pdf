<?php


namespace Eliepse\WorkingGrid;


use Mpdf\Mpdf;

interface CustomizableFooter
{

    public function footer(Mpdf $pdf, PageInfo $infos);

}