phing-commons
=============

## Installation
* copy build.xml from vendor/elnebuloso/phing-commons to your-project-root
* copy build.properties from vendor/elnebuloso/phing-commons to your-project-root
* copy build.apigen.config from vendor/elnebuloso/phing-commons to your-project-root
* update these build files optional with your settings
* update the import path in build.xml to /vendor/elnebuloso/phing-commons/src/xml/base.xml

## Tests
  * **test.phplint** - (PHP Validation)
  * **test.phpunit** - (PHP Unit Testing)
  * **test.jslint** - (JS Validation)  
 
## Reports
  * **report.phpcpd** - (PHP Copy and Paste Detection)
  * **report.phpdepend** - (PHP Software Metrics)
  * **report.phpmd** - (PHP Mess Detection)
  * **report.codesniffer** - (Checkstyle Code Analysis)
  * **report.apigen** - (API Documentation)
  * **report.clean** - (Cleans all Reports)
  * **report.all** - (Generates all active Reports)
  
## Bundle
  * **bundle.pack.css** - (CSS Minify / Packing)
  * **bundle.pack.js** - (JS Minify / Packing)
  * **bundle** - (Bundle the project)
  
## Bundle CSS Strukture
/path/to/your/css/folder

  * **build.load** filelist with files ignored by bundle
  * **build.max** filelist with files which are packed but not minified
  * **build.min** filelist with files which are packed and minified
  
These filelists can also be used for outputting the files in development.
The loading / bundle order ist build.max, build.min

## Bundle JS Strukture
/path/to/your/js/folder

  * **build.load** filelist with files ignored by bundle
  * **build.max** filelist with files which are packed but not minified
  * **build.min** filelist with files which are packed and minified
  
These filelists can also be used for outputting the files in development.
The loading / bundle order ist build.max, build.min