# Первый запуск

## База данных, и данные по умолчанию
Схема базы лежит в каталоге `data/db/schema.sql` наименование базы **`taskforce`**.

Файл соджержит строки колторые удаляют все данные в базе и саму базу с именем **`taskforce`**.

Выполнить команды или импортировать данные вручную:
- `php import.php` - Генерация из CSV файлов
- `sudo mysql < data/db/schema.sql` - Загрузить схему
- `sudo mysql < data/sql/categories.sql` - Загрузка списка Категорий 
- `sudo mysql < data/sql/cities.sql` - Загрузка списка Городов

### или одной строкой

```bash
php import.php &&
sudo mysql < data/db/schema.sql &&
sudo mysql < data/sql/categories.sql &&
sudo mysql < data/sql/cities.sql
```

## Тестовые данные

```php
php yii fixture/generate user_profile --count=100 --interactive=0 &&
php yii fixture/generate users --count=100 --interactive=0 &&
php yii fixture/load Users --interactive=0 &&
php yii fixture/generate tasks --count=200 --interactive=0 && 
php yii fixture/load Tasks --interactive=0 &&
php yii fixture/generate user_categories --count=35 --interactive=0 &&
php yii fixture/load UserCategories --interactive=0 &&
php yii fixture/generate user_reviews --count=50 --interactive=0 &&
php yii fixture/load UserReviews --interactive=0
```
<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.com/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.com/yiisoft/yii2-app-advanced)

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
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
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
