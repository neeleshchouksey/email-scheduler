Steps for setup and run the project

1. clone the git repo
2. copy the .env.example to .env file in root folder
3. add your smtp credentials in .env file
4. create the database named email-scheduler
5. run composer update
6. run php artisan migrate
7. run php artisan queue:listen command
8. use the apis mentioned in the doc and check the flow
