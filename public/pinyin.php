<?php

require __DIR__ . '/../vendor/autoload.php';

use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\Template\Examples\PinyinTemplate;
use Eliepse\WorkingGrid\WorkingGrid;

function getStrokes(string $filename): array { return json_decode(file_get_contents(__DIR__ . "/../resources/samples/strokes/$filename.json"), true); }

WorkingGrid::inlinePrint(new PinyinTemplate, [
    new Word([new Character("中", getStrokes("zhong"))]), // test missing pinyin
    new Word([new Character("国", getStrokes("guo"), "guó")]),
    new Word([
        new Character("中", getStrokes("zhong"), "zhōng"),
        new Character("国", getStrokes("guo"), "guó"),
    ]),
    new Word([new Character("一", getStrokes("yi"), "yī")]),
    new Word([new Character("二", getStrokes("er"), "èr")]),
    new Word([new Character("三", getStrokes("san"), "sān")]),
    new Word([new Character("四", getStrokes("si"), "sì")]),
    new Word([new Character("五", getStrokes("wu"), "wǔ")]),
    new Word([
        new Character("十", getStrokes("shi"), "shí"),
        new Character("一", getStrokes("yi"), "yī"),
    ]),
    new Word([new Character("六", getStrokes("liu"), "liù")]),
    new Word([new Character("七", getStrokes("qi"), "qī")]),
    new Word([new Character("八", getStrokes("ba"), "bā")]),
    new Word([new Character("九", getStrokes("jiu"), "jiǔ")]),
    new Word([new Character("十", getStrokes("shi"), "shí")]),
    new Word([
        new Character("十", getStrokes("shi"), "shí"),
        new Character("二", getStrokes("er"), "èr"),
    ]),
]);