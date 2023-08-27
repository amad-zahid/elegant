
# Laravel/WordPress Lead Gen Form

A simple CRM system for a client. The system will collect customer data and build customer profiles that the client can browse and manage. Customer profiles will exist inside of a custom Laravel dashboard adjoined by matching customer profiles on a WordPress website.



## Enviornment Variables

1: Add Laravel DB credentials in .env file

2: `WP_URL` variable is define to configure the WordPress website URL.

e.g: `WP_URL='http://localhost/your-folder-path'`

3: `WP_TOKEN` variable is define to authenticate the request within WP, while creating a user.

## Documentation

To configure the Laravel Application you need to follow below steps.

Step 1: Just insure that all the packages are inside the node_modules folder.

`composer install`

Step 2: Run Migration, to create DB tables.

`php artisan migrate`

Step 3: Run Seed, to create default user.

`php artisan db:seed`

Step 4: Create a build for vite by using below command, this will create a build folder inside Public.

`npm run build`

Step 5: Run the vite script to compress files runtime.

`npm run dev`

Step 6: To run the Laravel Project on Browser, run this command in a new terminal tab, along with the previous command.

`php artisan serve`





