#!/usr/bin/with-contenv bash
if [ -z "$PUID" ]
  then
  USER="nobody"
  USERID=65534
else
  USER="docker"
  USERID=${PUID}
fi

if [ -z "$PGID" ]
  then
  GROUP="nobody"
  GROUPID=65534
else
  GROUP="docker"
  GROUPID=${PGID}
fi

if [ "$USER" != "nobody" ] ; then
  addgroup -g ${GROUPID} ${GROUP}
  adduser -D -G "$GROUP" -H -u "$USERID" "$USER"
fi

chown -R $PUID.$PGID /var/www/html /run /var/lib/nginx /var/log/nginx /home/npm /home/composer

/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
