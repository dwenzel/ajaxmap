ajaxmap
=======

Ajax Map is an extension for the TYPO3 CMS. It allows to show a map with locations. 
Display can be filtered interactivly by type, region and categories. 
Categories are shown and selected in a tree view. 
The map view is highly configurable. Regions are defined by KML files. They are displayed as map overlays an can be switched on/off in frontend.  
See also: <https://forge.typo3.org/projects/extension-ajaxmap>

[![Coverage Status](https://coveralls.io/repos/dwenzel/ajaxmap/badge.png)](https://coveralls.io/r/dwenzel/ajaxmap)

## Requirements

* TYPO3 CMS 9

## Installation

* Install extension:
```bash
composer require dwenzel/ajaxmap
``` 

* Include static TypoScript Template 


## Contribution

Suggestions and contributions are highly welcome.
Please submit issues or pull requests.

### Install Dependencies
```
npm install
```

### Build JavaScript

The main extension script is located in `Resources/Public/JavaScript` 
and build into the `Resources/Public/Dist` directory.

* Production Mode

```
npx webpack --mode=production --watch=true
```
* Development Mode

```
npx webpack --mode=development --watch=true
```
