# phing-commons

Phing Build Stack

## supported tags and respective `dockerfile` links

- https://hub.docker.com/r/elnebuloso/phing-commons/tags/
- [`php56` (Dockerfile.php56)](https://github.com/elnebuloso/phing-commons/blob/master/Dockerfile.php56)
- [`php70` (Dockerfile.php70)](https://github.com/elnebuloso/phing-commons/blob/master/Dockerfile.php70)
- [`php71` (Dockerfile.php71)](https://github.com/elnebuloso/phing-commons/blob/master/Dockerfile.php71)

## about

this is a full delivered build stack using phing as build tool. the phing commons build stack gives you pre-defined targets which you can configure
through a build.properties file.

## features

- PHP 5.6, 7.0, 7.1
- Phing
- Composer
- YUI Compressor
- Google Closure Compiler

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

## using phing commons as docker container (recommended)

### run through docker

- no installation necessary, just call in roject.root:

```
docker run -v ${PWD}:/app elnebuloso/phing-commons:php56-10.6.0 phing
docker run -v ${PWD}:/app elnebuloso/phing-commons:php70-10.6.0 phing
docker run -v ${PWD}:/app elnebuloso/phing-commons:php71-10.6.0 phing
```

```
docker run -v ${PWD}:/app elnebuloso/phing-commons:php56-latest phing
docker run -v ${PWD}:/app elnebuloso/phing-commons:php70-latest phing
docker run -v ${PWD}:/app elnebuloso/phing-commons:php71-latest phing
```

### run through docker-compose

```
version: "2"

services:
  pc:
    image: elnebuloso/phing-commons:php71-10.6.0
    volumes:
      - .:/app
```

```
docker-compose run pc phing
```

## using phing commons through composer

### install

```
composer create-project elnebuloso/phing-commons /path/to/your/phing-commons-installation
```

### run in project root

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