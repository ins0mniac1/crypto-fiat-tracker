<p>
    <h1>Crypto currency/Fiat money pairs tracker</h1>
</p>


## Installation

1. After You clone the repository, You should run the following commands
```bash
$ composer install
```
```bash
$ npm install && npm run dev
```

2. Create new .env file from .env.example, populate your own database credentials and create and seed database in new terminal window:
```bash
$ php artisan migrate
```
```bash
$ php artisan db:seed
```

3. Start project and run short scheduler
```bash
$ php artisan serve
```
```bash
$ php artisan short-schedule:run
```

4. Add Your mailer credentials in .env file (or just set MAIL_USERNAME and MAIL_PASSWORD for Your mailtrap.io account)

5. Run localhost:8000 in Your browser.

## Basic usage

When application is started, it will make calls to Bitfinex driver on every 30 seconds. If You want to change the execution time, You should update app/config/trackable_drivers.php file.

You can subscribe for notification simply by filling and submitting the form.
