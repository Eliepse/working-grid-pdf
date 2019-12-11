# Changelog
All notable changes to this project will be documented in this file. 
The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/) 
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased

## 2.1.6 - 2019-12-11
### Fixed
- Pinyin superposition on pages with very thin rows

## 2.1.5 - 2019-11-18
### Fixed
- Pinyin superposition on pages with thin rows

## 2.1.4 - 2019-10-23
### Changed
- Updated to mpdf 8

## 2.1.3 - 2019-09-18
### Fixed
- Corrected exemples interfaces implementation
- Fixed deprecated function (php 7.3)

## 2.1.2 - 2019-06-30
### Fixed
- Fixed the error when using a view that is not inside a subdirectory

## 2.1.1 - 2019-06-30
### Added
- `release` command as a Composer script

### Fixed
- Improved visual rendering of pinyin and row number
- Pinyin could not be used along strokes order

## 2.1.0 - 2019-06-29
### Added
- Row number
- New helper for debug
- Pinyin support

### Changed
- Refactor grid preview (example) to handle more than one example

### Fixed
- Updated README documentation

## 2.0.2 - 2019-03-16
### Added
- Grid colors can be modified from the template

## 2.0.1-beta - 2018-10-21
### Fixed
- Namespace on helpers to prevent fatal error of multi-declaration of a function

## 2.0.0-beta - 2018-10-15
### Added
- **Breaking change:** implemented words support
- `PageConfig` and `GridConfig` config classes
- `WithDrawingTutorial` interface to decide to show characters' strokes drawing exemple
- `view()`, `base_path()`, `resources_path()`, `array_contains()` helpers
- `ViewNotFoundException`
- `Drawable` interface
- `FillAttributes` trait to easily add attributes filling support to a class
- Added a file to simplify development server setup

### Changed
- **Breaking change:** new template
- **Breaking change:** new generation process
- New class structure implementing `Iterator` and `Countable` to easily handle page, row and cells generation
- Implemented `Drawable` to `Character` class
- Updated guide on readme

### Removed
- **Breaking change:** Removed `DefaultGrid` class
- **Breaking change:** Removed `WorkingGridBase` class
- **Breaking change:** Removed `WorkingGridCompiler` class


## 1.1.0 - 2018-10-12
### Added
- New color management usable by templates
 
### Changed
- Better management of template data

## 1.0.0 - 2018-10-03
### Added
- Complete the README (guide included !)

### Fixed
- Correct colors


## 0.3.3 - 2018-10-03
### Added
- Added phpdocs
- Added `download` method
- Added `content` method
- Source Han Sans is now the default font 

### Changed
- Renamed a method
- Clean `WorkingGridBase` class


## 0.3.2 - 2018-10-02
### Added
- New methods to get page paddings

### Fixed
- Remove wrong offset for body


## 0.3.1 - 2018-10-02
### Added
- Support chinese characters in text

### Changed
- Changed library used to make PDF


## 0.3.0 - 2018-10-02
### Added
- Added more exemples

### Changed
- Changed proportions of characters
- Changed behaviors to be more flexible : does not work at all as previous version !

### Fixed
- Fixed a path in exemple


## 0.2.1 - 2018-10-01
### Changed
- Refactor cell drawing

### Fixed
- Simplify lines generation to fix page breaks


## 0.2.0 - 2018-09-30
### Added
- Added lines per page support

### Fixed
- `linesPerPage` setting didn't limit number of lines on some cases


## 0.1.2 - 2018-09-30
### Fixed
- Fix width of stroke order rectangle


## 0.1.1 - 2018-09-30
### Fixed
- Fix relative path for svg


## 0.1.0 - 2018-09-30
### Added
- Added main elements of the library
- Added an exemple