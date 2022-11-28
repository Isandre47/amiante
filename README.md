PHP <8

### Project Setup

in base directory :

- copy and rename .env-exemple to .env and setup db connection
Then fill username and password to access MySQL DB
Run "node" in a terminal to start Node terminal and this command to create a secret token "require('crypto').randomBytes(64).toString('hex')"
Copy generated Secret to .env "APP_SECRET" value
- run "yarn install"
- run "composer install"
- run "yarn run dev"
- run "symfony server:start"
- run "yarn run watch"


if running into the errore "Connection could not be established with host "localhost:25": stream_socket_client(): Unable to connect to localhost:25 (Connection refused)"

run this line in MYSQL: "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
"