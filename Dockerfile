FROM alpine:3.13

RUN apk add --no-cache php8 \
    php8-common \
    php8-fpm \
    php8-pdo \
    php8-opcache \
    php8-zip \
    php8-phar \
    php8-cli \
    php8-curl \
    php8-bcmath \
    php8-openssl \
    php8-mbstring \
    php8-tokenizer \
    php8-fileinfo \
    php8-json \
    php8-xml \
    php8-pdo_sqlite \
    php8-dom \
    php8-xmlwriter \
    php8-simplexml \
    php8-pdo_mysql \
    php8-session

# copy all of the file in folder to /src
COPY . /src
WORKDIR /src