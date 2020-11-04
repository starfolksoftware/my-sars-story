# MySarsStory.org

Document the end sars protest

----------

# Getting started

## Installation


### JS

Install npm packages

	npm install

Compile .vue files

	npm run dev
    
### Laravel

Please check the official Laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs)


Clone the repository

    git clone https://github.com/starfolksoftware/my-sars-story.git

Switch to the repo folder

    cd my-sars-story

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

add application key to .env file

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

## Database seeding

**Populate the database with seed data**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh



----------

# Production Deployment

```
Recommendation: For production, we recommend laravel forge + linode. Linode for cloud hosting and laravel forge for server management.
```

## Server Requirements

If you choose to user other tools than the recommended, here are the server requirements:

- PHP >= 7.3
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Steps

- cd /path/to/my-sars-story
- run `composer install`
- run `cp .env.example .env` and fill in the the environment fields cc [understanding laravel environment variables](https://scotch.io/tutorials/understanding-laravel-environment-variables)
- run `php artisan key:generate`
- run `php artisan migrate --seed && php artisan passport:install && php artisan storage:link`
- login using email: `selase@tigereyefoundation.org` and password: `password`
- That's it!

----------


# Documentation

Read about the API Documentation [here](https://github.com/starfolksoftware/starfolksoftwarecom/blob/develop/docs)

# Contributing

Sleeves folded, ready to dive in? Read [this](https://github.com/starfolksoftware/starfolksoftwarecom/blob/develop/docs/contributing.md)
