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
 
## Reports
  * **report.phpcpd** - (PHP Copy and Paste Detection)
  * **report.phpdepend** - (PHP Software Metrics)
  * **report.phpmd** - (PHP Mess Detection)
  * **report.codesniffer** - (Checkstyle Code Analysis)
  * **report.apigen** - (API Documentation)
  * **report.clean** - (Cleans all Reports)
  * **report.all** - (Generates all active Reports)