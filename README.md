Повышение производительности сайта на Symfony 2 с использованием Doctrine 2 ORM
========================

Этот проект разработан как наглядное пособие к статье.

### Установка

1) Склонируйте проект

    git clone git@github.com:lensky84/performance.git

2) Установка вендоров

В корень проекта нужно скачать Composer

    curl -s http://getcomposer.org/installer | php

Затем запустить установку вендоров

    php composer.phar install

3) Создать базу данных

    ./console doctrine:database:create

4) Исполнить миграции

    ./console doctrine:migrations:migrate

5) Накатить фикстуры

    ./console doctrine:fixtures:load

После этого результаты можно посмотреть на следующих страницах:

    /app_dev.php/list-posts

    /app_dev.php/list-posts-optimized

    /app_dev.php/update-posts

    /app_dev.php/update-posts-optimized
