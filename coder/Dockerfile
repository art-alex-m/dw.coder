FROM yiisoftware/yii2-php:7.2-apache
RUN sed -i -e 's|/app/web|/app/coder/web|g' /etc/apache2/sites-available/000-default.conf

RUN apt-get update
RUN apt-get install -y supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/load-queue.conf  /etc/supervisor/conf.d/load-queue.conf
COPY docker/coder-queue.conf /etc/supervisor/conf.d/coder-queue.conf
CMD ["/usr/bin/supervisord"]

RUN apt-get install -y ffmpeg
