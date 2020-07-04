<?php


namespace Eliepse\WorkingGrid\Template;


use Eliepse\WorkingGrid\PageInfo;
use Mpdf\Mpdf;

interface CustomizableFooter
{

	/**
	 * Use this function to draw the header on each page of the PDF
	 *
	 * @param Mpdf $pdf The class that manage the PDF. Use it to interact and draw on it.
	 * @param PageInfo $infos The informations of the current drawing page
	 */
	public function footer(Mpdf $pdf, PageInfo $infos): void;

}