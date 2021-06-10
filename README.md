# Shop Demo App

 * See [Scenarios](features/singlemanning.feature)

## Setup 

All Steps are run using docker cli from the root directory

1. Install PHP Dependencies

```bash
docker run --rm --interactive --tty --volume $PWD:/app composer install
```
## Run Tests

1. PHPUnit

```bash
    docker run --rm -v "$PWD":/app -w "/app" php:8-cli ./vendor/bin/phpunit
```

1. Behat

```bash
    docker run --rm -v "$PWD":/app -w "/app" php:8-cli ./vendor/bin/behat
```
