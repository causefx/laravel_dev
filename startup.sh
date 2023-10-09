#!/bin/sh
echo 'Starting up script...'
echo '[---------- Checking for Domain ----------]'
if [ -z "$DOMAIN" ]
  then
   echo 'No domain found, using dev.local'
   DOMAIN="dev.local"
else
  echo "Domain found: $DOMAIN "
fi

sed -i "s|domain.tld|${DOMAIN}|g" /etc/nginx/conf.d/dev-local.conf

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
