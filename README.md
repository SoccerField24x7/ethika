# Ethika Code Challenge

## System/Environment Requirements
* Composer
* Node.js
* Redis
* PostgreSQL
* PHP 7.1+

## Application Installation

* Clone Repository:  `git clone https://github.com/SoccerField24x7/ethika.git`
* Navigate to the root application directory: `cd ethika`
* Install dependencies `composer install`
* Install more dependencies `npm install`
* Generate the application key:  `php artisan key:generate`
* Compile: `npm run production`
* Run all Unit Tests to ensure everything is wired up properly `vendor/bin/phpunit`
* Fire up the server `php artisan serve`

## Database Installation

* Update the .env file with your database connection information
* Update config/database.php with your database connection information
* Perform database migrations `php artisan migrate`
* Seed database

_Note_: Redis data will cache during operation - if this were 

## Approach

* Utilized Test Driven Development (TDD) approach:
    * "Red - Green - Refactor": Write test that fails (red), implement enough code to pass (green), once test is passing, you can safely refactor knowing your test will alert you to any logic errors you've introduced.
* Commit early and often; commit files separately with meaningful description. Some of my all time favorite useless commit messages:
    * "doing the needful"
    * "this better f***ing work"
    * "sixth attempt to fix, OMFG!"
    
* Have fun, step out of your comfort zone and learn something!

## Design Decisions

* Redis - most modern web applications utilize data caching in some way. I wanted to demonstrate: a) I am aware of this, b) I can manage this.
* PostgreSQL - chosen because it is generally considered more robust, compliant, and ????
* Vue.js - A simple application, but wanted to learn something I didn't have experience with!
* Did not secure the endpoints.  In an actual API implementation, you likely want something like oAuth, or at least a
* Did not secure Redis - ?
* Under normal circumstances, the .env and config/database.php files would have been cleansed of user/password data.
* I used a literal interpretation of your requirements and constrained `orders` by enforcing a unique email address per order.
* Initially, I added authentication (as you can see from the commit history), then decided against it because it added too much clutter to the project.
