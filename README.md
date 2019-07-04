# Запуск проекта на Docker
1. выполнить из консоли `docker-compose up --build -d`
2. дождаться сборки контейнеров
3. `docker ps` узнать имя контейнера www. Допустим `dwcoder_www_1`
3. выполнить из консоли `docker exec -it dwcoder_www_1 /app/init-project.sh`


Логин администратора: admin

Пароль администратора: admin1

Доступ к публичному приложению: http://localhost:20080

Rest апи запрос доступен через: http://localhost:20080/index.php?r=api/videos/for-decode


DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
coder
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    web/                 contains the entry script and Web resources
www
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
