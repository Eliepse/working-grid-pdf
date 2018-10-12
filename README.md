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
You can see a more complete exemple [here](/public/index.php).

```php
use Eliepse\WorkingGrid\Character;
use Eliepse\WorkingGrid\DefaultGrid;

// DefaultGrid is a provided template ready to use 
$grid = new DefaultGrid("Exemple grid 中文");

// Each character must be instanciate with this class
// The first parameter indicate the full character as a string
// The second parameter is an array of SVG path (only the data)
$character = new Character("中", ["data for stroke 1", "data for stroke 2"]);

// Add a training line with this specific character
$grid->addCharacter($character);

// Output the working grid as PDF and update response headers
$grid->print();
```


### Characters and data

This library use the `Character` class to normalize data. It takes two parameters: the character and the strokes of this
character. To draw the character, this library uses SVG data. Pass strokes data as an array. If you want to show a help
to draw the characters in the right order, order the array as well.

An strokes array exemple for the character 四.

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

In order to provide flexibility and customization, this library use a system of templates. To make a custom workgin 
grid, create a class that extends `WorkingGrid`.

```php
class MyCustomWorkginGrid extends WorkingGrid
{
    // You can override parameters here
}
```

### Configuration

You can use differents properties to customize your document. All are accessible in the template and some are accessible
as template constructor's parameters.

| Property        | Type          | Description 
|:--------------- |:--------------|:------------
| title           | string        | The title of the document.
| columns         | integer       | The number of cells (columns) per line, influence the size of cells.
| models          | integer       | The number of cells that keep a light gray character as a helping model.
| linesPerPage    | integer, null | The number of lines per page. Inluence the size of cells in order to fit all lines.
| pagePaddings    | array         | Set the padding of pages in millimeters. Formated as CSS : top, right, bottom, left.
| headerHeight    | float         | Set the header height in millimeters.
| footerHeight    | float         | Set the footer height in millimeters.
| strokeColor     | float         | Set the color of the first drawn character.
| modelColor      | string        | Set the color the characters dranw as models.
| guideColor      | string        | Set the color of guide strokes (background).

#### Features

| Property        | Type    | Description 
|:--------------- |:--------|:------------
| withStrokeOrder | boolean | Determine if you want to show helps for writing character in the right order.
| strokeOrderSize | float   | The size, in millimeters, of characters for the helping stroke orders (if activated).


### Custom header and footer

When creating a template, you can implements `CustomizableHeader` and `CustomizableFooter` in order to customize the
header and footer. The methods include a access to the instance of [mPDF](https://github.com/mpdf/mpdf) used to render
the document, and an `PageInfo` object with information of the current drawn page.


## Built With

* [mPDF](https://github.com/mpdf/mpdf): PHP library generating PDF files from UTF-8 encoded HTML
* [Make Me A Hanzi](https://github.com/skishore/makemeahanzi): Free, open-source Chinese character data
* [Source Han Sans](https://github.com/adobe-fonts/source-han-sans): a typeface from Adobe
* [Ideohint Template for Source Han Sans](https://github.com/be5invis/source-han-sans-ttf): A (hinted!) version of Source Han Sans 