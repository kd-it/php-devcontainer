# composerから取り込むものがあるので仕込み
FROM composer/composer:2-bin AS composer

# uvも導入
FROM ghcr.io/astral-sh/uv:alpine AS uv

# ---  ベースイメージの作成
FROM php:fpm-alpine
ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# composerの移植
COPY --from=composer /composer /usr/bin/composer

# uvの移植
COPY --from=uv /usr/local/bin/uv /usr/local/bin/uvx /usr/local/bin/

# 必須と思われるPHP拡張の導入
RUN apk add --no-cache \
    git \
    zip \
    unzip && \
    rm -fr /var/cache/apk
# Pythonの導入
RUN apk add --no-cache \
    python3 \
    py3-pip && \
    rm -fr /var/cache/apk
RUN apk add --no-cache \
    github-cli \
    make \
    sudo && \
    rm -fr /var/cache/apk
RUN apk add --no-cache \
    npm && \
    rm -fr /var/cache/apk
# RUN pecl install xdebug \
#     && docker-php-ext-enable xdebug
RUN docker-php-ext-install mysqli pdo_mysql
# やはりbashは最低限必要ですね
RUN apk add --no-cache \
    bash \
    bash-completion && \
    rm -fr /var/cache/apk
# 作業用ユーザーの作成、シェルは/bin/sh
RUN addgroup -g $USER_GID $USERNAME \
    && adduser -u $USER_UID -G $USERNAME -s /bin/bash -D $USERNAME
# $USERNAMEにはsudo権限を付与
RUN echo "$USERNAME ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/$USERNAME
# composerとlaravelのラッパーをインストール
COPY composer /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer
COPY laravel /usr/local/bin/laravel
RUN chmod 755 /usr/local/bin/laravel


# シェル補完用の設定を追加
WORKDIR /usr/share/bash-completion/completions
RUN /usr/bin/composer completion bash > composer

# hadolint ignore=DL3059
WORKDIR /app
RUN chown -R "${USERNAME}:${USERNAME}" /app

USER ${USERNAME}
ENV PATH="${PATH}:/home/${USERNAME}/.composer/vendor/bin:/home/${USERNAME}/.local/bin"
#RUN composer global require "laravel/installer"

