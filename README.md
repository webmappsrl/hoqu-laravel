<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://webmapp.it/wp-content/uploads/2016/07/webamapp-logo-1.png" width="400"></a></p>

## HOQU
HOQU was born as a bridge between Instances and Servers to improve and increase the generation performance on Webmapp maps 


### Server Requirements 
- composer version : 1.10.17
- php: 7.4.12
- MySQL: >= 8.0.0
- Laravel Version: >= 8.x

### Local Installation
After doing ``` git pull``` and entering the newly downloaded project  ```cd hoqu-laravel```. Now configure mysql by creating a new DB:

#### configure db MySQL:
- if MySQL is not installed: **[Guide](https://flaviocopes.com/mysql-how-to-install)**
- open MySQL: ```mysql.server start```
- enter MySQL if it does not have the password set: ```mysql -u <username>``` otherwise ```mysql -u <username> -p```
- create db: ```CREATE DATABASE <mydatabasename>;```

#### configure .ENV in project hoqu-laravel :
set the connection to the Laravel db, open the .ENV file with ide (VS code, sublime, etc) and modify the following items as follows:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<mydatabasename>
DB_USERNAME=<username>
DB_PASSWORD=<password>
```

Enable or disable registration at the link **[register](http://hoqu-laravel.test/register)**:
- to disable the link **[register](http://hoqu-laravel.test/register)** ```DISABLE_REGISTRATION=false``` in the .ENV,  file then launch the command ```php artisan config:cache``` to enable changes
- to enable the link **[register](http://hoqu-laravel.test/register)** ```DISABLE_REGISTRATION=true``` in the .ENV,  file then launch the command ```php artisan config:cache``` to enable changes

As a last step you have to configure the mail always from .ENV file:
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=465
MAIL_USERNAME=<setMail>
MAIL_PASSWORD=<setPassword>
MAIL_ENCRYPTION=ssl
MAIL_MAILER=smtp
```

## Run HOQU

After configuring the .ENV file we can run configure and populate our DB with the following command:
- ```php artisan migrate --seed``` 
- otherwise to empty the DB and load the data again ```php artisan migrate:fresh --seed```

now possible to start hoqu by running the command: ```php artisan serve```,otherwise it is possible to use [Valet](https://opensource.org/licenses/MIT)

### Test 
to perform these operations you must be in the hoqu-laravel project folder:

### test e2e with Cypress 
Cypress version supported for testing> = 5.6.0
if you don't have cypress installed, you can do it with the following command:
```
npm install cypress --save-dev
```
if already available or just installed lunch cypress:

```
npx cypress open
```
select the test or tests to run

to be able to view the test code just go hoqu-laravel/cypress/integration

### test Feature with Phpunit 
Phpunit is natively supported by Laravel
to launch all Feature Tests
```
vendor/bin/phpunit
```
launch the single test or single method:
```
vendor/bin/phpunit --filter <nomeTest>
```
alternatively it is possible to launch the tests also from Laravel
```
php artisan test
```
to be able to view the test code just go hoqu-laravel/tests/

## Authors

 - Alessio Piccioli - CTO - [Webmapp](https://github.com/piccioli).
 - Gianmarco Gagliardi - Developer - [Webmapp](https://github.com/gianmarxWebmapp).

## License

This project is licensed under the MIT License - [MIT license](https://opensource.org/licenses/MIT).
