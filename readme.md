## Installation
After cloning

Open the directory

run composer install

change .env.example to .env then configure based on your environment
change broadcast driver to pusher
set pusher variable
PUSHER_APP_ID=[any random string you want]
PUSHER_APP_KEY=[any random string you want]
PUSHER_APP_SECRET=[any random string you want]

Then run 
php artisan migrate --seed
npm install
npm run dev

php artisan serve
php artisan websockets:serve
