### How to build and run?

- The `.env` file

```
DATABASE_URL="mysql://root:password@mysql8:3306/workshop_register"

MAILER_DSN=smtp://mailcatcher:1025
```

- Command Line

```
docker-compose up -d --build
docker container exec -it php74-workshop-register bash
bin/console doctrine:database:create (you may not need it if the database has already existed)
bin/console doctrine:migrations:migrate --no-interaction
bin/console doctrine:fixtures:load
```

- Go to port: `localhost:8070` to see the website app
- Go to port: `localhost:1081` to see the email sent