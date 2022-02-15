FROM ubuntu:20.04
ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN set -ex \
    && apt update \
    && apt install -y gnupg2 \
    && rm -rf /tmp/repimport \
    && mkdir -m 700 /tmp/repimport \
    && LC_ALL=C.UTF-8 gpg2 \
        --homedir /tmp/repimport \
        --keyserver keyserver.ubuntu.com \
        --recv-key 14AA40EC0831756756D7F66C4F4EA0AAE5267A6C \
    && LC_ALL=C.UTF-8 gpg2 \
        --homedir /tmp/repimport \
        -a \
        --export 14AA40EC0831756756D7F66C4F4EA0AAE5267A6C \
        | apt-key add - \
    && rm -rf /tmp/repimport \
    && echo "deb http://ppa.launchpad.net/ondrej/php/ubuntu focal main" \
        > /etc/apt/sources.list.d/ondrej-ubuntu-php-focal.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        python3 \
        python3-pip \
        python3-setuptools \
        supervisor \
        rsyslog \
        ca-certificates \
        file \
        git \
        re2c \
        unzip \
        netcat \
        php8.1-fpm \
        php8.1-common \
        php8.1-cli \
        php8.1-phpdbg \
        php8.1-opcache \
        php8.1-readline \
        php8.1-bcmath \
        php8.1-curl \
        php8.1-gd \
        php8.1-gmp \
        php8.1-imap \
        php8.1-intl \
        php8.1-mbstring \
        php8.1-mysql \
        php8.1-pgsql \
        php8.1-soap \
        php8.1-sqlite3 \
        php8.1-xml \
        php8.1-zip \
        php8.1-imagick \
        php8.1-redis \
        php8.1-xdebug \
    && rm -rf /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN set -ex \
    && cd /tmp \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && chmod +x /usr/bin/composer \
    && rm -rf /tmp/*

RUN set -ex \
    && mkdir -p /opt/data \
    && chown www-data:www-data /opt/data \
    && mkdir -p /var/www/html \
    && chown www-data:www-data /var/www/html \
    && mkdir -p /run/php \
	&& cd /etc/php/8.1/fpm \
	&& { \
		echo '[global]'; \
		echo 'error_log = /proc/self/fd/2'; \
		echo; \
		echo '[www]'; \
		echo '; if we send this to /proc/self/fd/1, it never appears'; \
		echo 'access.log = /proc/self/fd/2'; \
		echo; \
		echo 'clear_env = no'; \
		echo; \
		echo '; Ensure worker stdout and stderr are sent to the main error log.'; \
		echo 'catch_workers_output = yes'; \
	} | tee pool.d/docker.conf \
	&& { \
		echo '[global]'; \
		echo 'daemonize = no'; \
		echo; \
		echo '[www]'; \
		echo 'listen = 9000'; \
	} | tee pool.d/zz-docker.conf

COPY docker-php-entrypoint /usr/local/bin/

ENTRYPOINT ["docker-php-entrypoint"]

WORKDIR /var/www/html
RUN mkdir /testtask && mkdir /testtask/backend && chown -R 1000:1000 /testtask/backend
EXPOSE 9000

CMD ["php-fpm8.1"]
