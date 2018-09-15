# Local WordPress Development Kit
[**By SkyPress**](https://skypress.io)

_Please feel free to fork or clone this development kit to get started developing your own WordPress website_

## Prerequisites
In order to use the **WP Dev Kit**, you will need the following installed on your local machine:

* [Docker](https://docs.docker.com/install/)
* [Docker Compose](https://docs.docker.com/compose/install/)
* [Docker Network](https://docs.docker.com/engine/reference/commandline/network/)
* [jwilder/nginx-proxy](https://github.com/jwilder/nginx-proxy)

#### Docker Network
Before we begin, we will need to define an external network to connect our **Local WP Site** to the **Nginx Proxy**. This command only needs to be executed once, unless at some point the network is removed. If this ever happens, just run this command again.

```
docker network create nginxproxy
```

The default _NETWORK NAME_ for this kit is `nginxproxy`. If you decide to use a different name, then you will need to update the standard `docker-compose.yml` file:

```
networks:
  default:
    external:
      name: nginxproxy
```

#### NGINX Proxy
Using the `jwilder/nginx-proxy` docker image allows for the usage of a custom domain name for your local development site. Use the following example to get a simple NGINX Proxy service up and running. This command should only need to be ran once due to the `--restart=unless-stopped` policy. However, you can always check to ensure that this container is running by running `docker ps` and finding the proper `jwilder/nginx-proxy` Image name.

```
docker run -d -p 80:80 --network=nginxproxy --restart=unless-stopped -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy
```

_You can also create an alias in either your_ `~/.bash_profile` _or_ `~/.bashrc` _to quickly reference this command again_

```
alias nginx-proxy=docker run -d -p 80:80 --network=nginxproxy --restart=unless-stopped -v /var/run/docker.sock:/tmp/docker.sock:ro jwilder/nginx-proxy
```

## Quick Start
```
make up
```
Wait for the WordPress files to populate, then:
```
make clean
```
Then visit [http://wp-dev.local/](http://wp-dev.local) to start the famous 5 minute install.

## Docker Compose
Provided is a standard `docker-compose.yml` file that includes the proper configuration and docker images for running **WordPress**, **MySQL**, and **PHPMyAdmin**. In general, the only thing that should be edited in this file is the `VIRTUAL_HOST` environment variable for **WordPress** and **PHPMyAdmin**. This variable is read by the NGINX Proxy and allows for `http` access to these containers.

```
wordpress:
    image: wordpress:latest
    links:
        - mysqldb:mysql
    volumes:
        - ./:/var/www/html/
    expose:
      - "80"
    environment:
        WORDPRESS_DB_USER: wordpress
        WORDPRESS_DB_PASSWORD: wordpress
        VIRTUAL_HOST: wp-dev.local
```

```
phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    links:
        - mysqldb:mysql
    expose:
      - "80"
    environment:
        PMA_HOST: mysql
        VIRTUAL_HOST: pma.wp-dev.local
```

It is recommend that you give each of your projects a unique `VIRTUAL_HOST` value in order to avoid naming collisions when working with multiple projects on the same machine.

_Additionally, you will need to update your_ `/etc/hosts` _file to reflect the values set for each_ `VIRTUAL_HOST`

```
127.0.0.1 wp-dev.local
127.0.0.1 pma.wp-dev.local
```

## Makefile
In order to provide a clean-ish CLI experience, the **WP Dev Kit** includes a `Makefile` with common commands used to manage `docker`, `composer`, and other relative items. The commands make use of various docker images where possible in order to prevent the need for these tools to be installed on your local machine. For example, `make lint` uses the `wpengine/php` docker image. `make install` and `make update` use a special `skypress/wp-composer` image. _Bonus points, this image also includes_ `phpunit`. Using the `Makefile` is as easy as:

```
make <command>
```

The most useful commands are:

* **lint** - _Lint PHP files found in_ `wp-content/plugins` _and_ `wp-content/themes`
* **clean** - _Remove many themes and plugins included with a vanilla WordPress install_
* **file-perms** - _Sets all permissions of all directories and files in this project to 775 and 664_
* **install** - _Runs_ `composer install -o && file-perms`
* **update** - _Runs_ `composer update -o`
* **start** - _Runs_ `docker-compose start` _to start the containers from a previously suspended state_
* **stop** - _Runs_ `docker-compose stop` _to suspend the containers_
* **restart** - _Runs_ `docker-compose stop && docker-compose start` _to restart the containers_
* **up** - _Runs_ `docker-compose up -d` _to create a fresh instance of the containers_
* **down** - _Runs_ `docker-compose down` _to power down the containers_
* **refresh** - _Runs_ `docker-compose down && docker-compose up -d` _to fully refresh the containers_

_Note:_ `make refresh` _will not destroy the mounted volumes (database) and is safe to use without loosing data. However, it will re-install a vanilla version of WordPress; plugins, themes, and all._

There are **Three** variables exposed in the `Makefile`: `PHP_IMAGE`, `PHP_VERSION`, and `COMPOSER_IMAGE`. Generally, you won't need to adjust these. But, for example if you would like to `lint` your project against a different version of PHP, you can alter these variables:

```
make lint PHP_VERSION=5.6
```

## TODO

- [] Deployment options
- [] Include `NPM` and/or `Yarn`
- [] Wrap everything up in it's own docker image?
- [] Write a `golang` CLI program?
- [] Take over the moon?
