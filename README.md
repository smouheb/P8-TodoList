ToDoList
========

ToDoList is a application that I have reviewed and slightly enhanced.
Once you will clone this project you will be able to add any modification you want.

# Technical environment:

 - Language =>  7.2.11
 - Framework => Symfony 3.4
 - Database => MySQL 5.7.24 
 - Web Server => PHP built in web server
 - Behat => 3.5.0

# Installation:

Choose the directory where you want this project to be saved.
or if you are using the command line, then go to the directory you want this project to be saved and copy paste the below:
git clone https://github.com/smouheb/TodoList.git

Once it is downloaded/saved, cd Todolist and then composer install.
you will be asked to:
- Add the database information (hostname, port, databasename, usernanme, password...)

When you are done use the following command to create a database (if not already existing):
    bin/console doctrine:database:create
    then bin/console doctrine:schema:create.

Start the web server (should you actually use the built in web server):
bin/console server:run

If you want to add additional tests running with behat, everything lives in the "features" folder.
Also, I have added fixtures so everytime you create change the source code you can use the existing tests as your regressioin tests.

Hope you'll enjoy it!
