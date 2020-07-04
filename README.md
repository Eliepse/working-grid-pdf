# Working grid PDF
Library to easily create working grids and export them as PDF

This library works with SVG. If you are looking for resources about chinese characters, strokes as svg, you might want 
to take a look at [Make Me A Hanzi](https://github.com/skishore/makemeahanzi).

## Installation

You can install this library using composer.

```
$ composer require eliepse/working-grid-pdf
```


## Usage

The most basic way of using this library would be like the following.
You can see a more complete exemple in the [public](/public) directory.

```php
use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\Elements\Word;
use Eliepse\WorkingGrid\Template\Examples\DefaultTemplate;
use Eliepse\WorkingGrid\WorkingGrid;

// Use the static method to generate pdf 
// passing a template and an array of words
WorkingGrid::inlinePrint(
    new DefaultTemplate, 
    [
        new Word([new Character("中", [strokes data here])]),
        new Word([new Character("国", [...])]),
        new Word([
            new Character("中", [...]),
            new Character("国", [...])
        ])
    ]
);
```

### Words, characters and strokes data

#### Words

This libray support multi-characters words. To normalize data, pass, you must instanciate your `Word` class with 
`Drawable` elements. The `Character` class is a ready-to-use _Drawable._

#### Characters

`Character` class takes two parameters: the character as a string and the strokes of this character. To draw the 
character, this library uses SVG data. Pass strokes data as an array. If you want to show a help to draw the characters 
in the right order, order the array as well. Using this class is not required, you can create your own but it must 
implement the `Drawable` interface.

An exemple of an array of strokes for the character 四:

```php
[
    "M 326 667 Q 283 663 312 640 [...] Q 420 673 326 667 Z",
    "M 329 421 Q 304 417 332 392 [...] Q 435 441 329 421 Z",
    "M 130 165 Q 102 162 122 139 [...] Q 643 210 130 165 Z"
]
```

To see more exemples data, check the content of the [/samples/strokes](/resources/samples/strokes) folder where some
characters are stored in JSON. Take a look at [Make Me A Hanzi](https://github.com/skishore/makemeahanzi) to get more
open source strokes data !

### Templates

In order to provide flexibility and customization, this library use a system of templates. To make a custom working 
grid, create a class that extends `Template`, or use [predifiened examples](/src/Template/Examples). 

```php
class MyTemplate extends Template
{
    // You can override parameters here, 
    // see configuration chapter of this file
}
```

### Custom header and footer

When creating a template, you can implements `CustomizableHeader` and `CustomizableFooter` in order to customize the
header and footer. The methods include a access to the instance of [mPDF](https://github.com/mpdf/mpdf) used to render
the document, and an `PageInfo` object with information of the current drawn page.

### Extras

#### Strokes order

Too print a help that show the strokes order, simply implement the `WithDrawingTutorial` interface to your template.

#### Pinyin

If you want to show the pinyin of caracters, implement the `WithPinyin` interface to your template.

### Configuration

You can use differents properties to customize your document. All are accessible in the template and some are accessible
as template constructor's parameters.

| Property        | Type          | Description 
|:--------------- |:--------------|:------------
| title           | string        | The title of the document.
| columns_amount  | integer       | The number of cells (columns) per line, influence the size of cells.
| model_amount    | integer       | The number of cells that keep a light gray character as a helping model.
| paddings        | array         | Set the padding of pages in millimeters. Formated as CSS : top, right, bottom, left.
| header_height   | float         | Set the header height in millimeters.
| footer_height   | float         | Set the footer height in millimeters.
| stroke_color    | float         | Set the color of the first drawn character.
| model_color     | string        | Set the color the characters dranw as models.
| grid_color      | string        | Set the color of the grid.
| guide_color     | string        | Set the color of guide strokes (background).

#### Features

| Property        | Type    | Description 
|:--------------- |:--------|:------------
| tutorial_height | float   | The size, in millimeters, of box that shows a help for drawing strokes. Relative to the cell size when set to 0.


## Built With

* [mPDF](https://github.com/mpdf/mpdf): PHP library generating PDF files from UTF-8 encoded HTML
* [Make Me A Hanzi](https://github.com/skishore/makemeahanzi): Free, open-source Chinese character data
* [Source Han Sans](https://github.com/adobe-fonts/source-han-sans): a typeface from Adobe
* [Ideohint Template for Source Han Sans](https://github.com/be5invis/source-han-sans-ttf): A (hinted!) version of Source Han Sans 