Table of Contents
=================

  * [Creating a post](#create-post)
  * [Post General Settings](#post-settings)
  * [SEO Seetings](#post-seo-settings)
  * [Upload Featured Image](#featured-image-upload)
  * [Updating a post](#update-post)
  * [Deleting a post](#delete-post)
  * [Approving a post](#approve-post)
  * [Publishing a post](#publish-post)
   
  &nbsp;
## Creating a post <a id="create-post"></a>

You feel inspired. You want to share something sparkly with the world. Follow the instructions on how to create a blog post.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/create`      | create post. |

&nbsp;
### Required permission

`create_post`.

&nbsp;

## Steps

&nbsp;

1. Login with your credentials. You will be taken to the home page.

![Login Page](../../master/public/images/docs/how-tos/login_page.png)

2. On the navigation bar, from the account dropdown on the top right corner, click `administration`

![Home page](../../master/public/images/docs/how-tos/home_page.png)

3. From the sidebar, under `posts` dropdown, click `posts`. You will be taken to a page displaying all the published posts.

![Posts Page](../../master/public/images/docs/how-tos/posts_page.png)

4. Click on the `New post` button at the top right corner the page. You will be taken to the page to write the post.

![Write Post](../../master/public/images/docs/how-tos/write_post.png)

4. Just under the `Submit for approval` button, there is an ellipsis icon. Click it for `General settings`, `Featured image` upload, `SEO settings` and `Delete` options.

![Post Options](../../master/public/images/docs/how-tos/post_options.png)

5. When you create a `post`, it is saved as draft. After writing your story, you have to click the `Submit for approval` button so that a user with `approve_post` permission can approve your post. After that, either you or the `approving user` can publish it.

&nbsp;

## Post Settings <a id="post-settings"></a>

Edit a post `slug`, `description`, `topics` and `tags`.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/create`  | create post. |
| `/admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`create_post` | `update_post`.

&nbsp;

## Steps

&nbsp;

1. Just under the `Submit for approval` button, there is an ellipsis icon. Click it and a dropdown with `General settings`, `Featured image` upload, `SEO settings` and `Delete` options will appear.

![Post Options](../../master/public/images/docs/how-tos/post_options.png)

2. Click on `General settings`. A modal will appear for you to enter 

![General Settings](../../master/public/images/docs/how-tos/general_settings.png)

3. Make the necessary changes and click `Done`


## Featured Image Upload <a id="featured-image-upload"></a>

Upload featured image for your post.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/create`  | create post. |
| `admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`create_post` | `update_post`.

&nbsp;

## Steps

&nbsp;

1. Just under the `Submit for approval` button, there is an ellipsis icon. Click it and a dropdown with `General settings`, `Featured image` upload, `SEO settings` and `Delete` options will appear.

![Post Options](../../master/public/images/docs/how-tos/post_options.png)

2. Click on `Featured Image`. A modal will appear for you to select an image to upload 

![Post SEO Settings](../../master/public/images/docs/how-tos/featured_image.png)

3. Select an image and click `Done`



## Post SEO Settings <a id="post-seo-settings"></a>

Edit `Meta title`, `Meta description` and canonical link.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/create`  | create post. |
| `admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`create_post` | `update_post`.

&nbsp;

## Steps

&nbsp;

1. Just under the `Submit for approval` button, there is an ellipsis icon. Click it and a dropdown with `General settings`, `Featured image` upload, `SEO settings` and `Delete` options will appear.

![Post Options](../../master/public/images/docs/how-tos/post_options.png)

2. Click on `SEO settings`. A modal will appear for you to enter 

![Post SEO Settings](../../master/public/images/docs/how-tos/post_seo_settings.png)

3. Make the necessary changes and click `Done`

## Featured Image Upload <a id="featured-image-upload"></a>


## Updating a post <a id="update-post"></a>

Only draft posts can be updated. Once a post has been submitted for approval, it is no longer editable. To edit it, you have to convert it to a draft.

&nbsp;

### `admin/posts/:id/edit` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`update_post`.

&nbsp;

## Steps to convert a post to a draft

&nbsp;

1. On the top right corner, there is an ellipsis icon. Click it and a dropdown with `convert to draft` option will appear.

## Delete Post <a id="delete-post"></a>

Delete a post.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/create`  | create post. |
| `/admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`delete_post`

&nbsp;

## Steps

&nbsp;

1. On the top right corner, there is an ellipsis icon. Click it and a dropdown with `Delete` option will appear.

![Post Options](../../master/public/images/docs/how-tos/delete_post.png)

2. Click `Delete`. A modal will appear asking for your confirmation. 


## Approve Post <a id="approve-post"></a>

Approve a post.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`approve_post`

&nbsp;

## Steps

&nbsp;

1. On the top right corner, there is an `Approve post` button. Click it.

![Post Options](../../master/public/images/docs/how-tos/approve_post.png)

2. A modal will appear asking for your confirmation. 


## Publish Post <a id="publish-post"></a>

Publish a post.

&nbsp;

### `/admin/posts` (URL)
&nbsp;

| URL                    | Function             |
| ---------------------- | -------------------- |
| `/admin/posts/:id/edit` | edit post|

&nbsp;
### Required permission

`publish_post`

&nbsp;

## Steps

&nbsp;

1. On the top right corner, there is an `Publish post` button. Click it.

![Post Options](../../master/public/images/docs/how-tos/publish_post.png)

2. A modal will appear asking for your confirmation. 