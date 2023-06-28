<div style="font-family: Ubuntu; font-size: 14px; font-weight: 500;">

## Dependency

This App depends on the following services

- MySql
- Redis
- SMTP Mail server

## How to run

- Clone the repo
- Go to the app root dir
- Rename the .env.example to .env & configure


- If you have docker installed
  - go inside __docker__ folder from root dir of the app
  - run `docker compose build`
  - run `docker compose up`


- Else
  - create a database in MySql with the name: `xm_db` 
  - install npm packages & build
    - run `npm install && npm run build`
  - install php packages
    - run `composer install`
  - run Migrations
    - run `php artisan migrate`
  - start the email notification queue
    - run `php artisan queue:work &`
  - serve the application
    - run `php artisan serve`
    

- Go to `localhost:8000`


## Environment Variables

The following environment variables can be configured

```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql8
DB_PORT=3306
DB_DATABASE=xm_db
DB_USERNAME=
DB_PASSWORD=

QUEUE_CONNECTION=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_DRIVER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS="xm@test.com"
MAIL_FROM_NAME="${APP_NAME}"

EMPTY_ARRAY_OVER_EXCEPTION_FOR_SYMBOL_API=false
EMPTY_ARRAY_OVER_EXCEPTION_FOR_HISTORY_API=false

RAPID_API_KEY=
RAPID_API_HOST=yh-finance.p.rapidapi.com
RAPID_API_URL=https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data

SYMBOL_LIST_API_URL=https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json
```


## Features

This app has the following features satisfying the given requirements

Mandatory Requirements 

- A form to input following data when visiting `localhost:8000`
```php
    $formData = [
        'symbol' => 'GOOG',
        'email' => 'abc@test.email',
        'start_date' => '2023-6-11',
        'end_date' => '2023-6-21',
    ];
```
- _Symbol_ validation
- _Datepicker_ is used for date input
- Both _frontend_ & _backend_ _validations_ are available
- Upon successful form submission
  - data will be _stored_ in the _database_
  - an _email_ will be sent to the email-address given in the form asynchronously through laravel job
  - in response view
    - _sales history data_ within the input _date range_, fetched from the _API_ will be displayed in a table
    - jquery datatable has been used to data table
    - a _chart based on opening & closing price_ on Y Axis and dates on X Axis will be displayed
    - chart.js has been used for charts
- Feature & Unit tests are available
  - `tests/Feature/CompanyDetailFormTest.php`
  - `tests/Unit/CompanyServiceTest.php`
  - for testing, in app root dir run `php artisan test` 

Optional Requirements 

- Docker environment ready
- Has good Test coverage
- Has Dependency injection in controller

</div>
