# Docker PHP-FPM 8.1 & Nginx 1.24 on Alpine Linux
Example PHP-FPM 8.1 & Nginx 1.24 container image for Docker, built on [Alpine Linux](https://www.alpinelinux.org/).

## Usage

Start the Docker container:

    docker run -p 80:8080 causefx/laravel-dev

See the PHP info on http://localhost, or the static html page on http://localhost/test.html

Or mount your own code to be served by PHP-FPM & Nginx

    docker run -p 80:8080 -v ~/my-codebase:/var/www/html causefx/laravel-dev
