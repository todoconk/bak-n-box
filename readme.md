# Bak-n-Box

Bak-n-Box is a cron job to easily handle mySQL backups databases and upload directly to DropBox via PHP.

## Features of Bak-n-Box
* Easy integration with LAMP servers
* Simple configuration
* Fast execution via Cron Job or HTTP Request
* Highly Portable (works on many Unix-like/POSIX compatible platforms as well as Windows, Mac OS X, BeOS etc.)

## Getting Started

### Create your Dropbox App

* Go to [Dropbox Apps](https://www.dropbox.com/developers/apps)
* Click to `"Create App"`
* Select `"Dropbox API app"`
* Choose `"Files and datastores"`
* Choose `"Yes -- My app only needs access to files it creates."`
* Write your `App Name`
* Click on `"Create App"` button

Now you have an **App key** and **App secret** ( **Keep Handy** )

```bash
App key a12bcde3fgh4567
App secret 1abcdefg23ghijkl
```

### Install & Configure Bak-n-Box

* Upload via FTP the bak-n-box folder to your `/public_html` folder
* Rename `/config-example.php` to `/config.php`
* Edit `/config.php` and update these variables with your parameters

```bash
//Dropbox Parameters
define('DROPBOX_APP_KEY', 'a12bcde3fgh4567');
define('DROPBOX_APP_SECRET', '1abcdefg23ghijkl');

//MySQL Database parameters
define('DATABASE_URL', 'localhost');
define('DATABASE_USER', 'user');
define('DATABASE_PASSWORD', 'password');
define('DATABASE_NAME', 'mydatabase');
```
* Run manually the first time
```bash
http://yourhost.com/bak-n-box/init.php
```
* When you run the first time, you will get an URL to authorize your app
```bash
https://www.dropbox.com/1/oauth/authorize?oauth_token=aOSbuvU7aPGjvdml&oauth_callback=http%3A%2F%2Fyourhost.com%2Fbak-n-box%2Finit.php%3Fauth_callback%3D1
```
* Authorize your app

* Run again
```bash
http://yourhost.com/bak-n-box/init.php
```
* That's all 


### Configure your Cron Job

* Go to your cpanel and take this instructions 

### Author

[Krikor Krikorian](https://github.com/todoconk) ([@todoconk](http://twitter.com/todoconk))

### License

Bak-n-Box is released under the [MIT License](http://www.opensource.org/licenses/MIT).
