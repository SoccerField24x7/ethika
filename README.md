# Ethika Code Challenge

## System/Environment Requirements
* Composer
* Node.js
* Redis
* PostgreSQL

## Application Installation

* Clone Repository:  `git clone https://github.com/SoccerField24x7/ethika.git`
* Navigate to the root application directory: `cd ethika`
* Install dependencies `composer install`
* Install more dependencies `npm install`
* Generate the application key:  `php artisan key:generate`
* Compile: `npm run production`
* Test to ensure everything is running: `php artisan serve`

## Database Installation

* Update the .env file with your database connection information
* Update config/database.php with your database connection information
* Perform database migrations `php artisan migrate`
* Seed database

_Note_: Redis data will cache during operation - if this were 


## Design Decisions

* Redis - most modern web applications utilize data caching in some way. I wanted to demonstrate: a) I am aware of this, b) I can manage this.
* PostgreSQL - chosen because it is generally considered more robust, compliant, and ????
* Vue.js - A simple application, but wanted to learn something I didn't have experience with!
* Did not secure the endpoints.  In an actual API implementation, you likely want something like oAuth, or at least a
