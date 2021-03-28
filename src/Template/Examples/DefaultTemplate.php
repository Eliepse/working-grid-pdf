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
		$css = "font-family: {$this->defaultFonts}; text-align: center; font-size: 1.5em;";
		$pdf->SetFontSize(16);
		$pdf->WriteHTML("<h1 style='$css'>{$this->title}</h1>");
	}


	public function footer(Mpdf $pdf, PageInfo $infos): void
	{
		$pdf->SetFontSize(10);
		$pdf->Cell(210, $this->footer_height, "{$infos->getIndex()} / {$infos->getTotal()}", false, false, 'C', 0, 0, 0, '', 'T', 'B');
	}

}