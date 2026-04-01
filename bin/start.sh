#!/usr/bin/env sh
set -eu

NGINX_INCLUDE_DIR="$(grep -Eo '/etc/nginx/(conf\.d|http\.d)' /etc/nginx/nginx.conf | head -n1 || true)"
if [ -z "$NGINX_INCLUDE_DIR" ]; then
  NGINX_INCLUDE_DIR="/etc/nginx/conf.d"
fi

mkdir -p "$NGINX_INCLUDE_DIR"
PORT_VALUE="${PORT:-8080}"
sed "s/\$PORT/${PORT_VALUE}/g" nginx.conf > "$NGINX_INCLUDE_DIR/default.conf"

php-fpm &
exec nginx -g 'daemon off;'