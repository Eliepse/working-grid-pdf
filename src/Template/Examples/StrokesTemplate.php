<?php


namespace Eliepse\WorkingGrid\Template\Examples;

use Eliepse\WorkingGrid\Template\CustomizableFooter;
use Eliepse\WorkingGrid\Template\CustomizableHeader;
use Eliepse\WorkingGrid\Template\WithDrawingTutorial;

class StrokesTemplate extends DefaultTemplate implements CustomizableHeader, CustomizableFooter, WithDrawingTutorial
{
    public $title = "Strokes Exemple grid 中文";
}