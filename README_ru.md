### Как установить окружение ###
Из корня проекта делаем следующие действия:

1. Нужно установить свежий docker
2. Нужно установить свежий docker-compose
3. git clone git@github.com:moofik/scalable_api_testtask.git
4. Запускаем из корня проекта комманду sh docker/install.sh (если будет ругаться, то через sudo, либо выдать нужные права докеру)
5. Выполняем в консоли echo 127.0.0.1 testtask.local | sudo tee -a /etc/hosts

### Как работать ###

В дальнейшем для запуска окружения разработки нужно из корня запускать комманду sh docker/stack.sh

API:

1. GET http://testtask.local/api/visits
2. POST http://testtask.local/api/visits
   1. PARAMETERS (можно передавать, как в JSON, так и в Form Url Encoded)
   <br/>
   code - код страны

Для масштабирования возможно использование скейлинга docker swarm, например:
docker service scale testtask_fpm=4