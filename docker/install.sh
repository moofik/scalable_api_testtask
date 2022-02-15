#!/usr/bin/env bash
. $(dirname $0)/script/functions.sh

SCRIPT_DIR=$(readlink -e $(dirname $0))
CONTAINER_NAME=$(docker ps | grep fpm | grep -o "^\w*\b")

docker-compose -f ${SCRIPT_DIR}/develop_stack.yml build
docker network create --scope=swarm testtask_swarm
docker stack deploy -c ${SCRIPT_DIR}/develop_stack.yml testtask
docker exec -it ${CONTAINER_NAME} bash -c "cd /testtask/backend && composer install"
docker exec -it ${CONTAINER_NAME} bash -c "cd /testtask/backend && cp .env.dist .env"

