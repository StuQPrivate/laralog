FROM eboraas/laravel
MAINTAINER  Hills Dong <hills@stuq.org>

# 部署源码
COPY ./ /var/www/laravel/
WORKDIR /var/www/laravel/

RUN chmod -R 777 ./storage
RUN chmod -R 777 ./bootstrap/cache

RUN composer config -g repo.packagist composer https://packagist.phpcomposer.com
RUN composer install
RUN composer require arcanedev/log-viewer
RUN composer dump-autoload --optimize

RUN cp ./config/app.php.example ./config/app.php
RUN cp ./config/log-viewer.php.example ./config/log-viewer.php

RUN php artisan log-viewer:publish

EXPOSE 80
EXPOSE 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
