FROM yiisoftware/yii2-php:7.2-apache

# Change document root for Apache
RUN sed -i -e 's|/app/web|/app/www/web|g' /etc/apache2/sites-available/000-default.conf

RUN apt-get update

RUN apt-get install -y cron
COPY docker/remind-video /etc/cron.d/remind-video
RUN touch /var/log/cron.log

RUN apt-get install -y supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/apache2.conf     /etc/supervisor/conf.d/apache2.conf
COPY docker/cron.conf        /etc/supervisor/conf.d/cron.conf

CMD ["/usr/bin/supervisord"]