#!/bin/sh

# install bun
curl -fsSL https://bun.sh/install | bash
export BUN_INSTALL="$HOME/.bun"
export PATH="$BUN_INSTALL/bin:$PATH"

# build front-end
bun install
bun run build:ssr

# update database
php artisan migrate --force
php artisan config:cache
php artisan route:cache
