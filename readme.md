<p>1. clone the project to your local first.</p>
<p>2. composer install</p>
<p>3. cp .env.example .env</p>
<p>4. change the database name, mysql root name, mysql password the same as your local, if you need, please also change "APP_URL=https://fi.test" to your local website name.</p>
<p>5. php artisan key:generate</p>
<p>6. php artisan migrate</p>
<p>7. php artisan db:seed --class UserTableSeeder</p>
<p>8. php artisan db:seed --class TasksTableSeeder</p>
<p>9.  ./vendor/bin/phpunit</p>
<p>10. npm install</p>
<p>11. npm run dev</p>