<?php

use Eliepse\PDFWorkingGrid;
use Eliepse\Character;

require '../vendor/autoload.php';

function getStrokes(string $filename): array { return json_decode(file_get_contents("../resources/samples/strokes/$filename.json"), true); }

$sheet = new PDFWorkingGrid();
$sheet->setWithStrokeOrder(true);

$sheet->addCharacter(new Character("中", getStrokes("0")));
$sheet->addCharacter(new Character("国", getStrokes("1")));

/** @noinspection PhpUnhandledExceptionInspection */
$sheet->output();