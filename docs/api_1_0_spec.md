---
title: the title
categories: Review
summary: "The Summary"
published: true|false
preview_image: images/blog/headers/blog_header_coding2018_fb.png
preview_image_twitter: images/blog/headers/blog_header_coding2018_twitter.png
hidden: true|false
---

# User, User Registration and Authentication

## Register

### `api/v1/register` (POST)

| URL                    | Function             |
| ---------------------- | -------------------- |
| `api/v1/register`      | Register a new user. |

#### Required role

`any`.

#### Input Description

| Field                     | Description                                                             |
| ------------------------- | ----------------------------------------------------------------------- |
| `email`                   | *(string)* Email of new user.                                           |
| `password`                | *(string)* Password of new user.                                        |
| `name`               | *(string)* Full name of new user.                                       |
| `password_confirmation`                   | *(string)* Password confirmation of new user.   |

Password re-entering and comparison is carried out at server level. However, such task is also advised to be carried out at the client level.

<!-- Client should prevent automated registrations with a CAPTCHA.

After successful registration, user can not immediately log in as the user needs to activate their account via email first. User will be send an email with a link to `activation_url` and the following GET parameters:

* `email` -- user's email to be used as a parameter to `activate`;
* `activation_token` -- user's activation token to be used as a parameter to `activate`. -->

#### Output Description

##### Registration was successful

```json
{
	"success": 1,
	"message": "user registered successfully",
	"user": {}
}
```

##### Registration has failed

```json
{
    "success": 0,
	"message": "something went wrong...try again"
}
```

#### Example

URL: <.../api/v1/register>

Input:

```json
{
    "email": "frknasir@yahoo.com",
	"password": "qwerty1",
	"password_confirmation": "qwerty1",
    "name": "Faruk Nasir"
}
```

Output:

```json
{
    "success": 1,
	"message": "user registered successfully",
	"user": {}
}
```