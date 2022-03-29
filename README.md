# Portfello 

## Application for monitoring expenses based on splitwase https://splitwise.com

It is a uni-project for subject Programming in PHP contributed with:
- Szymon Berdzik (oxygensend)
- Jakub Machalica (jmachalica)
- Tomasz Kurcaba (TKurcaba)
- Daniel Defiński (DDefinski)

Project was forked from bitbucket 

## App requirements

- The website allows users to register via e-mail and password, and has e-mail verification.
- Users can create and join groups shared with other users.
- Users get real-time notifications when they got invitation to new group.
- Users can add expenses within groups and mark people who contributed to a given expense.
- Users can edit their data and delete account.
- It is possible to connect with only one user in order to settle expenses.
- After entering a given group, the user can see the current balance in the given group.
- On the home page, after logging in, the user sees his total balance in all groups.
- Being in a given group, the user has the option to mark the fact that he has already accounted for another user.
- It is possible to add material settlements in a non-monetary form.
- The application stores the history of settlements and allows you to edit them.

## Stack
- PHP
- Laravel
- Tailwind
- Pusher
- Smtp
- MySQL
- Codeception tests
- Alpinejs
- Intervention image
- Docker

# Deployment
 You can test app at heroku server: https://portfello.herokuapp.com

# Run locally

`sudo docker run --name=mysql --env MYSQL_ROOT_PASSWORD=root123 --env MYSQL_ROOT_HOST=% --env MYSQL_DATABASE=test --env MYSQL_USER=test --env MYSQL_PASSWORD=test123  --publish 6603:3306  -d mysql/mysql-server:latest`
`./db_run.sh` twice, some weird error </br>
`php arstian serve --port 8888`

# Tests

`cd project` </br>
`vendor/bin/codecept run`



