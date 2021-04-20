##RUN
run `composer update`

running on `php 7.2`

Data is saved in an `sql` database - configure db in - `/config/app_local.php`

`/webroot/budget.sql` contains a dump of the `db`

run app using `bin\cake server`

Ex -> Logic `/src/Controller/PagesController.php`
      View  `/template/Pages/home.php`