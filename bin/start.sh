#!/usr/bin/env sh
set -eu

NGINX_INCLUDE_DIR="$(grep -Eo '/etc/nginx/(conf\.d|http\.d)' /etc/nginx/nginx.conf | head -n1 || true)"
if [ -z "$NGINX_INCLUDE_DIR" ]; then
  NGINX_INCLUDE_DIR="/etc/nginx/conf.d"
fi

mkdir -p "$NGINX_INCLUDE_DIR"
PORT_VALUE="${PORT:-8080}"
sed "s/\$PORT/${PORT_VALUE}/g" nginx.conf > "$NGINX_INCLUDE_DIR/default.conf"

PHP_FPM_BIN=""
if command -v php-fpm >/dev/null 2>&1; then
  PHP_FPM_BIN="php-fpm"
elif command -v php-fpm82 >/dev/null 2>&1; then
  PHP_FPM_BIN="php-fpm82"
else
  echo "php-fpm binary not found" >&2
  exit 1
fi

for conf in /etc/php82/php-fpm.d/www.conf /etc/php8/php-fpm.d/www.conf /etc/php-fpm.d/www.conf; do
  if [ -f "$conf" ]; then
    sed -i 's|^listen[[:space:]]*=.*|listen = 127.0.0.1:9000|' "$conf"
  fi
done

"$PHP_FPM_BIN" -D

PHP_BIN="php"
if ! command -v "$PHP_BIN" >/dev/null 2>&1 && command -v php82 >/dev/null 2>&1; then
  PHP_BIN="php82"
fi

i=0
while [ "$i" -lt 30 ]; do
  if "$PHP_BIN" -r '$s=@fsockopen("127.0.0.1",9000); if($s){fclose($s); exit(0);} exit(1);'; then
    break
  fi
  i=$((i + 1))
  sleep 1
done

nginx -t
exec nginx -g 'daemon off;'