# Laravel Nova plugin

This plugin provides a `Redirect` model and a Nova Tool to manage this model.

## Installation

First, add the `repositories` directive to your `composer.json`:

```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/grrr-amsterdam/redirects-service"
    }
]
```

Second, require this package in your project:

```sh
composer require grrr/redirects
```

Make sure to publish the configuration file:

```sh
php artisan vendor:publish --provider="Grrr\Redirects\Nova\ToolServiceProvider"
```

In this configuration file, you can enter the API URL you got from the Serverless output, when deploying the Redirects API (see `api/README.md` in this repo for more).

Make sure to run the migrations!

```sh
php artisan migrate
```

Lastly, add the tool to your `NovaServiceProvider`, to enable redirect management in your CMS.

```php
public function tools()
{
    return [
        new \Grrr\Redirects\Nova\RedirectsTool(),
    ];
}
```

## How does this work?

When saving `Redirect` models, events are broadcasted. Listeners to these events will make sure the Redirects API is being kept up to date.

If you want to work with redirects outside of Nova, you can. Any updates you make to models will be reflected in the API.
