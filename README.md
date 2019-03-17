# email-transaction-microservice

- Although I thought redis might be a good option with regards to storing mail state, mysql prebuild docker setup are ready to go hence quicker
- Rather than use a single Docker images for it all, separate out mysql from the php/nginx containers for scalability 
- Aim to include a few of the nice-to-haves from the start to ensure I account for them when building as it's much harder to get them in later.
- Keep Vue.js application as simple as possible unless/till there's time to make it nicer as it's a nice-to-have
- Use PUT rather than POST for creating a new mail, as repeatedly submitting the same information should not result in multiples

## Running the service
On a docker enabled host, run from inside the root dir of the repo

  - docker-compose up

You'll need to create a .env file first based on the .env.example file with environment details

Then, inside the lumen directory of the project run
  php artisan migrate:fresh && php artisan db:seed

This will set up the database tables and add some sample data

To run unit tests, after resetting the database using the above command, enter
phpunit

To use from CLI
curl -X PUT \
  http://[site_domain]:8008/user/1/mail/2 \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'Postman-Token: 6aa2501b-2a8a-42f8-9771-e65e21dc18d4' \
  -H 'cache-control: no-cache' \
  -d 'uid=1&mtid=1&mail_to=testddtdhis%40example.com%2C%20andotheffremail%40example.com&content=dfddsdfsJust%20ansther%20emailddfddfgsdvsdfsdfsdfd&subject=This%20is%20a%20email&undefined='
