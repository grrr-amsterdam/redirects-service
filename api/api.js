const {
  DynamoDBClient,
  PutItemCommand,
  DeleteItemCommand,
} = require("@aws-sdk/client-dynamodb");
const {
  ok,
  not_found,
  bad_request,
  internal_server_error,
} = require("./src/responses");

const client = new DynamoDBClient();

exports.handler = async (event) => {
  if (!event.body) {
    return not_found();
  }

  let body = null;

  try {
    body = JSON.parse(event.body);
  } catch (error) {
    return bad_request("Invalid JSON: " + error.message);
  }

  const method = event.requestContext.http.method;

  if (method === "POST") {
    return await handlePost(body);
  } else if (method === "DELETE") {
    return await handleDelete(body);
  }

  return not_found();
};

async function handlePost(body) {
  if (!body.from || !body.to) {
    return bad_request("Missing required fields: from, to");
  }

  const input = {
    TableName: process.env.DYNAMODB_TABLE,
    Item: {
      from: {
        S: body.from,
      },
      to: {
        S: body.to,
      },
      permanently: {
        BOOL: body.permanently ?? false,
      },
    },
  };

  return client
    .send(new PutItemCommand(input))
    .then((response) => ok("Redirect created"))
    .catch((error) => {
      console.error(error);
      return internal_server_error("Error creating redirect");
    });
}

async function handleDelete(body) {
  if (!body.from) {
    return bad_request("Missing required field from");
  }

  const input = {
    TableName: process.env.DYNAMODB_TABLE,
    Key: {
      from: {
        S: body.from,
      },
    },
  };
  return client
    .send(new DeleteItemCommand(input))
    .then((response) => ok("Redirect deleted"))
    .catch((error) => {
      console.error(error);
      return internal_server_error("Error deleting redirect");
    });
}
