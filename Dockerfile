FROM php:8.0.30-cli-bullseye

# Set environment variables
ENV NVM_DIR /home/biome/.nvm
ENV NODE_VERSION 16.20.1
ENV NPM_VERSION 7.24.0
#
# Install needed libraries
#
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    wget \
    git \
    vim \
    sudo \
    curl \
    build-essential \
    libssl-dev \
    gnupg \
    gnupg2 \
    gnupg1

#
# PHP Extensions
#
RUN docker-php-ext-install \
    zip \
    pdo \
    pdo_pgsql

#
# Composer
#
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#
# Arguments for the UID and GID, to run the docker with the same host user:gropu
#
ARG DOCKER_UID
ARG DOCKER_GID

# Create a user biome with group biome
RUN groupadd -g ${DOCKER_GID} biome && \
    useradd -r -u ${DOCKER_UID} --create-home -g biome biome && \
    # biome user can use sudo
    echo "biome ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers && \
    mkdir /app && chown biome:biome /app

#
# Use the biome user
#
USER biome


# Install NVM
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | bash

# Load NVM script
RUN /bin/bash -c "source $NVM_DIR/nvm.sh && nvm install $NODE_VERSION && nvm alias default $NODE_VERSION && nvm use default && npm install -g npm@$NPM_VERSION"

# Add NVM to bash to automatically run every time a new shell is started
RUN echo "source $NVM_DIR/nvm.sh" >> /home/biome/.bashrc

USER root
#
# Postgresql
#
# https://www.postgresql.org/download/linux/debian/
RUN sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt bullseye-pgdg main" > /etc/apt/sources.list.d/pgdg.list' && \
    wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add -  && \
    apt-get update && \
    apt-get -y install postgresql-12 && \
    # Enable to also connect from the host
    echo "listen_addresses = '*'" >> /etc/postgresql/12/main/postgresql.conf && \
    echo "host  all  all 0.0.0.0/0 md5" >> /etc/postgresql/12/main/pg_hba.conf

# Configure postgresql
RUN service postgresql start && \
    sudo -u postgres psql -c "create user biome with encrypted password 'biome';" && \
    sudo -u postgres psql -c "create database biome;" && \
    sudo -u postgres psql -c "grant all privileges on database biome to biome;"

WORKDIR /app
USER biome

COPY --chown=biome . /app

CMD ["./run_all_docker_services.sh"]
