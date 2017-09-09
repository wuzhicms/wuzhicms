FROM xutongle/php:7.1-nginx

MAINTAINER XUTL <xutl@gmail.com>


COPY . /app/
WORKDIR /app

RUN rm -rf /etc/nginx/conf.d/default.conf \
    && chmod 700 docker-files/run.sh init

VOLUME ["/app/www/uploadfile"]

EXPOSE 80

CMD ["docker-files/run.sh"]