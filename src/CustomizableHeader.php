<?php
/**
 * Created by PhpStorm.
 * User: margu
 * Date: 01/10/2018
 * Time: 22:54
 */

namespace Eliepse\WorkingGrid;


use Mpdf\Mpdf;

interface CustomizableHeader
{

    /**
     * Use this function to draw the footer on each page of the PDF
     * @param Mpdf $pdf The class that manage the PDF. Use it to interact and draw on it.
     * @param PageInfo $infos The informations of the current drawing page
     */
    public function header(Mpdf $pdf, PageInfo $infos): void;

}