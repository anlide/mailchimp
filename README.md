## About

This is test app for Softex company.

About integration with mailchimp.

RESTful API laravel implementation.

Mail lists & members of those lists.

## How to deploy

- Fill `.env` file with mysql access and `MAILCHIMP_API_KEY`.
- Run `composer install`
- Run `php artisan migrate`
- Run `php artisan mailchimp:sync`
- Run `php artisan serve`
- System ready for using.

## List of API

# Mail list:
- GET http://127.0.0.1:8000/mail_lists -- Get list of mail list
- GET http://127.0.0.1:8000/mail_lists/{id} -- Get one mail list
- POST http://127.0.0.1:8000/mail_lists -- Create mail list
- PUT http://127.0.0.1:8000/mail_lists/{id} -- Update mail list (name)
- DELETE http://127.0.0.1:8000/mail_lists/{id} -- Delete mail list

# Members of mail list:
- GET http://127.0.0.1:8000/mail_lists{id}/members -- Get list of members in the mail list
- GET http://127.0.0.1:8000/mail_lists{id}/members/{email} -- Get one member in the mail list
- POST http://127.0.0.1:8000/mail_lists{id}/members -- Create member in the mail list
- PUT http://127.0.0.1:8000/mail_lists/{id}/members/{email} -- Update member in the mail list (first_name, last_name)
- DELETE http://127.0.0.1:8000/mail_lists/{id}/members/{email} -- Delete member from the mail list

## Additional features were implemented

- Unit testing.
- Error handling.
- Comments at each please.
- Validation input.
- Local cache via database.

## TODO

There are a lot of TODO in the code.

Someone should do that before it will be used at some production.
