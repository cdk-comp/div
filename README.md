# [Divi starter](https://github.com/cdk-comp/div)


Divi based CDKrock is a modern WordPress stack that helps you get started with the best development tools and project structure. This is clone of Roots/Bedrock with standart structure.
The project have db import by wp cli

## Features

* Dependency management with [Composer](http://getcomposer.org)
* Easy WordPress configuration with environment specific files
* Environment variables with [Dotenv](https://github.com/vlucas/phpdotenv)
* Autoloader for mu-plugins (use regular plugins as mu-plugins)
* Enhanced security (separated web root and secure passwords with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))
* Custom child theme with gulp starter kit
* Admin js and css included

Use [EasyEngine-Vagrant](https://github.com/DimaMinka/easyengine-vagrant) for additional features:

* Wordmove
* Easy development environments with [Vagrant](http://www.vagrantup.com/)
* Easy server management with python (Ubuntu 16.04, PHP 7, MariaDB)
* One-command deploys


## Requirements

* PHP >= 5.6
* Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
* wp cli for auto db import on composer install [Install](https://make.wordpress.org/cli/handbook/installing)
* wp package install aaemnnosttv/wp-cli-dotenv-command
* node.js. yarn or npm
* gulp installed global

## Installation

1. Create a new project in a new folder for your project:

  `git clone https://github.com/cdk-comp/div.git`

2. Copy `.env.example` to `.env` and update environment variables:
  * `DB_NAME` - Database name
  * `DB_USER` - Database user
  * `DB_PASSWORD` - Database password
  * `DB_HOST` - Database host
  * `WP_ENV` - Set to environment (`development`, `staging`, `production`)
  * `WP_HOME` - Full URL to WordPress home (http://elm.test)
  * `WP_PREFIX` - Special database prefix for more security
  * `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`, `NONCE_SALT`

  If you want to automatically generate the security keys (assuming you have wp-cli installed locally) you can use the very handy [wp-cli-dotenv-command][wp-cli-dotenv]:

      wp package install aaemnnosttv/wp-cli-dotenv-command

      wp dotenv salts regenerate

  Or, you can cut and paste from the [Roots WordPress Salt Generator][roots-wp-salt].

3. Add theme(s) in `wp/wp-content/themes` as you would for a normal WordPress site.

OR
  
Use the child theme:

`yarn` or `npm i`  must be run as part of the deploy process.

`gulp build`       must be run as part of the child theme creation.

4. Access WP admin at `http://div.test/wp-admin` with the details:
* User: div-admin
* Password: password

## Deploys

There are two methods to deploy Bedrock sites out of the box:

* [Wordmove](https://github.com/welaika/wordmove)
* [Easy-Engine](https://github.com/EasyEngine/easyengine)
* [Trellis](https://github.com/roots/trellis)
* [bedrock-capistrano](https://github.com/roots/bedrock-capistrano)

Any other deployment method can be used as well with one requirement:

`composer install` must be run as part of the deploy process.

## Documentation

Bedrock documentation is available at [https://roots.io/bedrock/docs/](https://roots.io/bedrock/docs/).

[roots-wp-salt]:https://roots.io/salts.html
[wp-cli-dotenv]:https://github.com/aaemnnosttv/wp-cli-dotenv-command
