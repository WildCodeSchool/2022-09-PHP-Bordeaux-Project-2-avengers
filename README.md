# Wildify - Music streaming website

## Description

This repository is a five-week PHP MVC project realized in 2022 as part of a study project, at the Wild Code School, Bordeaux (FR).

The main objective for the team was to build a website mostly inspired by Spotify and, more importantly, to put into practice some concepts such as:
- website conception (brainstormimng, wireframes...)
- MVC architecture
- OOP
- Twig
- Database designing
- Complete CRUD (user + tracks)
- Sessions
- Manage API connection (in this case, Spotify)
- Teamwork (Agile Scrum method, Git WorkFlow)
- ...

## The team (a.k.a. "The Avengers")
- Hélène Fourcade
- Alexis Boucherie
- Andy Ricana
- Anthony Marché
- Bixente Lasserre

## Steps to launch the project on your computer

1. Clone the repo from Github.
2. Run `composer install`.
3. Create *config/db.php* from *config/db.php.dist* file and add your DB parameters. Don't delete the *.dist* file, it must be kept.
```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PASSWORD', 'your_db_password');
```
4. Go to Spotify for Devs (https://developer.spotify.com/dashboard/applications) and click on "create an app" to ask for your own credentials (clientID & clientSecret). Add them to your *db.php*. This will allow you to get an access token from Spotify while using Wildify App and access all music related actions.
```php
define('CLIENT_ID', 'your_client_id');
define('CLIENT_SECRET', 'your_client_secret');
```
5. Optionnal: If you'd like to use the "send mail" option, you have to create a double factor authentication in your Gmail account and generate an "app password". When ready, add your credentials to your *db.php*.
```php
define('MAIL_USER NAME', 'your_email');
define('MAIL_PASSWORD', 'your_password');
```
6. Import *database.sql* in your SQL server, you can do it manually or use the *migration.php* script which will import a *database.sql* file.
7. Run the internal PHP webserver with `php -S localhost:8000 -t public/`. The option `-t` with `public` as parameter means your localhost will target the `/public` folder.
8. Go to `localhost:8000` with your favorite browser.
9. Register as a new User on the registration page or create a new user from scratch, directly in your database (an "admin" role is required to have full access to all features)
10. After these steps, you should be able to access the whole website. Have fun!
