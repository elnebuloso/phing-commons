# system
FROM ubuntu:16.04
MAINTAINER jeff.tunessen@gmail.com

# terminal
ENV TERM linux
ENV DEBIAN_FRONTEND noninteractive

RUN echo "install essentials" \
    && apt-get update \
    && apt-get install -y --no-install-recommends apt-transport-https software-properties-common ca-certificates locales curl less nano \
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

# add repositories for php
RUN add-apt-repository ppa:ondrej/php

RUN echo "install php" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php5.6-cli \
        php5.6-common \
        php5.6-curl \
        php5.6-gd \
        php5.6-imagick \
        php5.6-mbstring \
        php5.6-xml \
        php5.6-xsl \
        php5.6-yaml \
        php5.6-zip \
    && apt-get -y autoremove \
    && apt-get -y clean \
    && rm -rf /var/cache/apt/archives/* \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /var/tmp/* \
    && rm -rf /usr/share/doc/* \
    && rm -rf /usr/share/man/* \
    && rm -rf /usr/share/locale/* \
    && rm -rf /tmp/*

RUN echo "install integration tools" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        subversion \
        yui-compressor \
        closure-compiler \
    && apt-get -y autoremove \
    && apt-get -y clean \
    && rm -rf /var/cache/apt/archives/* \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /var/tmp/* \
    && rm -rf /usr/share/doc/* \
    && rm -rf /usr/share/man/* \
    && rm -rf /usr/share/locale/* \
    && rm -rf /tmp/*

COPY build/ /opt/phing-common/

# phing commons installation
RUN echo "configure" \
    && mkdir -p /opt/phing-commons \
    && chmod -R 755 /opt/phing-commons/* \
    && chown -R root:root /opt/phing-commons/* \
    && ln -s /opt/phing-commons/bin/bundler /usr/local/bin/bundler \
    && ln -s /opt/phing-commons/bin/pdepend /usr/local/bin/pdepend \
    && ln -s /opt/phing-commons/bin/phing /usr/local/bin/phing \
    && ln -s /opt/phing-commons/bin/phpcbf /usr/local/bin/phpcbf \
    && ln -s /opt/phing-commons/bin/phpcpd /usr/local/bin/phpcpd \
    && ln -s /opt/phing-commons/bin/phpcs /usr/local/bin/phpcs \
    && ln -s /opt/phing-commons/bin/phploc /usr/local/bin/phploc \
    && ln -s /opt/phing-commons/bin/phpmd /usr/local/bin/phpmd \
    && ln -s /opt/phing-commons/bin/phpunit /usr/local/bin/phpunit

CMD ["sh"]