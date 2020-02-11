FROM php:7-fpm

RUN mkdir -p /opt/app

RUN apt-get update && apt-get install -y git ca-certificates unzip && rm -rf /var/lib/apt/lists/*

WORKDIR /opt/app

COPY . /opt/app/

ADD https://getcomposer.org/installer /opt/app/

RUN php /opt/app/installer && php composer.phar install

EXPOSE 8000

CMD ["php", "bin/console", "server:run", "0.0.0.0"]