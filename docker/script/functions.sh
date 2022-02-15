#!/usr/bin/env bash

DIR=$(readlink -e $(dirname $0))
SUDO_CMD=$(test -w /var/run/docker.sock || echo sudo)
PROJECT_DIR="/testtask"
COMPOSER_HOME=${COMPOSER_HOME:-${DIR}/volumes/composer}
