<?php

use Eliepse\PDFWorkingGrid;
use Eliepse\Character;

require '../vendor/autoload.php';

function getStrokes(string $filename): array { return json_decode(file_get_contents("../resources/samples/strokes/$filename.json"), true); }

$sheet = new PDFWorkingGrid("Exemple grid", true, 9, 10);

$sheet->addCharacter(new Character("中", getStrokes("zhong")));
$sheet->addCharacter(new Character("国", getStrokes("guo")));
$sheet->addCharacter(new Character("一", getStrokes("yi")));
$sheet->addCharacter(new Character("二", getStrokes("er")));
$sheet->addCharacter(new Character("三", getStrokes("san")));
$sheet->addCharacter(new Character("四", getStrokes("si")));
$sheet->addCharacter(new Character("五", getStrokes("wu")));
$sheet->addCharacter(new Character("六", getStrokes("liu")));
$sheet->addCharacter(new Character("七", getStrokes("qi")));
$sheet->addCharacter(new Character("八", getStrokes("ba")));
$sheet->addCharacter(new Character("九", getStrokes("jiu")));
$sheet->addCharacter(new Character("十", getStrokes("shi")));

/** @noinspection PhpUnhandledExceptionInspection */
$sheet->output();