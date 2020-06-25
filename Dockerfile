FROM jdecode/kode:2.1

#COPY . /var/www/html

COPY php/ini/conf.d/memory_limit.ini /usr/local/etc/php/conf.d/memory_limit.ini

## Run following when a composer dependency is changed
#COPY composer.json /var/www/html/
#RUN composer install -n --prefer-dist

## Run following when npm dependency is changed
#COPY package.json /var/www/html/
#RUN npm install
RUN a2enmod rewrite
#change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

#change ownership of our applications
RUN chown -R www-data:www-data /var/www/html/tmp /var/www/html/logs

ARG BUILD
ENV BUILD=${BUILD}

## Disabled following when running locally (keep it enabled for GCP Cloud Run)
RUN if [ "$BUILD" = "local" ] ; then ls -al ; else sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf ; fi
