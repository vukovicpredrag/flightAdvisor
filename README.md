# Flight Advisor

Service for founding the cheapest flight between cities.

## Technologies
- Programing language: PHP | *requred(7.2.5)
- Framework: Laravel 7.29 


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
● Import data for the airports and routes 
*required for flight finder functionality
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

## Local url path
http://localhost/flightAdvisor/public/login


