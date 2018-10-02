<?php

require __DIR__ . '/../vendor/autoload.php';

use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\DefaultGrid;

function getStrokes(string $filename): array { return json_decode(file_get_contents(__DIR__ . "/../resources/samples/strokes/$filename.json"), true); }

$grid = new DefaultGrid("Exemple grid 中文", true, 9, 10);

$grid->addCharacter(new Character("中", getStrokes("zhong")));
$grid->addCharacter(new Character("国", getStrokes("guo")));
$grid->addCharacter(new Character("一", getStrokes("yi")));
$grid->addCharacter(new Character("二", getStrokes("er")));
$grid->addCharacter(new Character("三", getStrokes("san")));
$grid->addCharacter(new Character("四", getStrokes("si")));
$grid->addCharacter(new Character("五", getStrokes("wu")));
$grid->addCharacter(new Character("六", getStrokes("liu")));
$grid->addCharacter(new Character("七", getStrokes("qi")));
$grid->addCharacter(new Character("八", getStrokes("ba")));
$grid->addCharacter(new Character("九", getStrokes("jiu")));
$grid->addCharacter(new Character("十", getStrokes("shi")));

$grid->print();