#!/bin/sh

# 后台启动
php-fpm -D
# 关闭后台启动，hold住进程
nginx -g 'daemon off;'

# 下载依赖包
composer install

# 创建.env文件
cp -a .env.example .env
