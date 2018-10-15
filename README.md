# Working grid PDF
Library to easily create working grids and export them as PDF

This library works with SVG. If you are looking for resources about chinese characters, strokes as svg, you might want 
to take a look at [Make Me A Hanzi](https://github.com/skishore/makemeahanzi).

## Installation

You can install this library using composer.

```
$ composer require eliepse/working-grid-pdf
```


### Custom header and footer

When creating a template, you can implements `CustomizableHeader` and `CustomizableFooter` in order to customize the
header and footer. The methods include a access to the instance of [mPDF](https://github.com/mpdf/mpdf) used to render
the document, and an `PageInfo` object with information of the current drawn page.


## Built With

* [mPDF](https://github.com/mpdf/mpdf): PHP library generating PDF files from UTF-8 encoded HTML
* [Make Me A Hanzi](https://github.com/skishore/makemeahanzi): Free, open-source Chinese character data
* [Source Han Sans](https://github.com/adobe-fonts/source-han-sans): a typeface from Adobe
* [Ideohint Template for Source Han Sans](https://github.com/be5invis/source-han-sans-ttf): A (hinted!) version of Source Han Sans 