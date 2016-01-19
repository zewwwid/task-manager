task-manager
============

Back-end простой системы ведения клиента и управления задачами реализованный на Symfony 2.

Модель предметной области
-------------------------
Предметная область состоит из 4х сущностей.

Сущности | Entities
-------------------------------------| ---------------------------------------
Клиент (ФИО, Email, Телефон, Статус) | client (fullname, email, phone, status)
Администратор (ФИО)                  | administrator (fullname)
Задача (Название, Текст, Статус)     | task (name, text, status)
Документ (Название)                  | document (filename)

### Связи
* У задачи есть ответственный (из списка администраторов)
* К задаче могут быть прикреплены документы.
* Документ может быть прикреплен к задаче.
* Документ может быть прикреплен к клиенту.
* Для каждого документа отображается, кто из администраторов его загрузил.
* К клиенту может быть прикреплены документы.

### Диаграмма классов
![](https://raw.githubusercontent.com/zewwwid/task-manager/master/resources/task-manager-model.png)

Описание базы данных
--------------------

### Схема
![](https://raw.githubusercontent.com/zewwwid/task-manager/master/resources/task-manager-scheme.png)

### Таблицы
База данных состоит из пяти таблиц. Четыре из них (clients, administrators, tasks, documents) соответствуют сущностям модели. Пятая таблица migration_versions хранит номер версии текущей миграции.

### Ключи
В таблицах clients, administrators, tasks, documents в качестве первичного ключа выступает целочисленное поле id.
В таблице migration_versions первичным ключом является единственное строковое поле version.
Таблица documents имеет 3 внешних ключа task, client, administrator.
Таблица tasks имеет внешний ключ responsible (ссылка на ответственного администратора).
Все свойства ограничений внешних ключей в базе данных имеют тип RESTRICT.

### Индексы
Все таблицы имеют PRIMARY индекс по первичному ключу (id) и INDEX по внешним ключам. Индексы по остальным полям необходимо описать подробней.

##### Таблица administrators
Поля таблицы: **id**, fullname

Данная таблица будет содержать небольшое количество записей. Записи в этой таблице будут изменяться и добавляться редко. Чаще всего таблица будет использоваться для выборки данных. Исходя из этого был добавлен индекс по полю fullname который должен ускорить выборку администраторов по ФИО. Но здесь необходимо смотреть на реальных данных. Если окажется что количество записей в данной таблице совсем мало, то в таком случае индекс по fullname может только замедлить работу.

##### Таблица clients
Поля таблицы: **id**, fullname, email, phone, status

Данная таблица скорее всего будет содержать больше записей, чем таблица administrators. Записи в этой таблице будут изменяться и добавляться редко. Чаще всего таблица будет использоваться для выборки данных. Исходя из этого для ускорения поиска добавлены индексы по всем полям fullname, email, phone, status. Индекс по полю email уникальный. При реализации полноценной системы возможно потребуются селекты сразу по нескольким полям соединенных в запросе через AND, тогда необходимо будет добавить составные индексы.

##### Таблица tasks
Поля таблицы: **id**, name, text, ststus, _responsible_

Данная таблица будет содержать большое число записей. Данные будут часто добавляться и обновляться. Названия задач врядли будут уникальными. Выборки по этой таблице из общей совокупности будут редкими (если вообще будут). Исходя из этого, для того чтобы не замедлять добавление и обновление записей в этой таблице оставим индексы только по ключевым полям.

##### Таблица documents
Поля таблицы: **id**, filename, _task_, _client_, _administrator_

Ситуация с этой таблицей, аналогична ситуации с таблицей tasks. Записи будут чаще всего добавлять и удаляться. Данные в поле filename будут далеко не уникальными, да и поиск по этому полю среди всех документов системы навряд ли будет производиться. Исходя из этого, для того чтобы не замедлять добавление записей в этой таблице оставим индексы только по ключевым полям.

### Миграция
Для создания структуры БД и заполнения демо-данными используется DoctrineMigrationsBundle и DoctrineFixturesBundle.

Установка
---------

Клонируем репозиторий в подходящий каталог
```
$ cd /var/www
$ git clone https://github.com/zewwwid/task-manager.git
```
Создаем пустую базу данных и пользователя для нее
```
$ mysql -u root -p
> CREATE DATABASE task_manager CHARACTER SET utf8 COLLATE utf8_general_ci;
> GRANT ALL PRIVILEGES ON task_manager.* TO task_manager@localhost IDENTIFIED BY 'password';
> quit;
```
Если не установлен composer то устанавливаем его, иначе пропускаем этот шаг
```
$ curl -sS https://getcomposer.org/installer | php
$ sudo mv composer.phar /usr/local/bin/composer
```
Устанавливаем необходимые вендоры. Во время установки вводим данные для подключения к базе данных.
```
$ cd task-manager
$ composer install
```
Настраиваем права доступа на кэш, лог и каталог загрузок. Вместо <whoami> необходимо вставить логин текущего пользователя.
```
$ sudo setfacl -R -m u:www-data:rwX -m u:<whoami>:rwX app/cache app/logs web/uploads
$ sudo setfacl -dR -m u:www-data:rwX -m u:<whoami>:rwX app/cache app/logs web/uploads
```
Загружаем структуру базы данных
```
$ php app/console doctrine:migrations:migrate
```
Загружаем в базу демо-данные
```
$ php app/console doctrine:fixtures:load
```
Настраиваем виртуальный хост для apache
```
$ cd /etc/apache2/sites-available/
$ nano task-manager.localhost.conf
```
Пишем в конфигурационный файл следующее
```
<VirtualHost *:80>
        ServerName task-manager.localhost
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/task-manager
        <Directory /var/www/task-manager
                AllowOverride All
        </Directory>
        ErrorLog ${APACHE_LOG_DIR}error.log
        CustomLog ${APACHE_LOG_DIR}access.log combined
</VirtualHost>
```
Включаем виртуальный хост и перезагружаем apache
```
$ a2ensite task-manager.localhost
$ service apache2 reload
```
Дописываем в файл /etc/hosts следующую строчку
```
127.0.0.1   task-manager.localhost
```
Установка завершена. Теперь доступ к документации на API и песочнице можно получить по адресу http://task-manager.localhost/api/doc

Demo
----
Демо версия развернута здесь: http://task-manager.zewwwid.com/api/doc
