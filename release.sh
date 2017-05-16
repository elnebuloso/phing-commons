#!/bin/sh

################################################################################################

PHING_COMMONS_VERSION=`cat /opt/phing-commons/VERSION`
PHING_COMMONS_VERSION_FILENAME=phing-commons-$PHING_COMMONS_VERSION-$PHING_COMMONS_PHP.tar.gz

################################################################################################

rm /releases/$PHING_COMMONS_VERSION_FILENAME
tar cfzv /releases/$PHING_COMMONS_VERSION_FILENAME -C /opt/phing-commons .

################################################################################################