FROM ubuntu:16.04
MAINTAINER jeff.tunessen@gmail.com

ENV TERM linux
ENV DEBIAN_FRONTEND noninteractive

RUN echo "install system essentials" \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        software-properties-common \
        ca-certificates locales \
        curl \
        less \
        nano \
    && locale-gen en_US \
    && locale-gen en_US.UTF-8 \
    && locale-gen de_DE \
    && locale-gen de_DE.UTF-8 \
    && echo 'alias l="ls -alhF"' > /root/.bash_aliases \
    && curl -sSL https://releases.rancher.com/install-docker/17.03.sh | bash \
    && curl -L https://github.com/docker/compose/releases/download/1.19.0/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose \
    && chmod +x /usr/local/bin/docker-compose \
    && apt-get -y autoclean \
    && apt-get -y autoremove \
    && rm -rf /var/cache/apt/archives/* \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /var/tmp/* \
    && rm -rf /usr/share/doc/* \
    && rm -rf /usr/share/man/* \
    && rm -rf /usr/share/locale/* \
    && rm -rf /tmp/*

ARG PHP_VERSION=7.2

ENV LC_ALL en_US.UTF-8
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /srv/composer

RUN echo "install php" \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-common \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-imagick \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-ssh \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-yaml \
        php${PHP_VERSION}-zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get -y autoremove \
    && apt-get -y clean \
    && rm -rf /var/cache/apt/archives/* \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /var/tmp/* \
    && rm -rf /usr/share/doc/* \
    && rm -rf /usr/share/man/* \
    && rm -rf /usr/share/locale/* \
    && rm -rf /tmp/*

ENV PATH="/srv/composer/vendor/bin:${PATH}"

RUN echo "install php tools" \
    && composer global require \
        phing/phing \
        phploc/phploc:2.* \
        phpmd/phpmd:2.6.0 \
        pdepend/pdepend:2.5.0 \
        sebastian/phpcpd:2.0.4 \
        phpmetrics/phpmetrics:2.2.0

COPY main /srv/phing
COPY VERSION /srv/phing/VERSION

CMD ["sh"]