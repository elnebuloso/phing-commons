# CHANGELOG

## 9.3.0

- added codesniffer Flex1
- updated composer.format

## 9.2.0

- added pear/archive_tar composer dependency, missing by target project.bundle.tar

## 9.1.0

- added composer.install.nodev
- added composer.update.nodev
- updated chain php
- updated chain php-composer-package
- updated chain php-website
- changed in chain php-website composer.install to composer.install.nodev

## 9.0.0

- no support for php 5.3
- updated bundler to 9.0.0

## 8.11.0

- build chain php changed composer.update to composer.install
- build chain php-composer-package changed composer.update to composer.install
- build chain php-website changed composer.update to composer.install

## 8.10.0

- composer.format changed to JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT 

## 8.9.0, 8.9.1

- updated composer packages to newest versions
- tested composer packages with build targets, updated composer.lock for tested installation
- twitter tweet task to tweet the current package

## 8.8.2

- global configuration over user home directory, optional

## 8.8.0, 8.8.1

- updated project.bundle.tar
  - suffix .gz for files compressed with gzip
  - suffix .bz2 for files compressed with bzip2

- project.bundle
  - exclude docs folder as default

## 8.7.0

- updated project.bundle.tar
  - timestamped yes as default
  - new config project.bundle.tar.copy.todir (copy file to additional directory)

- updated project.bundle.zip
  - timestamped yes as default
  - new config project.bundle.zip.copy.todir (copy file to additional directory)

## 8.6.2

. added tests/**/*.php to whitelist patternset phpcs

## 8.6.1

-  added composer.lock for tested dependencies on installing phing commons

## 8.6.0

- updated dependencies
- "phing\/phing": "2.11.0",
- "phpmd\/phpmd": "2.2.3",
- "pdepend\/pdepend": "2.1.0",
- "phploc\/phploc": "2.1.3",
- "sebastian\/phpcpd": "2.0.2",
- "squizlabs\/php_codesniffer": "2.3.2",
- "apigen\/apigen": "4.1.1",
- "phpunit\/phpunit": "4.7.4"
- report.phpcs now using PSR1,PSR2 as codesniffer standards
- report.phpcs removed flex coding standards
- report.apigen no need for neon configuration file
- removed jenkins targets

## 8.5.0

- updated project.bundle.tar
- added project.bundle.zip
- updated chain/php
- updated chain/php-composer-package
- updated chain/php-website

## 8.4.0

- updated chains
- added project.bundle
- added project.bundle.tar
- added clean.bundle
- update codesniffs

## 8.3.0

- project packaging
- removed jenkins target from chains

## 8.2.0

- project packaging

## 8.1.0

- elnebuloso/bundler integration
- bundle.javascript added
- bundle.stylesheet added

## 8.0.3

- bugfix project.package patternset

## 8.0.2

- added project.package target
- added chain php-website that uses project.package and composer.optimize

## 8.0.1

- added composer.optimize target

## 8.0.0

- updated chains
- moved jenkins environment target to own target area

## 7.0.2

- removed report target from chain(s) build:after

## 7.0.1

- updated composer tasks
- updated php chain

## 7.0.0

- new help guidelines
- namespaced tasks

- phpmd/phpmd: 2.1.3 (packagist)
- report.phpmd updated target and configuration
- report.phpmd target not using phing phpmd task, phpmd called over exec task, new phpmd not compatible with phing until now

- phploc/phploc: 2.0.6 (packagist)
- report.phploc

- pdepend/pdepend: 2.0.3 (packagist)
- report.phpdepend updated target and configuration
- report.phpdepend target not using phing pdepend task, pdepend called over exec task, new pdepend not compatible with phing until now

- squizlabs/php_codesniffer: 2.0.0RC4 (packagist)
- report.phpcs

- sebastian/phpcpd: 2.0.1 (packagist)
- report.phpcpd

- apigen/apigen: 4.0.0-RC4
- report.apigen
- report.apigen updated target and configuration
- report.apigen target not using phing apigen task, apigen called over exec task, new apigen not compatible with phing until now

- phpunit/phpunit: 4.3.5
- test.phpunit

## 6.8.2

- bugfix, PBC_PROJECT_VERSION_JENKINS -> PBC_PROJECT_VERSION

## 6.8.1

- bugfix, project.version.update writes build.properties.jenkins new

## 6.8.0

- new target: project.jenkins.init
- project.jenkins.init writes build.properties.jenkins
- project.jenkins.init added in chain php on build:before
- project.jenkins.init added in chain php-composer-package on build:before

## 6.7.0

- changed project.update.version to project.version update
- project.version.update now updates the build.properties file and sets the current project.version

## 6.6.7

- added changelog