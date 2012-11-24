phing-commons
=============

## Installation
* copy build.xml from vendor/elnebuloso/phing-commons to your-project-root
* copy build.properties from vendor/elnebuloso/phing-commons to your-project-root
* copy build.properties.apigen from vendor/elnebuloso/phing-commons to your-project-root

## Settings
* update build.properties
* update build.properties.apigen (optional)
* [target]:after, [target]:before
 * overwrite in your build.xml to use these hooks
* [target]:init
 * used to set default patternsets
 * overwrite to use your patternsets
 * naming: patternset.[target] e.g. patternset.test.phplint

## Running
* phing
 * running phing without a target outputs a help

## Tests
* **test.phplint** (PHP Validation)
 * :init
 * :before
 * :after
* **test.phpunit** (PHP Unit Testing)
 * :init
 * :before
 * :after
* **test.jslint** (JS Validation) 
 * :init
 * :before
 * :after
* **test** (run all)

## Reports
* **report.phpcpd** (PHP Copy and Paste Detection)
 * :init
 * :before
 * :after
* **report.phpdepend** (PHP Software Metrics)
 * :init
 * :before
 * :after
* **report.phpmd** (PHP Mess Detection)
 * :init
 * :before
 * :after
* **report.codesniffer** (PHP Checkstyle Code Analysis)
 * :init
 * :before
 * :after
* **report.apigen** (PHP API Documentation)
 * :init
 * :before
 * :after
* **report.clean** (clean all reports)
 * :init
 * :before
 * :after
* **report** (run all)
  
## Bundle
* **bundle.js** (JS minification / appending)
 * :init
 * :before
 * :after
* **bundle.css** (CSS minification / appending)
 * :init
 * :before
 * :after
* **bundle** (run all)

## Package
* **package.project** (package the project)
 * :init
 * :before
 * :after
* **package** (run all)

### Bundle JS

**properties used from build.properties**
* project.public.js
* project.bundle
 * bundle folder
 * e.g. ./bundle
* project.bundled.js
 * final bundled file
 * e.g. ./public/js/bundled.js
 
The Tasks looks under project.public.js for the following files:
* bundle.max
 * filelist with files which to be appended in the bundled file
* bundle.min
 * filelist with files which to be minified and appended in the bundled file

Task Process:
* appending files from bundle.max to max.tmp file
* appending files from bundle.min to min.tmp file
* minifying min.tmp file
* appending files max.tmp,min.tmp to project.bundled.js

### Bundle CSS

**properties used from build.properties**
* project.public.css
* project.bundle
 * bundle folder
 * e.g. ./bundle
* project.bundled.css
 * final bundled file
 * e.g. ./public/css/bundled.css
 
The Tasks looks under project.public.css for the following file:
* bundle
 * filelist with files which to be minified and appended in the bundled file

Task Process:
* appending files from bundle to min.tmp file
* minifying min.tmp file
* appending files min.tmp to project.bundled.css