FROM php:7.2.4-apache

LABEL "com.uestudio.vendor"="uecluster_admin"
LABEL version="0.0.1"
LABEL description="docker for cluster uestudio admin"

# Install dependencies
RUN apt-get update -y
#RUN apt-get update && apt-get -y upgrade && DEBIAN_FRONTEND=noninteractive apt-get -y install \
#    apache2 php7.0 php7.0-mysql libapache2-mod-php7.0 curl lynx-cur php7.0-xml
RUN apt-get install -y git zip unzip
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add php.ini for production
#COPY config/php.ini $PHP_INI_DIR/php.ini
#COPY config/apache2.conf /etc/apache2/apache2.conf

# Install app
ADD . /var/www/html

WORKDIR /var/www/html

RUN composer install
#RUN php composer.phar install 

#RUN chmod -R 777 /var/www/html/var
#RUN chown www-data:www-data /var/www/html
#RUN chown -R www-data:www-data /var/www

RUN apache2 -v

#RUN mkdir /usr/src/php/ && mkdir /usr/src/php/ext
#RUN pecl install redis-3.1.1 \
#    && pecl install xdebug-2.5.0
#RUN docker-php-ext-enable redis

# Enable apache mods.
#RUN a2enmod php7.0
RUN a2enmod rewrite
RUN a2enmod deflate
RUN a2enmod headers
#RUN a2enmod ssl

#RUN php -i | grep "php.ini"

#COPY config/php/php.ini.dev /usr/local/etc/php/

#ADD certificates /home/certificates
#RUN  chmod -R 440 /home/certificates

# Update the PHP.ini file, enable <? ?> tags and quieten logging.
#RUN sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.0/apache2/php.ini
#RUN sed -i "s/error_reporting = .*$/error_reporting = E_ERROR | E_WARNING | E_PARSE/" /etc/php/7.0/apache2/php.ini

# Manually set up the apache environment variables
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV MODE dev
ENV UECLUSTER_DB_HOST SET_UECLUSTER_DB_HOST
ENV UECLUSTER_DB_PORT SET_UECLUSTER_DB_PORT
ENV UECLUSTER_DB_NAME SET_UECLUSTER_DB_NAME
ENV UECLUSTER_DB_USER SET_UECLUSTER_DB_USER
ENV UECLUSTER_DB_PASSWORD SET_UECLUSTER_DB_PASSWORD
ENV UECLUSTER_AZURE_ACCOUNT_NAME SET_UECLUSTER_AZURE_ACCOUNT_NAME
ENV UECLUSTER_AZURE_ACCOUNT_KEY SET_UECLUSTER_AZURE_ACCOUNT_KEY

# Update the default apache site with the config we created.
#ADD config/apache/apache-config.conf.dev /etc/apache2/sites-enabled/000-default.conf

RUN service apache2 restart

#RUN cd /var/www/html/
#RUN php composer.phar update

EXPOSE 80

# By default start up apache in the foreground, override with /bin/bash for interative.
CMD /usr/sbin/apache2ctl -D FOREGROUND
