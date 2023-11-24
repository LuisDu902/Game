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

This artifact is about the vertical prototype of the project. It includes the implementation of the high priority user stories and also the web resources.

### 1. Implemented Features

#### 1.1. Implemented User Stories

The user stories that were implemented in the prototype are described in the following table.

| User Story reference | Name                   | Priority                   | Description                   |
| -------------------- | ---------------------- | -------------------------- | ----------------------------- |
| US01                 | See home page | High | As a User, I want to have access to a homepage, so that I can understand what the application is about. |
| US02 | View posted Q&A's | High | As a User, I want to view the questions and answers posted by other members so that I can learn from their experiences and knowledge. |
| US03 | Exact match search | High | As a User, I want an exact match search so that I can quickly find specific posts. |
| US04 | View top questions | High | As a User, I want to be able to view the top questions, so that I can have easy access to the most popular questions. |
| US05 | Browse questions | High | As a User, I want to browse questions easily so that I can discover a variety of topics related to games and expand my knowledge. |
| US06 | Full-text search | High | As a User, I want a full-text search functionality so that I can find information across all aspects of questions and answers. |
| US07 | Search filters | High | As a User, I want to use search filters based on keywords so that I can narrow down my search results and quickly find specific information about games. |
| US09 | View recent questions | High | As a User, I want to be able to view recently made questions, so that I can easily stay updated on the latest discussions. |
| US13 | Order seach results | High | As a User, I want to be able to sort the search results using different filters so that I can find what I want easily. |
| US14 | View question details | High | As a User, I want to be able to view question details, so that I can have a deeper knowledge about a question. |
| US15 | View user profiles | High | As a User, I want to view user profiles, so that I can see information about that user |
| US16 | Placeholders in Form Inputs | High | As a User, I want placeholders in form inputs so that I can clearly understand what information is expected in each field. |
| US19 | Sign-up | High | As a Guest, I want the option to create an account easily, so that I can become an active participant in the future. |
| US20 | Sign-in | High | As a Guest, I want to be able to authenticate into the system, so that I can post my own questions and answers. |
| US23 | Logout | High | As a User, I want to be able to sign out of my account. |
| US24 | View my profile | High | As a User, I want to be able to view my user profile so that I can keep it updated. |
| US25 | View my questions | High | As a User, I want to see my questions, so that I can easily track what I have been asking. |
| US26 | View my answers | High | As a User, I want to be able to view my answers, so that I can easily track my posts contribution. |
| US27 | Post questions | High | As a User, I want to post a question, so that I can seek guidance or information from the gaming community. |
| US28 | Post answers | High | As a User, I want to provide answers to questions asked by others, so that I can share my knowledge and help fellow gamers. |
| US29 | Edit question | High | As a User, I want to be able to edit my questions, so that I can correct mistakes or remove outdated information. |
| US30 | Edit answer | High | As a User, I want to be able to edit my answers so that I can revise and enhance my responses based on new information or feedback. |
| US31 | Delete question | High | As a User, I want to be able to delete questions, so that I can have control over the content I have posted. |
| US32 | Delete answer | High | As a user, I want to be able to delete answers, so that I can have control over the content I have contributed. |
| US33 | Edit profile | High | As a User, I want to change profile information, so that I can keep it updated and relevant. |
| US34 | Vote on post | High | As a User, I want to upvote or downvote questions and answers, so that I can show my appreciation or my concerns for content and contribute to its visibility on the platform. |
| US35 | Comment on post | High | As a User, I want to be able to comment on questions and answers, so that I can engage in discussions and seek clarification. |
| US53 | Block and unblock user accounts | High | As an administrator, I want to be able to block user accounts so that I can maintain a safe and respectful community environment. |


#### 1.2. Implemented Web Resources

The web resources that were implemented in the prototype are described in the next section.

<b>Module M01: Authentication</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | /login |
| R102: Login Action | /login |
| R103: Logout Action | /logout |
| R104: Register Form | /register |
| R105: Register Action | /register |


<b>Module M02: Static pages</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | /login |

<b>Module M03: Users</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: Profile page of a user | /users/{id} |
| R202: User edit page | /api/users/{id}/edit |
| R203: See list of all users | /users |
| R204: Question of a user | /users/questions/{id} |
| R205: Answers of a user | /users/answers/{id} |
| R206: Search for a user | /api/users |
| R207:  | /api/users/{id} |


<b>Module M02: Questions</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: Profile page of a user | /users/{id} |
| R202: User edit page | /api/users/{id}/edit |
| R203: See list of all users | /users |
| R204: Question of a user | /users/questions/{id} |
| R205: Answers of a user | /users/answers/{id} |
| R206: Search for a user | /api/users |
| R207:  | /api/users/{id} |

<b>Module M02: GameCategory</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: Profile page of a user | /users/{id} |
| R202: User edit page | /api/users/{id}/edit |
| R203: See list of all users | /users |
| R204: Question of a user | /users/questions/{id} |
| R205: Answers of a user | /users/answers/{id} |
| R206: Search for a user | /api/users |
| R207:  | /api/users/{id} |

<b>Module M02: Game</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: Profile page of a user | /users/{id} |
| R202: User edit page | /api/users/{id}/edit |
| R203: See list of all users | /users |
| R204: Question of a user | /users/questions/{id} |
| R205: Answers of a user | /users/answers/{id} |
| R206: Search for a user | /api/users |
| R207:  | /api/users/{id} |

<b>Module M02: Answer</b>

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: Profile page of a user | /users/{id} |
| R202: User edit page | /api/users/{id}/edit |
| R203: See list of all users | /users |
| R204: Question of a user | /users/questions/{id} |
| R205: Answers of a user | /users/answers/{id} |
| R206: Search for a user | /api/users |
| R207:  | /api/users/{id} |

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
