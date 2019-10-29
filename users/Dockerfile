FROM php:7.2-apache

COPY docker_configs/ports.conf /etc/apache2/conf/

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

RUN apt-get install -y p7zip \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y sqlite3

ARG PSR_VERSION=0.6.1


ENV PHALCON_VERSION=3.4.2


RUN curl -sSL "https://codeload.github.com/phalcon/cphalcon/tar.gz/v${PHALCON_VERSION}" | tar -xz \
    && cd cphalcon-${PHALCON_VERSION}/build \
    && ./install \
    && cp ../tests/_ci/phalcon.ini $(php-config --configure-options | grep -o "with-config-file-scan-dir=\([^ ]*\)" | awk -F'=' '{print $2}') \
    && cd ../../ \
    && rm -r cphalcon-${PHALCON_VERSION}



RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer
COPY . ./

RUN composer install

RUN ln -s /var/www/html/vendor/phalcon/devtools/phalcon /usr/bin/phalcon



RUN ls -ls



