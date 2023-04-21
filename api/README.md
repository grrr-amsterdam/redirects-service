# Redirects

This microservice contains two endpoints:

- API: receives new redirects and stores them in a DynamoDB table
- Origin: reads redirects from the DynamoDB table and returns a 301 response when the url matches a redirect

This AWS Lambda function works as an origin in a CloudFront distribution. When the webserver returns a 404 this Lambda is executed via AWS Lambda Function URL. When the requested URL doesn't match a redirect it returns a 404.

## API

The redirect model properties:

- from: string starting with a slash
- to: string starting with a slash or a full URL
- permanently: boolean to indicate if the redirect is permanent (308) or temporary (307). Default value is false.

Create or update a redirect:

```
POST /
{
  "from": "/old-url",
  "to": "/new-url"
  "permanently": true
}
```

Delete a redirect:

```
DELETE /
{
    "from": "/old-url"
}
```
