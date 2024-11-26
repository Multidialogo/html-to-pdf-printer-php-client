FROM php:5.5-cli

ARG WORKDIR_PATH=/app

RUN sed -i 's|httpredir.debian.org/debian|archive.debian.org/debian|g' /etc/apt/sources.list && \
    sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/jessie-updates/d' /etc/apt/sources.list && \
    sed -i '/security.debian.org/d' /etc/apt/sources.list && \
    echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid && \
    echo 'Acquire::AllowInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99no-check-valid && \
    echo 'Acquire::AllowDowngradeToInsecureRepositories "true";' >> /etc/apt/apt.conf.d/99no-check-valid && \
    echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid && \
    echo 'Acquire::AllowInsecureRepositories "true";' > /etc/apt/apt.conf.d/99ignore-validity && \
    echo 'Acquire::AllowDowngradeToInsecureRepositories "true";'

RUN apt-get update && \
    apt-get install -y --force-yes libzip-dev unzip git  ca-certificates && \
    update-ca-certificates && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer -o composer-installer.php && \
    php composer-installer.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-installer.php

RUN if [ -f /usr/local/bin/composer ]; then \
        echo "Composer installed successfully!"; \
        /usr/local/bin/composer --version; \
    else \
        echo "Composer installation failed!"; \
        exit 1; \
    fi

ENV PATH="/usr/local/bin:$PATH"

RUN git config --global --add safe.directory "$WORKDIR_PATH"

WORKDIR "$WORKDIR_PATH"