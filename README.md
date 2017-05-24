# phing-commons

[![license](https://poser.pugx.org/elnebuloso/phing-commons/license)](https://packagist.org/packages/elnebuloso/phing-commons)
[![docker build statu](https://img.shields.io/docker/build/elnebuloso/phing-commons.svg)](https://hub.docker.com/r/elnebuloso/phing-commons/builds/)

## supported tags and respective `dockerfile` links

- [`php56` (dockerfile.php56)](https://github.com/elnebuloso/phing-commons/blob/master/dockerfile.php56)
- [`php70` (dockerfile.php70)](https://github.com/elnebuloso/phing-commons/blob/master/dockerfile.php70)
- [`php71` (dockerfile.php71)](https://github.com/elnebuloso/phing-commons/blob/master/dockerfile.php71)

## about

this is a full delivered build stack using phing as build tool. the phing commons build stack gives you pre-defined targets which you can configure
through a build.properties file.

## using phing commons as docker container (recommended)

### Features

- PHP Packages for PHP 5.6, 7.0, 7.1
- Composer
- Phing
- Compass
- Node 6.x
- NPM
- Yarn
- Google Closure Compiler
- YUI Compressor
- Flyway Database Migrations
- optipng
- jpegoptim
- git
- subversion


### docker compose

- use the container version for your PHP Environment

```
version: "2"

services:
  ci:
    image: elnebuloso/phing-commons:php71-latest
    volumes:
      - .:/app
```

## using phing commons over composer installation

```
composer create-project elnebuloso/phing-commons /path/to/your/phing-commons-installation
```

## configuration (build.xml)

- create build.xml file in your project root with the following content.

``` xml
<?xml version="1.0" encoding="utf-8"?>

<project basedir="." default="help">

    <!-- ============================================ -->
    <!-- import phing commons                         -->
    <!-- ============================================ -->
    <import file="${phing.home}/../../../commons/commons.xml" />

</project>
```

- if you want to configure the common targets, use a build.properties file to your project root.
- for local additions or local behaviors add a build.properties.local file. this is an optional file.
- but don't commit build.properties.local to your vcs.
- the build.properties files are optional and are loaded when available.

## calling phing over docker installation

- in project.root, call:

```
docker-compose exec ci phing
```

## calling phing over composer installation

- in project.root, call:

```
/path/to/your/phing-commons-installation/bin/phing
```

## build chain

each called step calls the previous defined step.
if running **phing init**, init calls the clean before.
if running **phing build**, build calls the complete chain.

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

### manipulate the chain

to manipulate the steps, you have the possibility to overwrite each step in your xml, just like this.

``` xml
<target name="test:main" hidden="true" depends="test.phplint, test.phpunit" />
```

if you want to use predefined chains by phing-commons you can add this as a list to the property: project.chains
separate the chains by ","

 * project.chains = php-package
 * project.chains = foo,bar,baz

### default chain

in chain, **clean:main** calls:

 * clean.tmp:init
 * clean.tmp:before
 * clean.tmp:main
 * clean.tmp:after
 * clean.tmp

### php-package chain

in chain, **init:main** calls:

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

in the default chain, **test:main** calls:

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

## links

- https://github.com/escapestudios/symfony2-coding-standard
- https://github.com/mayflower/mo4-coding-standard
- https://github.com/dotblue/codesniffer-ruleset
- https://github.com/cakephp/cakephp-codesniffer