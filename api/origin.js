const { GetItemCommand, DynamoDBClient } = require("@aws-sdk/client-dynamodb");
const {
  not_found,
  redirect,
  internal_server_error,
} = require("./src/responses");
/**
 * - Remove trailing /index.html
 */
const preparePath = (url) => url.replace(/\/index\.html$/, "");

const client = new DynamoDBClient();

const defaultDomain = process.env.DEFAULT_DOMAIN;

exports.handler = async (event) => {
  const path = preparePath(event.rawPath);

  const input = {
    TableName: process.env.DYNAMODB_TABLE,
    Key: {
      from: {
        S: path,
      },
    },
  };

  return await client
    .send(new GetItemCommand(input))
    .then((response) => {
      if (!response.Item) {
        return not_found();
      }

      let to = response.Item.to.S;

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
