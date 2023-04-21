const ok = function (message) {
  return {
    statusCode: 200,
    body: JSON.stringify({
      message: message,
    }),
  };
};

const redirect = function (to, permanently = false) {
  return {
    statusCode: permanently ? 308 : 307,
    headers: {
      location: to,
    },
  };
};

const bad_request = function (message) {
  return {
    statusCode: 400,
    body: JSON.stringify({
      message: message,
    }),
  };
};

const not_found = function () {
  return {
    statusCode: 404,
  };
};

const internal_server_error = function (message) {
  return {
    statusCode: 500,
    body: JSON.stringify({
      message: message,
    }),
  };
};

module.exports = {
  ok,
  redirect,
  bad_request,
  not_found,
  internal_server_error,
};
