# system
FROM ubuntu:14.04
MAINTAINER jeff.tunessen@gmail.com

# terminal
ENV TERM linux
ENV DEBIAN_FRONTEND noninteractive

# install essentials
RUN apt-get update \
    && apt-get install -y --no-install-recommends software-properties-common ca-certificates locales curl less nano \
    && locale-gen en_US \
    && locale-gen en_US.UTF-8 \
    && locale-gen de_DE \
    && locale-gen de_DE.UTF-8 \
    && echo 'alias l="ls -alhF"' > /root/.bash_aliases \
    && apt-get -y autoremove \
    && apt-get -y clean \
    && rm -rf /var/cache/apt/archives/* \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /var/tmp/* \
    && rm -rf /usr/share/doc/* \
    && rm -rf /usr/share/man/* \
    && rm -rf /usr/share/locale/* \
    && rm -rf /tmp/*

# set system-wide locale settings
ENV LC_ALL en_US.UTF-8

# https://launchpad.net/~ondrej/+archive/ubuntu/php
# The main PPA for PHP
RUN add-apt-repository ppa:ondrej/php

# sleep infinity, use container as running system you can bash in
CMD ["tail", "-f", "/dev/null"]