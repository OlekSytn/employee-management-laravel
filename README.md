## Employee Management Project

Make sure to download the following:
1. node js (https://nodejs.org/en/)
2. php (https://www.php.net/)
3. docker (https://www.docker.com/)

After cloning the repository run the following commands:
1. npm install
2. composer install
3. docker compose up -d

Create .env file same directory as .env.development file and copy its content.
1. Run command: php artisan migrate (make sure docker image is up and ready for db connection)

Lastly, perform the commands below:
1. npm run dev
2. php artisan serve

The app will run under the url http://127.0.0.1:8000/.


