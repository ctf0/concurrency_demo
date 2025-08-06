![demo](https://github.com/user-attachments/assets/278cb125-1ad0-430b-ad18-4225629603a0)

## Setup

- we use docker, so make sure its installed
- also you need composer & php installed, or run the below cmnd "at the project directory root"

    ```shell
    docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-req=php
    ```

- run `./vendor/bin/sail build;./vendor/bin/sail up -d`
- run `./vendor/bin/sail composer run post-root-package-install`
- run `./vendor/bin/sail composer run post-create-project-cmd`

## Usage

- check `config/system.php` for configuration
- env key `SIMULATE_REQUEST_CONDITIONS` is `true` by default to simulate different api request conditions ex. (delay, connection issues, empty response, etc..), disable it if you just want to see the data asap.
- to manually clear the cache, run `./vendor/bin/sail artisan optimize:clear`
    - even as cache is enabled, you still might get a delayed request because we dont cache bad requests,
    - you can check the `storage/laravel.log` for what is happening for each supplier request & why you might even get an empty response
- open your favorite api client app **(yaak, postman, etc..)** and paste the url, then make changes as you please.

    > http://localhost/api/hotels/search?location=Paris,%20France&check_in=06-08-2025&check_out=15-08-2025&guests=0&min_price=200&max_price=1500&sort_by=price

## Design

- we use `Concurrency` to aggregate data in parallel & avoid stalling the request, this also give us the chance to handle multiple different providers ex.(http, database, file) without changing anything.
- we use decorator pattern for both the `client & transformer` to enhance them both without cluttering ex.(try/catch, caching, logging).
- we use singleton to connect the clients to their transformers, check `HotelServiceProvider` for bindings.
- we use lazy collection to avoid filling out the memory when filtering & merging.
- we use Types/Enum/Dto wherever possible to ensure consistency and runtime rigidity.
- due to all of the above, we can test any part of the app (separately or combined) with ease.
