# CHANGELOG

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