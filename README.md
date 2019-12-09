## Prérequis

##### Sur votre poste

 - Avoir [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/) (> 17.12.0) installé sur sa machine
 - Avoir [Docker Compose](https://docs.docker.com/compose/install/) (> 1.20.1) installé sur sa machine


## Installation
 - Copier le fichier .env : ```cp .env.dist.dev .env```
 - Build du container : ```docker-compose build```
 - Lancement du container :
     * Mode normal : ```docker-compose up```
     * Mode daemon : ```docker-compose up -d```

## URL
 - Site : [http://localhost:8037/](http://localhost:8037/)
 - Administation (soon) : [http://localhost:8037/admin/](http://localhost:8037/admin/)
 - PhpMyAdmin : [http://localhost:8038/](http://localhost:8038/)

### BDD
 - Dans le container web 
    - php bin/console make:migration
    - php bin/console doctrine:migrations:migrate