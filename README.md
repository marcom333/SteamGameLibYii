REQUIREMENTS
------------

* APACHE
* MYSQL
* PHP 5.1 or newer
* [Composer](http://getcomposer.org/)

INSTALLATION
------------

### 1. Cloning the project

To install this project you need to clone this repository in the web root of APACHE. To clone this project you can use this command:

~~~
git clone https://github.com/marcom333/steamlib.git
~~~

### 2. Downloading dependencies

After cloning the project you need to download the denendency. To do this, you need to enter in the project folder and open the console or terminal. Then you need to run this command:

~~~
php composer install
~~~

### 3. configuring project

To configure this project you need to open the folder config. In this folder you need to create a new 
file with the name of params.php. This file need this code with the data of the user:

```php
return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    'steam_api'=>'STEAM_API_EXAMPLE12345123',
];
```
> **_WARNING:_**  You should create the database using utf8mb4_bin for collation because Steam accept 
    the use of EMOJI and that kind of characters will cause an error if use another collation.


After creating and editing the file params.php, you need to edit db.php. This file need the conection type,
URL, user and password. 

### 3. Create the schema

To create the database schema for this project you need to run this command:

~~~
php yii migrate
~~~

To redefine the schema of the data base you should use this command:

~~~
php yii migrate/fresh
~~~

### Screenshots

Filter your games with tags, category, genre and folders

![filter your games with tags, category, genre and folders](/readmeimg/lib001.jpg "screenshot")

You can search in your library

![Can search in your library](/readmeimg/lib002.jpg "screenshot")

You can create new accoun

![Can create new account](/readmeimg/newacc.jpg "screenshot")

And login

![you can login](/readmeimg/login.jpg "screenshot")

Game icon in web browser Tabs

![Game icon in Tabs](/readmeimg/tabicon.jpg "screenshot")

For Developers
-------------------

### Project Structure

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources


### TO DO
* * [x] Add folders to games
* * [x] Add folders to folders :u
* * [x] Remove folders to a game
* * [x] Make it online
    * * [x] Make game libraries
    * * [ ] sign in through steam
    * * [ ] login in through steam

### PENDING
* * [ ] Add tags to a game
* * [ ] Remove tags to a game
* * [ ] Hide unwanted tags
* * [ ] Add genres to a game
* * [ ] Remove genres to a game
* * [ ] Hide unwanted genres
* * [ ] Add categories to a game
* * [ ] Remove categories to a game
* * [ ] Hide unwanted categories