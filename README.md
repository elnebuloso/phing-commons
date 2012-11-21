phing-commons
=============

## Installation
* copy build.xml from vendor/elnebuloso/phing-commons to your-project-root
* copy build.properties from vendor/elnebuloso/phing-commons to your-project-root
* copy build.properties.apigen from vendor/elnebuloso/phing-commons to your-project-root

## Settings
* update build.properties
* update build.properties.apigen (optional)
* look at /vendor/elnebuloso/phing-commons/src/xml/init.xml
 * you can overwrite every init task in your custom build.xml for editing e.g. patternsets

## Running
- phing

Calling the phing command without any task shows all available tasks.

## Tests
* **test.phplint** (PHP Validation)
* **test.phpunit** (PHP Unit Testing)
* **test.jslint** (JS Validation) 
* **test** (run all)

## Reports
* **report.phpcpd** (PHP Copy and Paste Detection)
* **report.phpdepend** (PHP Software Metrics)
* **report.phpmd** (PHP Mess Detection)
* **report.codesniffer** (PHP Checkstyle Code Analysis)
* **report.apigen** (PHP API Documentation)
* **report.clean** (clean all reports)
* **report.all** (run all)
  
## Bundle
* **bundle.pack.css** (CSS Minify / Append)
* **bundle.pack.js** (JS Minify / Append)
* **bundle.pack** (Minify / Append)
* **bundle** (bundle the project)

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