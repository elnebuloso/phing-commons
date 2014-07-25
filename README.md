phing-commons
=============

phing commons build stack

## Installation

```
composer create-project elnebuloso/phing-commons /path/to/your/phing-commons-installation
```

## Usage

Create build.xml file in your project root with the following content.
To use the Phing Commons, just call /path/to/your/phing-commons-installation/**bin/phing**

```
<?xml version="1.0" encoding="UTF-8"?>


<project basedir="." default="help">


    <!-- ============================================ -->
    <!-- import phing commons                         -->
    <!-- ============================================ -->
    <import file="${phing.home}/../../../commons/commons.xml" />


</project>
```

## Build Chain

Each called step calls the previous defined step.
If running **phing init**, init calls the clean before.
If running **phing build**, build calls the complete chain.

 * chain.clean:before
 * chain.clean:main
 * chain.clean:after
 * clean
 * chain.init:before
 * chain.init:main
 * chain.init:after
 * init
 * chain.test:before
 * chain.test:main
 * chain.test:after
 * test
 * chain.bundle:before
 * chain.bundle:main
 * chain.bundle:after
 * bundle
 * chain.package:before
 * chain.package:main
 * chain.package:after
 * package
 * chain.deploy:before
 * chain.deploy:main
 * chain.deploy:after
 * deploy
 * chain.build:before
 * chain.build:main
 * chain.build:after
 * build

### Manipulate the Chain

To manipulate the steps, you have the possibility to overwrite each step, just like this, where depends are your or phing common targets.

```
<target name="test:main" hidden="true" depends="test.phplint, test.phpunit" />
```

### Default Chain

In the default chain, **chain.clean:main** calls:

 * clean.tmp:init:
 * clean.tmp:before:
 * clean.tmp:main:
 * clean.tmp:after:
 * clean.tmp

In the default chain, **chain.init:main** calls:

 * composer.update:init:
 * composer.update:before:
 * composer.update:main:
 * composer.update:after:
 * composer.update:

In the default chain, **chain.test:main** calls:

 * test.phplint:init:
 * test.phplint:before:
 * test.phplint:main:
 * test.phplint:after:
 * test.phplint:
 * test.phpunit:init:
 * test.phpunit:before:
 * test.phpunit:main:
 * test.phpunit:after:
 * test.phpunit: