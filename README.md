## Soccer simulator

```

git clone https://github.com/dralexsand/soccersimulator.git
cd soccersimulator

cp .env.example .env

docker-compose up --build

docker exec appfootball_php php artisan migrate
docker exec appfootball_php php artisan db:seed

App running on:

http://127.0.0.1:8096/

```
