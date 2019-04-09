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

_Note_: Redis data will cache during operation, but I randomly choose up to 100 records to throw into the cache on application start. Just so I could figure out how/where to do this.

## Approach

* Utilized Test Driven Development (TDD) approach:
    * "Red - Green - Refactor": Write tests that fails (red), implement enough code to pass (green), once test is passing, you can safely refactor knowing your test will alert you to any logic errors you've introduced.
* Commit early and often; commit files separately with meaningful description. Some of my all time favorite useless commit messages:
    * "doing the needful"
    * "this better f***ing work"
    * "sixth attempt to fix, OMFG!"
    
* Have fun, step out of your comfort zone and learn something!

## Design Decisions

* Redis - most modern web applications utilize data caching in some way. I wanted to demonstrate: a) I am aware of this, b) I can manage this.
* PostgreSQL - chosen because it is generally considered more robust, compliant, and more readily supports transactions and foreign keys.
* Vue.js - A simple application, but wanted to learn something I didn't have experience with!
* Did not secure the endpoints.  In an actual API implementation, you likely want something like oAuth, or at least a
* Did not secure Redis. 
* Under normal circumstances, the .env and config/database.php files would have been cleansed of user/password data.
* I used a literal interpretation of your requirements and constrained `orders` by enforcing a unique email address per order.
* Initially, I added authentication (as you can see from the commit history), then decided against it because it added too much clutter to the project.
* Decided on server-side validation. Since the DOM can be manipulated manually, validation needs to be done on the server before save anyway.
* Utilizing the 'web' middleware in routes/api.php which enforces CSRF checking/passing.
* Not using mock data objects for unit testing.
* Simply allowed entry of line numbers during order entry. Ideally, this would be transparent to the user, but left it visible so that you could create a conflict (and show error bubbled up).

## Ah Ha! Moments
* I had a plan for the search functionality using one of my favorite jQuery libraries - DataTables.  However it does not play nicely with Vue! By the time I had this realization, I was DEEP into the Vue implementation (even with as simplistic as it is) and went deep down the rabbit hole trying to make it work.  There are some promising alternatives for when I am more thoroughly versed in Vue, but in the interest of time, I jettisoned the Vue component for search and utilized straight jQuery. I initially wanted to demonstrate server-side paging (similar to <a href="https://github.com/SoccerField24x7/joybird/blob/master/app/Http/Controllers/JoybirdController.php">this</a>), but this will do for now.

## To Do Items
* Implement Vue router to handle multiple "pages".
* Implement logging.
* Standardize responses - some duplicate code could be eliminated with a formatResponse() method.
* Provide modal with order details including line items on the search page.
* Improve search by allowing search for products. Improve performance.
