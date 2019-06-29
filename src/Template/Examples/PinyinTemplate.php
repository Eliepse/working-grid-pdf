<?php


namespace Eliepse\WorkingGrid\Template\Examples;

use Eliepse\WorkingGrid\Template\CustomizableFooter;
use Eliepse\WorkingGrid\Template\CustomizableHeader;
use Eliepse\WorkingGrid\Template\WithPinyin;

class PinyinTemplate extends DefaultTemplate implements CustomizableHeader, CustomizableFooter, WithPinyin
{
    public $title = "Pinyin Exemple grid 中文";
}