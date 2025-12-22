# Pre-requisites

To configure and run this project you need the following pre-requisites:

-   Docker Enginer
-   Git

# How to configure and run the application

First step is to generate a dotenv file. All settings for a local development and testing environment are already pre-configured in the `.env.example`, however for production it is **MANDATORY** to change the values.

```bash
cp .env.example .env
```

Next it is necessary to install the dependencies. This repository uses Docker to ensure atomicity and guarantees that the application is OS-agnostic.

Run the following command once to configure the necessary dependencies:

```bash
docker run --rm \
 -u "$(id -u):$(id -g)" \
 -v "$(pwd):/var/www/html" \
 -w /var/www/html \
 laravelsail/php83-composer:latest \
 composer install --ignore-platform-reqs
```

> This command runs a temporary docker container and will be autoremoved once it has finished running. The temporary container will install the dependencies and mount the path to your current working directory inside the container, so make sure to run this command inside the project's folder.

Then, the following command is what keeps the app running in the background:

```bash
./vendor/bin/sail up -d
```

Once you have the application configured and running, the following commands will configure the database.

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

The seeding flag is to create a default admin account with the following credentials:

-   Email: admin@admin.com
-   Password: 123456

> Note: For production environments, it is ABSOLUTELY NECESSARY to change the email and password after configuring the environment.

The final step is to compile and run the Front-End application:

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

After that, the application will be accessible from the following URL:

-   http://localhost

For checking emails (Mailpit), access the following URL:

-   http://localhost:8025

> Note: For an environment production, the email provider should be configured accordingly

# Running automated tests

To run automated tests, with the application running via `sail`, run the following command:

```bash
./vendor/bin/sail artisan test
```

# Useful commands

**Tip**: As this project runs inside containers, always use the prefix `./vendor/bin/sail` for all commands, such as `artisan`, `composer` or `NPM`.

To stop all containers:

```bash
./vendor/bin/sail stop
```

To monitor logs in real time:

```bash
./vendor/bin/sail logs -f
```

To access a shell inside the container:

```bash
./vendor/bin/sail shell
```
