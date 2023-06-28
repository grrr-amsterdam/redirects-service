const { GetItemCommand, DynamoDBClient } = require("@aws-sdk/client-dynamodb");
const {
  not_found,
  redirect,
  internal_server_error,
} = require("./src/responses");

const client = new DynamoDBClient();

const defaultDomain = process.env.DEFAULT_DOMAIN;

/**
 * - Remove trailing /index.html
 */
const preparePath = (url) => url.replace(/\/index\.html$/, "");

const createPathWithTrailingSlash = (path) => {
  if (!path.endsWith("/")) {
    return `${path}/`;
  }
  return path;
};

const createPathWithoutTrailingSlash = (path) => {
  if (path.endsWith("/")) {
    return path.substring(0, path.length - 1);
  }
  return path;
};

const fetchRedirect = (path) => {
  const input = {
    TableName: process.env.DYNAMODB_TABLE,
    Key: {
      from: {
        S: path,
      },
    },
  };

  return client.send(new GetItemCommand(input));
};

exports.handler = async (event) => {
  const path = preparePath(event.rawPath);

  const pathWithTrailingSlash = createPathWithTrailingSlash(path);

  return fetchRedirect(pathWithTrailingSlash)
    .then((response) => {
      if (!response.Item) {
        return fetchRedirect(createPathWithoutTrailingSlash(path));
      }
      return response;
    })
    .then((response) => {
      if (!response.Item) {
        return not_found();
      }

      let to = response.Item.to.S;

      if (event.rawQueryString) {
        to += `?${event.rawQueryString}`;
      }

      if (!to.startsWith("http")) {
        to = `${defaultDomain}${to}`;
      }

      const statusCode = response.Item.permanently.BOOL ? 308 : 307;

      console.log(`Redirect ${path} to ${to} with ${statusCode}.`);

      return redirect(to, statusCode);
    })
    .catch((error) => {
      console.error(error);
      return internal_server_error(`Error fetching redirect ${path}`);
    });
};
