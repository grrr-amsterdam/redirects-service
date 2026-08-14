# Changelog

## v3.0.0

- Upgrade to the Node.js 24 runtime (current LTS); Node.js 20 is deprecated on AWS Lambda since April 2026.
- Replace the unmaintained Serverless Framework v3 with the [osls](https://github.com/oss-serverless/serverless) fork, which supports the `nodejs24.x` runtime and provides the same `serverless` CLI.
- Breaking: projects upgrading to this version must set `runtime: nodejs24.x` in their copied `serverless.yml` and `node-version: "24"` in their deploy workflow (`yarn install` fails on older Node versions due to the `engines` requirement).

## v2.2.0

- Upgrade to Node.js 20 runtime for improved performance and security.

## v2.1.1

- Only append question mark when there is a query string.

## v2.1

- Copy the `package.patterns` section from `api/serverless.example.yml` to reduce the Lambda package size.
- The origin first checks the incoming URL with trailing slash, then without.

## v2.0

- Upgrade Nova plugin to be compatible with Nova 4.

## v1.0

- Initial release. Contains Laravel Nova plugin
