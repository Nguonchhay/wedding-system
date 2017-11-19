# Wedding Management System

Wedding Management System is a web application which provides abilities to manage wedding.

## Maintainers
- Nguonchhay Touch : tnguonchhay@gmail.com

## System requirements

* [Docker](https://docs.docker.com/get-started/)

* Browser (Chrome, Firefox, Saferi,...)

## Local setup

Note: we are using docker for local development.

* Clone the website
```
git clone https://github.com/Nguonchhay/wedding-system.git your/desire/path/local.wedding.host
```

* Go to project
```
cd your/desire/path/local.wedding.host
```

* Download all dependencies
```
composer install
```

* Start and up docker
```
vendor/bin/dockerlaravel up -d
```

* Open `.env` and add these configuration
```
APP_ENV=local
APP_DEBUG=true
APP_TIMEZONE=Asia/Phnom_Penh
APP_URL=your-base-url

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=dockerlaravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

* Go to app container:
```
vendor/bin/dockerlaravel run app /bin/bash
```

* Generate the api key for website: `php artisan key:generate`.

* Migrate database schema and initialize some data
```
php artisan migrate --seed
```

* Execute some command (run these command on the root folder):
```
sudo chown -R ${USER}:${USER} .
php artisan cache:clear
php artisan config:clear
php artisan route:clear
composer dump-autoload
php artisan migrate --seed
```

* Compile resources
```
bower install
npm install
grunt build
```

* Add host to `/etc/hosts`

```
sudo vi /etc/hosts
0.0.0.0  local.wedding.host
```

__Note__: the above guide adding host is only for Linux and MAC.
If you are using Windows, please search Google for detail.

* Verify installation
```
Frontend: local.wedding.host:8080
```