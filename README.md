# phing-commons

[![Software License](https://img.shields.io/packagist/l/elnebuloso/flex-view.svg?style=flat-square)](LICENSE)

phing commons build stack

## Installation

```
composer create-project elnebuloso/phing-commons /path/to/your/phing-commons-installation
```

## Usage

Create build.xml file in your project root with the following content.
To use the Phing Commons, just call /path/to/your/phing-commons-installation/**bin/phing**

``` xml
<?xml version="1.0" encoding="UTF-8"?>


<project basedir="." default="help">


    <!-- ============================================ -->
    <!-- import phing commons                         -->
    <!-- ============================================ -->
    <import file="${phing.home}/../../../commons/commons.xml" />


</project>
```

## Configuration

If you want to configure the common targets, use a build.properties file to your project root.
For local additions or local behaviors add a build.properties.local file. This is an optional file.
But don't commit build.properties.local to your VCS.

The build.properties and the build.properties are optional files and are loaded when available.

## Build Chain

Each called step calls the previous defined step.
If running **phing init**, init calls the clean before.
If running **phing build**, build calls the complete chain.

 * build:before
 * clean:before
 * clean:main
 * clean:after
 * clean
 * init:before
 * init:main
 * init:after
 * init
 * test:before
 * test:main
 * test:after
 * test
 * bundle:before
 * bundle:main
 * bundle:after
 * bundle
 * package:before
 * package:main
 * package:after
 * package
 * deploy:before
 * deploy:main
 * deploy:after
 * deploy
 * build:main
 * build:after
 * build

### Manipulate the Chain

To manipulate the steps, you have the possibility to overwrite each step in your xml, just like this.

``` xml
<target name="test:main" hidden="true" depends="test.phplint, test.phpunit" />
```

If you want to use predefined chains by phing-commons you can add this as a list to the property: project.chains
Separate the chains by ","

 * project.chains = php-composer-package
 * project.chains = foo,bar,baz

### default Chain

In chain, **clean:main** calls:

 * clean.tmp:init
 * clean.tmp:before
 * clean.tmp:main
 * clean.tmp:after
 * clean.tmp

### php-composer-package Chain

In chain, **init:main** calls:

 * composer.validate:init
 * composer.validate:before
 * composer.validate:main
 * composer.validate:after
 * composer.validate
 * composer.update:init
 * composer.update:before
 * composer.update:main
 * composer.update:after
 * composer.update

In the default chain, **test:main** calls:

 * test.phplint:init
 * test.phplint:before
 * test.phplint:main
 * test.phplint:after
 * test.phplint
 * test.phpunit:init
 * test.phpunit:before
 * test.phpunit:main
 * test.phpunit:after
 * test.phpunit
