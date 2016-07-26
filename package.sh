#!/bin/sh

################################################################################################

rm -rf /tmp/phing-commons
mkdir -p /tmp/phing-commons
composer create-project elnebuloso/phing-commons /tmp/phing-commons

################################################################################################

PHING_COMMONS_VERSION=`cat /tmp/phing-commons/VERSION`
PHING_COMMONS_VERSION_FILENAME=phing-commons-$PHING_COMMONS_VERSION.tar.gz

################################################################################################

tar cfzv /var/releases/phing-commons/$PHING_COMMONS_VERSION_FILENAME -C /tmp/phing-commons .

################################################################################################