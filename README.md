# Welcome to portfolio 👋
[![Version](https://img.shields.io/npm/v/portfolio.svg)](https://www.npmjs.com/package/portfolio)

## Installation

1. Clone the current repository.

2. Move into the directory and create an `.env.local` file.
   **This one is not committed to the shared repository.**
   Set `db_name`.

4. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install

# Create DB
php bin/console d:d:c

# Create migrations
php bin/console make:migration

# Execute migrations and create tables
php bin/console d:migration:migrate

# Execute fixtures
php bin/console d:f:l
```

## Usage

```sh
yarn install 
yarn encore dev 
symfony server:start
```

## Show your support

Give a ⭐️ if this project helped you!


***
_This README was generated with ❤️ by [readme-md-generator](https://github.com/kefranabg/readme-md-generator)_