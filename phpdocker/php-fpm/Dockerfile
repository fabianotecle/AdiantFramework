FROM phpdockerio/php:8.0-fpm
WORKDIR "/public"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.0-cgi \ 
        php8.0-dba \ 
        php8.0-ds \ 
        php8.0-gd \ 
        php8.0-gmagick \ 
        php8.0-imap \ 
        php8.0-ldap \ 
        php8.0-mcrypt \ 
        php8.0-memcached \ 
        php8.0-mongodb \ 
        php8.0-mysql \ 
        php8.0-redis \ 
        php8.0-soap \ 
        php8.0-sqlite3 \ 
        php8.0-tidy \ 
        php8.0-xmlrpc \ 
        php8.0-xsl; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
