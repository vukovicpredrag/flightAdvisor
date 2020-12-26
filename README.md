# Flight Advisor

Service for founding the cheapest flight between cities.

Cites CRUD (Admin create cities, users can read, write, edit or delete city comments)

## Installation

 Install Composer Dependencies

```bash
composer install
```

Install NPM Dependencies

```bash
npm install
```

Create a copy of your .env file

```bash
cp .env.example .env
```
*import database and set DB_DATABASE='db_name' in .env

 Generate an app encryption key

```bash
php artisan key:generate
```
Configuration Caching
```bash
php artisan config:cache
```


## Usage
There are two types of the users: administrator and regular user.


Administrator is able to:

```
● Add cities.
● Import the data for the airports and routes 
```

Regular user is able to:
```
● Get all the cities
● Search for cities by name
● Add a comment for the city.
● Delete a comment.
● Update a comment.
● Fiding cheapest flights from city A to B. 
```


