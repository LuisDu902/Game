# EAP: Architecture Specification and Prototype

## A7: Web Resources Specification

This artifact presents an overview of the web resources implemented in the vertical prototype, organized into modules. It also includes the permissions used in the modules to establish the conditions of access to resources.

### 1. Overview


| Identifier | Module         | Description                                                                                                                                                                                                                                                                                                                                              |
| ---------- | -------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| M01        | Authentication | Web resources associated with user authentication. Includes the following system features: login, registration and logout.                                                                                                                                                                                                                               |
| M02        | Users          | Web resources associated with users. Includes the following system features: view and search users, view and edit personal profile information.                                                                                                                                                                                                                   |
| M03        | Posts          | Web resources associated with posts - questions, answers and comments. Includes the following system features: list and search questions, view recent, top, and unanswered questions. Users can post questions, answers, or comments, edit their personal questions and answers, view question details, vote on posts, and delete questions and answers. |
| M04        | Games          | Web resources associated with games. Includes the following system features: view game categories and game details, list questions related to a specific game.                                                                                                                                                                                           |
| M05        | Administration | Web resources associated with user management, specifically the system feature to ban or unban user accounts.                                                                                                                                                                                                                                            |

### 2. Permissions

This section defines the permissions used in the modules to establish the conditions of access to resources.

| Identifier | Name         | Description                                           |
|------------|--------------|-------------------------------------------------------|
| GST        | Guest        | Unauthenticated users                                 |
| USR        | User         | Authenticated users                                   |
| OWN        | Owner        | Users who are owners of the information                |
| ADM        | Administrator| System administrators                                 |


### 3. OpenAPI Specification

This section includes the complete API specification in OpenAPI (YAML) for the vertical prototype (A8).

> Link to the `a7_openapi.yaml` file in the group's repository.

```yaml
openapi: 3.0.0
```

---

## A8: Vertical prototype

> Brief presentation of the artifact goals.

### 1. Implemented Features

#### 1.1. Implemented User Stories

> Identify the user stories that were implemented in the prototype.

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01                 | Name of the user story | Priority of the user story | Description of the user story |

...

#### 1.2. Implemented Web Resources

> Identify the web resources that were implemented in the prototype.

> Module M01: Module Name

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R01: Web resource name | URL to access the web resource |

...

> Module M02: Module Name

...

### 2. Prototype

> URL of the prototype plus user credentials necessary to test all features.  
> Link to the prototype source code in the group's git repository.

---

## Revision history

Changes made to the first submission:

1. Item 1
1. ..

---

GROUPYYgg, DD/MM/20YY

- Group member 1 name, email (Editor)
- Group member 2 name, email
- ...

Identifier
Module
Description
M01
Authentication

M02
Users

M03
Posts
Web resources associated with questions, including posting questions, editing questions, viewing question details, and related functionalities.
M06
Games
Web resources associated with games, potentially including game information, reviews, discussions, and related functionalities.  
M05
Administration
Web resources associated with administrative tasks, including user moderation, content management, analytics, and other administrative features.

Identifier
Name
Description
GST
Guest
Unauthenticated users
USR
User
Authenticated users
OWN
Owner
User that are owners of the information (e.g. own profile, own questions, own comments)
ADM
Administrator
System administrators
