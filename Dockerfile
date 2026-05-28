############################################
# Base Image
############################################
FROM serversideup/php:7.4-fpm-nginx AS base

USER root
RUN install-php-extensions \
    bcmath \
    bz2 \
    exif \
    gettext \
    gd \
    imagick \
    intl \
    ldap \
    opcache \
    pdo_mysql \
    soap \
    xdebug \
    zip

RUN docker-php-serversideup-dep-install-debian git

USER www-data

############################################
# Development Image
############################################
FROM base AS development

# We can pass USER_ID and GROUP_ID as build arguments
# to ensure the www-data user has the same UID and GID
# as the user running Docker.
ARG USER_ID
ARG GROUP_ID

# Switch to root so we can do root things
USER root
RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID  && \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx && \
    chown -R $USER_ID:$GROUP_ID /composer

# Drop back to our unprivileged user
USER www-data

############################################
# Production Image
############################################

# Since we're calling "base", production isn't
# calling any of that permission stuff
FROM base AS production

# Copy our app files as www-data (33:33)
COPY --chown=www-data:www-data . /var/www/html