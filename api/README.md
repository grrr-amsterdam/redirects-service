# Redirects

This microservice contains two endpoints:

- API: receives new redirects and stores them in a DynamoDB table
- Origin: reads redirects from the DynamoDB table and returns a 301 response when the url matches a redirect

This AWS Lambda function works as an origin in a CloudFront distribution. When an origin returns a 404 this Lambda is executed via AWS Lambda Function URL. When the requested URL doesn't match a redirect it returns a 404.

## Deploying

The service is deployed using [Serverless](https://serverless.com/). To deploy the service you need to have an AWS account and the AWS CLI installed.

Create a folder in you project repository. And copy `serverless.example.yml` as `serverless.yml` into it. Fill in the blanks:

- SERVICE_NAME: the name of the service, when running multiple clients in a AWS account use the client name in it.
- DEFAULT_DOMAIN: redirects without a domain will be suffixed with this domain.

Add a GitHub workflow to deploy the service. Copy `deploy.example.yml` as `deploy.yml` into the `.github/workflows` folder. Fill in the blanks:

- AWS_DEPLOY_ROLE: a AWS IAM role that has the permissions to deploy the service and GitHub is allowed to assume.
- AWS_REGION: the AWS region where the service will be deployed.
- GITHUB_TOKEN: a GitHub personal access token with the `repo` scope.
- SERVICE_VERSION: the version of the service, for example `v1.0.1`.
- STAGE: the stage of the server, for example `production` or `staging`.

Serverless deploy outputs an API url. Use this URL in plugin configurations.

To configure the CloudFront distribution to use the Lambda function as an origin see the example below.

```terraform
data "aws_lambda_function" "redirect" {
  function_name = "name-from-serverless-deploy-output"
}

data "aws_lambda_function_url" "redirect" {
  function_name = data.aws_lambda_function.redirect_productie.function_name
}

resource "aws_cloudfront_distribution" "website" {
  origin {
    origin_id                = "Content"
    ...
  }

  origin {
    domain_name = trimsuffix(replace(data.aws_lambda_function_url.redirect.function_url, "https://", ""), "/")
    origin_id   = "Redirects"
    custom_origin_config {
      http_port              = 80
      https_port             = 443
      origin_protocol_policy = "https-only"
      origin_ssl_protocols   = ["TLSv1.2"]
    }
  }

  origin_group {
    origin_id = "Content"
    failover_criteria {
      status_codes = [403, 404]
    }
    member {
      origin_id = "S3Content"
    }
    member {
      origin_id = "Redirects"
    }
  }

  default_cache_behavior {
    target_origin_id           = "Content"
    ...
  }
}
```

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
