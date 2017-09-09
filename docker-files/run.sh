#!/bin/bash

set -e -x 

cd /app
php init --env=${APP_ENV:-Production} --overwrite=y
php yii migrate --interactive=0
cp nginx.conf /etc/nginx/conf.d/

function setEnvironmentVariable() {
    if [ -z "$2" ]; then
            echo "Environment variable '$1' not set."
            return
    fi
    echo "env[$1] = \"$2\" ; automatically add env" >> /usr/local/etc/php/pool.d/www.conf
}

sed -i '/automatically add env/d' /usr/local/etc/php/pool.d/www.conf

# Grep all ENV variables
for _curVar in `env | awk -F = '{print $1}'`;do
    # awk has split them by the equals sign
    # Pass the name and value to our function
    setEnvironmentVariable ${_curVar} ${!_curVar}
done

echo -e "\033[32mStarting php and nginx......\033[0m"

supervisord -n
# service supervisord start
