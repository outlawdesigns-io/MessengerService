# Messenger REST API

## Preamble
The Messenger Services provides an interface for developers to programmatically generate email communications. This service can be used to build reports or client applications in any language that supports making http calls.

## Meta

> All generated messages will be from automation@outlawdesigns.io

### Security

This API is accessible only by registered users of [outlawdesigns.io](https://outlawdesigns.io) who present a valid Oauth2 access token.

#### Sample Token Acquisition
```
curl --location --request POST 'https://auth.outlawdesigns.io/oauth2/token' \
--form 'grant_type="client_credentials"' \
--form 'client_id="$CLIENT_ID"' \
--form 'client_secret="CLIENT_SECRET"' \
--form 'audience="https://messenger.outlawdesigns.io"' \
--form 'scope="openid, profile, email, roles"'
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
