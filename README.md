YII 2 Demo news site
============================

Демо сайт новостей с категориями на yii2

Установка
------------

Клон

~~~
git clone git@github.com:andr-ik/yii2-demo-news-site.git
~~~

Миграции

~~~
yii migrate
yii migrate --migrationPath=@yii/rbac/migrations/
~~~

Фикстуры пользователей

~~~
yii fixture User --namespace='app\fixtures'
~~~

Фикстуры данных

~~~
yii data-load
~~~

Инициализация RBAC

~~~
yii rbac/init
~~~

...
...
...

Profit!