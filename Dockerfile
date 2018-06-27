FROM  daocloud.io/1514582970/pms_docker_php:cli71_swoole_phalcon

MAINTAINER      Dongasai "1514582970@qq.com"

RUN apt update;apt install -y vim
COPY . /var/www/html/
ENV APP_SECRET_KEY="123456"

ENV REGISTER_SECRET_KEY="123456"
ENV REGISTER_ADDRESS="123456"
ENV REGISTER_PORT=9502

ENV GCACHE_HOST="192.168.1.1"
ENV GCACHE_PORT="6379"
ENV GCACHE_AUTH=0
ENV GCACHE_PERSISTENT=""
ENV GCACHE_PREFIX="email"
ENV GCACHE_INDEX="1"

ENV MYSQL_HOST="192.168.1.1"
ENV MYSQL_PORT="3306"
ENV MYSQL_DBNAME="email"
ENV MYSQL_PASSWORD="123456"
ENV MYSQL_USERNAME="email"

ENV ALIYUN_DM_ACCESSKEY=1223
ENV ALIYUN_DM_ACCESSSECRET=111
ENV ALIYUN_DM_ACCOUNTNAME=111
ENV ALIYUN_DM_TAGNAME=111

EXPOSE 9502
WORKDIR /var/www/html/
RUN composer install
CMD php start/start.php

