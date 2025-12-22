# Pre-requisites

To configure and run this project you need the following pre-requisites:

-   Docker Engine

# How to configure and run the application

### Setup and run

Run the following command:

```bash
make setup
```

> Note: If the docker command fails, it probably means you do not have docker permissions configured correctly. To overcome this, you can add your user to the Docker group with `sudo usermod -aG docker $USER` and restart your computer.

Then, build and run the frontend:

```bash
make frontend
```

### Start the application

```bash
make up
```

```bash
make frontend
```

### Stop the application

```bash
make down
```

# Accessing the application

The setup creates a default admin account with the following credentials:

-   Email: admin@admin.com
-   Password: 123456

> Note: For production environments, it is ABSOLUTELY NECESSARY to change the email and password after configuring the environment.

The application will be accessible from the following URL:

-   http://localhost:8080

For checking emails (Mailpit), access the following URL:

-   http://localhost:8025

> Note: For an environment production, the email provider should be configured accordingly

# Running automated tests

To run automated tests, run the following command:

```bash
make test
```

# Useful commands

**Tip**: As this project runs inside containers, always use the prefix `./vendor/bin/sail` for all commands, such as `artisan`, `composer` or `NPM`.

To monitor logs in real time:

```bash
make logs
```

To access a shell inside the container:

```bash
make bash
```

# Project Architecture

### Inertia.js:

Chosen to deliver a Single Page Application (SPA) experience using Vue 3 without the overhead of a separate REST/GraphQL API. It allows the frontend to stay tightly coupled with Laravel's routing and controllers, significantly increasing development velocity.

### Laravel Sanctum & Policies:

Implemented to handle Token-based Authentication and Role-Based Access Control (RBAC). Sanctum provides a lightweight auth layer, while Policies encapsulate business rules—ensuring users can only manage their own data while granting Administrators exclusive permissions.

### Redis & Laravel Queues:

Configured to handle notifications (emails) asynchronously. By offloading these tasks to a background worker, we ensure that the UI remains responsive and the user doesn't wait for external SMTP responses during status updates.
