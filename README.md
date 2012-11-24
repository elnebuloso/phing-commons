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







### Bundle CSS / JS
update build.properties (examples)

**Examples**  
project.path.css = ./public/css  
project.path.js = ./public/js

* **./public/css/build.max** - filelist with files which to be appended in order
* **./public/css/build.min** - filelist with files which to be appended in order and minified

This generates the final combined css file ./project.public.css/min.css in the bundle  
by appending build.max and build.min to one single file

### Bundle JS
update build.properties (examples)

**Examples**  
project.path.css = ./public/css  
project.path.js = ./public/js

* **./public/js/build.max** - filelist with files which to be appended in order
* **./public/js/build.min** - filelist with files which to be appended in order and minified

This generates the final combined css file ./project.public.js/min.jsin the bundle  
by appending build.max and build.min to one single file