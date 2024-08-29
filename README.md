## Setup project

1. Prepare environment, recommended is official Docker image: php:8.3-cli
2. Clone project
3. Fetch dependencies: `composer install`.

## Run calculation

In project main directory run:

`bin/console app:commission input.txt`

Warning! Calculation uses outer API where request limit is 5 per hour

## Run tests
`bin/phpunit`

## Input data file (can be modified)

`/input.txt`
