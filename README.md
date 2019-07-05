## Запуск проекта на Docker
1. выполнить из консоли `docker-compose up --build -d`
2. дождаться сборки контейнеров
3. `docker ps` узнать имя контейнера www. Допустим `dwcoder_www_1`
4. выполнить из консоли `docker exec -it dwcoder_www_1 /app/init-project.sh`
5. перейти по ссылке http://localhost:20080 и ввести учетные данные администратора

## Пояснения
Логин администратора: **admin**

Пароль администратора: **admin1**

Доступ к публичному приложению: http://localhost:20080

Rest апи запрос доступен через: http://localhost:20080/index.php?r=api/videos/for-decode

Файлы пользователя загружаются в директорию `www/web/upload`

Файлы для перекодирования загружаются в директорию `coder/web/upload`. Опрос публичного сервиса 
происходит раз в 30 секунд, если очередь успевает очиститься и раз в 120 секунд если очередь при 
обращении имела задания

Перекодированные файлы храняться в директории `coder/web/decoded`. Очереди запускаются c 
использованием supervisor. Настройки процессов и запуска храняться в директории coder/docker

Отправка письма происходит через крон. Крон запускается в контейнере `www`, настройка задания 
храниться в файле www/docker/remind-video. При изменении параметров следует пресобрать контейнер

DIRECTORY STRUCTURE
-------------------

```
common
    components/          общие вспомогательные классы проекта
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend  
console
    components/          общие вспомогательные классы проекта
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
coder
    components/          общие вспомогательные классы проекта
    config/              contains backend configurations
    controllers/         contains Web controller classes
    docker/              содержит настройки системного запуска: очередей, апач, крон
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    web/                 contains the entry script and Web resources
www
    assets/              contains application assets such as JavaScript and CSS
    components/          общие вспомогательные классы проекта
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    docker/              содержит настройки системного запуска: апач, крон
    models/              contains frontend-specific model classes
    modules/             содержит модули приложения: панель администратора (admin), 
                         личный кабинет (user), api
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
