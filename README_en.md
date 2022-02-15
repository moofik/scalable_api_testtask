### How to install ###
Run next actions in console from the root of the project:

1. Install latest docker version
2. Install latest docker-compose version
3. git clone git@gitlab.com:moofik12/masterhome.git 
4. Run from the root of the project: sh docker/install.sh (if you have permissions error, you can use sudo or grant permissions to docker)
5. Run command echo 127.0.0.1 testtask.local | sudo tee -a /etc/hosts

### How it works ###

To run develop environment run command: sh docker/stack.sh

API:

1. GET http://testtask.local/api/visits
2. POST http://testtask.local/api/visits
   1. PARAMETERS (you can pass params as JSON, and also as Form Url Encoded)
   <br/>
   code - country code

You can scale with docker swarm, for example:
docker service scale testtask_fpm=4