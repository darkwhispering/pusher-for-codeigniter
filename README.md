![Not maintained](https://img.shields.io/badge/maintained%3F-no!-red.svg?style=flat)

**This library is no longer activly maintained or updated. It might still work, but use at your own risk.**

# Pusher PHP SDK for CodeIgniter

This is a simple library that wraps the [Pusher PHP library](https://github.com/pusher/pusher-http-php) and give you access to the Pusher methods using regular CodeIgniter syntax.

## Requirements
- [CodeIgniter 3+](http://www.codeigniter.com/)
- [Pusher PHP SDK](https://github.com/pusher/pusher-http-php)
- [Composer](https://getcomposer.org/)
- PHP 5.3.2+

## Install
1. Download the library files and add the them to your CodeIgniter installation. Only the library, config and composer.js files are required.
2. In CodeIgniter `/application/config/config.php` set `$config['composer_autoload']` to `TRUE`.
3. Update the pusher.php config file in `/application/config/pusher.php` with you app details.
4. Install the Pusher PHP SDK by navigating to your applications folder and execute `composer install`.
5. Autoload the library in `application/config/autoload.php` or load it where you need it with `$this->load->library('ci_pusher');`.
6. Enjoy!

## How to use
Example to send a new message to the client
```php
$this->load->library('ci_pusher');
$pusher = $this->ci_pusher->get_pusher();
$pusher->trigger('test_channel', 'my_event', array('message' => 'Hello World'));
```

More detailed documentation can be found in [Pusher PHP SDK documentation](https://github.com/pusher/pusher-http-php#publishingtriggering-events)

## Changelog
##### v2.0.0 - June 2015
- Created new function that returns the Pusher object.
- Removed all of the duplicated Pusher function used in previous version.
- Made small change to debug class name.
- Updated example code.

##### v.1.0.0 - April 2015
- Initial release.
