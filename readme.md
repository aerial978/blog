# Project 5 OpenClassrooms - Create your first blog in PHP

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/8d5431b3fdef4d8a80e5a1ceee24302b)](https://www.codacy.com/gh/aerial978/blog/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=aerial978/blog&amp;utm_campaign=Badge_Grade)
[![blog](https://img.shields.io/badge/my_blog-000?style=for-the-badge&logo=ko-fi&logoColor=white)]()

Creation of a Web Developper Blog with an Object Oriented MVC structure PHP 8.



## Description

This responsive website consists of :

- useful pages for all visitors
- pages to administer the blog

The administration part is only accessible to registered (with confirmation email) and
validated.

## Setup

Development platform used : WampServer
The blog.sql file is located at the root of the project.
Enter the database connection information in the model/manager.php file.
Library CDN links : Bootstrap5, Jquery, Fontawesome, Google Fonts & SweetAlert modal
Test emails with Maildev (Node.js)

## Design

Inspired by freelancer theme from startbootstrap.com

## Pages

Frontend :
    - Homepage (hero, recents posts, about & contact form)
    - Posts list
    - Single post (included : comment form & comments list)
    - Sorting posts by user
    - Sorting posts by tag

Backend :
    - Dashboard
    - CRUD user
    - CRUD post
    - CRUD comment (read & delete only)
    - CRUD tag

    - Login form
    - Registration form
    - Forget password form
    - Reset password form

## Registration

The registration of an ADMIN or SUPERADMIN account includes a confirmation link sent by email.

## Login

SUPERADMIN :
    - username : bouboul3W?
    - password : mimil#4B

ADMIN : 
    - username : biloute9g@K
    - password : pasteq8%X

## Forget password

Password change required a confirmation link sent by email.

## User roles & privileges

VISITOR (not admin registered) : 

- access to front-end pages only
- access to the link to the CV and all the links to the social networks
- access to the contact form
- access to the comment form 

ADMIN (admin registered) :

- access to the same functionalities as the visitor

- BACKEND:
access to the functionalities of the blogspot (creation, update & deletion of HIS posts only),
access to his user account only (update and deletion).

The ADMIN role can not :
validate the publication of its new posts,
change their user role.

SUPERADMIN (registered administrator):

- access to the same functionalities as the visitor

- BACKEND:
access to all features, deletion of an ADMIN account as well

The SUPERADMIN role can not :
modify the content of an admin's post & comment






