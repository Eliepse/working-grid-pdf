<?php

require __DIR__ . '/../vendor/autoload.php';

use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\Template\Examples\StrokesTemplate;
use Eliepse\WorkingGrid\WorkingGrid;

function getStrokes(string $filename): array { return json_decode(file_get_contents(__DIR__ . "/../resources/samples/strokes/$filename.json"), true); }

WorkingGrid::inlinePrint(new StrokesTemplate, [
	new Word([new Character("中", getStrokes("zhong"))]),
	new Word([new Character("国", getStrokes("guo"))]),
	new Word([
		new Character("中", getStrokes("zhong")),
		new Character("国", getStrokes("guo")),
	]),
	new Word([new Character("一", getStrokes("yi"))]),
	new Word([new Character("二", getStrokes("er"))]),
	new Word([new Character("三", getStrokes("san"))]),
	new Word([new Character("四", getStrokes("si"))]),
	new Word([new Character("五", getStrokes("wu"))]),
	new Word([
		new Character("十", getStrokes("shi")),
		new Character("一", getStrokes("yi")),
	]),
	new Word([new Character("六", getStrokes("liu"))]),
	new Word([new Character("七", getStrokes("qi"))]),
	new Word([new Character("八", getStrokes("ba"))]),
	new Word([new Character("九", getStrokes("jiu"))]),
	new Word([new Character("十", getStrokes("shi"))]),
	new Word([
		new Character("十", getStrokes("shi")),
		new Character("二", getStrokes("er")),
	]),
]);