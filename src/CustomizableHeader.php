<?php
/**
 * Created by PhpStorm.
 * User: margu
 * Date: 01/10/2018
 * Time: 22:54
 */

namespace Eliepse\WorkingGrid;


use TCPDF;

interface CustomizableHeader
{

    public function header(TCPDF $pdf, PageInfo $infos);

}