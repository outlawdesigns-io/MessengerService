# Messenger REST API

## Preamble
The Messenger Services provides an interface for developers to programmatically generate email communications. This service can be used to build reports or client applications in any language that supports making http calls.

## Meta

> All generated messages will be from automation@outlawdesigns.io

### Security

This API is accessible only by registered users of [outlawdesigns.io](https://outlawdesigns.io) who present a valid authorization token.
Authorization tokens should be presented as a value of the `auth_token` header. See [AccountService Documentation](https://github.com/outlawdesigns-io/AccountService) for more details.

#### Sample Call
```
curl --location --request POST 'https://api.outlawdesigns.io:9667/send' \
--header 'auth_token: YOUR_ACCESS_TOKEN' \
--header 'Content-Type: application/json' \
--data-raw '{
  "to":["example@example.com"],
  "subject":"A Test",
  "msg_name":"test",
  "body":"Sent using Postman"
}'

```

### Reporting performance or availability problems

Report performance/availability at our [support site](mailto:j.watson@outlawdesigns.io).

### Reporting bugs, requesting features

Please report bugs with the API or the documentation on our [issue tracker](https://github.com/outlawdesigns-io/MessengerService/issues).

## Endpoints

### send/
* [SendMessage](./Docs/Send.md)

### message/

* [GetAllMessages](./Docs/GetAllMessages.md)
* [GetMessage](./Docs/GetMessage.md)

### search/

* [SearchSentMessages](./Docs/Search.md)

### sent/

* [IsMessageSent](./Docs/Sent.md)
