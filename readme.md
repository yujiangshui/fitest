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
<p>12. npm test</p>

<p>After all above steps have been done. You can login by username: admin, password: 12345678</p>
<p>Otherwise, you also can login by username: admin@qq.com, password: 12345678</p>

<p>I have deployed the project on AWS, the link is: http://13.210.14.131/fitest/public/index.php</p>

<p>The frontend I am using BootstrapVue, the official document link is https://bootstrap-vue.js.org/<p>