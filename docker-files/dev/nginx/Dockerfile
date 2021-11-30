FROM nginx:1.19
ADD ./default.conf /etc/nginx/conf.d/default.conf
COPY ./docker-entrypoint.sh /docker-entrypoint.d/100-docker-entrypoint.sh
WORKDIR /app