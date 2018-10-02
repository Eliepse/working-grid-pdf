<?php


namespace Eliepse\WorkingGrid;


use TCPDF;

interface CustomizableFooter
{

    public function footer(TCPDF $pdf, PageInfo $infos);

}