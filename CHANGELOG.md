# CHANGELOG

## 7.0.0

- new help guidelines
- namespaced tasks

- phpmd 2.1.3
- phpmd over packagist, updated report.phpmd target and configuration
- phpmd target not using phing phpmd task, phpmd called over exec task, new phpmd not compatible with phing until now

- phploc 2.0.6
- phploc over packagist

- phpdepend (pdepend) 2.0.3
- phpdepend over packagist, updated report.phpmd target and configuration
- phpdepend target not using phing phpmd task, phpmd called over exec task, new phpmd not compatible with phing until now

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