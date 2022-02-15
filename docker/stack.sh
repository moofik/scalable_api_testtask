#!/usr/bin/env bash

SCRIPT_DIR=$(readlink -e $(dirname $0))

. $(dirname $0)/script/functions.sh

docker stack deploy -c ${SCRIPT_DIR}/develop_stack.yml testtask