#!/bin/bash

### Запустить из консоли хост машины после 1-ого запуска докер контейнеров
### docker exec -it dwcoder_www_1 /app/init-project.sh

/usr/local/bin/composer install -d /app
/app/init --env=Development --overwrite=All
/app/yii migrate/up --migrationPath=@yii/rbac/migrations --interactive=0
/app/yii rbac/init
/app/yii migrate/up --interactive=0