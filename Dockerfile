FROM tangramor/nginx-php8-fpm

WORKDIR /var/www/html

COPY . /var/www/html
COPY conf/nginx-site.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
EXPOSE 443

RUN composer update --no-dev
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 770 storage/

CMD ["/usr/bin/supervisord"]