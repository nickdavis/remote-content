# Remote Content
WordPress plugin to help developers get remote content from Facebook, Instagram and Twitter in a standard format

## About
This plugin is for developers who want to quickly and easily get data from the Facebook, Instagram and Twitter APIs in a standard format.

It is very much a work in progress.

## Setup
Currently you need to define the relevant API keys as constants for the social network/s you want to use.

**Do not define the constants in any version controlled file**. Instead include them in `wp-config.php`, assuming this is not version controlled.

```php
/**
 * API Keys (Facebook)
 */
define( 'FACEBOOK_ACCESS_TOKEN', '' );
define( 'FACEBOOK_CLIENT_ID', '' );
define( 'FACEBOOK_PAGE_ID', '' );

/**
 * API Keys (Instagram)
 */
define( 'INSTAGRAM_ACCESS_TOKEN', '' );
define( 'INSTAGRAM_CLIENT_ID', '' );
define( 'INSTAGRAM_USER_ID', '' ); // https://www.instagram.com/username/?__a=1

/**
 * API Keys (Twitter)
 */
define( 'TWITTER_CONSUMER_KEY', '' );
define( 'TWITTER_CONSUMER_SECRET', '' );
define( 'TWITTER_OAUTH_ACCESS_TOKEN', '' );
define( 'TWITTER_OAUTH_ACCESS_TOKEN_SECRET', '' );
define( 'TWITTER_USERNAME', '' ); // Without the @
```

## Usage
First, get the data you need in either the standardised or raw format.

```php
\NickDavis\RemoteContent\get_remote_content( 'facebook' );
\NickDavis\RemoteContent\get_remote_content( 'facebook', true ); // Gets the raw, non-standardised data

\NickDavis\RemoteContent\get_remote_content( 'instagram' );
\NickDavis\RemoteContent\get_remote_content( 'instagram', true ); // Gets the raw, non-standardised data

\NickDavis\RemoteContent\get_remote_content( 'twitter' );
\NickDavis\RemoteContent\get_remote_content( 'twitter', true ); // Gets the raw, non-standardised data
```

### Standard format
The standard format gives you the data from the API in a standardised array, using keys such as `title` and `username` to give you a consistent way of working with the data, whatever the origin.

### Raw format
The raw format gives you the raw data from the API call. To make it easier to view the output you might want to use Kint (also available for WordPress via the Kint PHP Debugger plugin) to more easily understand the output.
