#!/usr/bin/env bash
# Deploy/update GP Transmission on Namecheap cPanel shared hosting.
# Run on the server over SSH, from the app folder:
#   cd ~/gp-transmission && bash deploy.sh
#
# Compiled front-end assets (public/build) are committed to git by CI,
# so Node/npm is NOT needed on the server.
set -euo pipefail

cd "$(dirname "$0")"

# Use PHP 8.3 CLI explicitly (the plain `php` on CloudLinux can be older
# than the version picked in cPanel > Select PHP Version). Override with
# PHP=/path/to/php bash deploy.sh if needed.
PHP="${PHP:-/opt/alt/php83/usr/bin/php}"
[ -x "$PHP" ] || PHP="$(command -v php)"
COMPOSER_PHAR="${COMPOSER_PHAR:-$HOME/composer.phar}"
if [ ! -f "$COMPOSER_PHAR" ]; then
  echo "Downloading composer.phar to $COMPOSER_PHAR"
  curl -sS -o "$COMPOSER_PHAR" https://getcomposer.org/download/latest-stable/composer.phar
fi

echo "Using PHP: $("$PHP" -r 'echo PHP_VERSION;')"

if [ ! -f .env ]; then
  echo "ERROR: .env is missing. Copy .env.production.example to .env and fill it in first." >&2
  exit 1
fi

"$PHP" artisan down --retry=30 || true
trap '"$PHP" artisan up' EXIT

git pull --ff-only

"$PHP" "$COMPOSER_PHAR" install --no-dev --optimize-autoloader --no-interaction --prefer-dist

if ! grep -q '^APP_KEY=base64:' .env; then
  "$PHP" artisan key:generate --force
fi

"$PHP" artisan migrate --force

"$PHP" artisan config:cache
"$PHP" artisan route:cache
"$PHP" artisan view:cache

echo "Deploy complete."
