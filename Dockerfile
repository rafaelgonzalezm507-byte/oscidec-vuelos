FROM php:8.3-apache

# Extensión curl (para hablar con la API de Travelpayouts)
RUN apt-get update \
    && apt-get install -y --no-install-recommends libcurl4-openssl-dev \
    && docker-php-ext-install curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# El sitio se sirve desde /public (nunca se exponen src/ ni logs/)
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

COPY . /var/www/html

# La carpeta de logs debe ser escribible por Apache
RUN chown -R www-data:www-data /var/www/html/logs

EXPOSE 80
