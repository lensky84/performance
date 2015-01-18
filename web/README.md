Повышение производительности сайта на Symfony2 с использованием Doctrine2 ORM
========================

Этот проект разработан как наглядное пособие к [статье][1].

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
    
На главной странице есть ссылки на все примеры использования приемов описаных в [статье][1].

[1]:http://stfalcon.com/blog/post/performance-symfony2-doctrine2-orm