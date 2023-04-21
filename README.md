# Redirects service

This is a simple service that redirects requests to a given URL.

## API

The API receives redirects from CMS systems and contains a CloudFront origin. See `api/README.md` for more information.

## Nova plugin

Adds a redirects resource to Nova and sends them to the API. See `nova-plugin/README.md` for more information.

## WordPress plugin

Adds a redirects post type to WordPress and sends them to the API. See `wordpress-plugin/README.md` for more information.
