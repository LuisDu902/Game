# EBD: Database Specification Component

## A4: Conceptual Data Model

This section contains the identification and description of the entities and relationships that exist to the GameOn project and its database specification.

### 1. Class diagram

> UML class diagram containing the classes, associations, multiplicity and roles.  
> For each class, the attributes, associations and constraints are included in the class diagram.

Figure 7: GameOn conceptual data model in UML

### 2. Additional Business Rules
 
Additional business rules and restrictions that cannot be conveyed in the UML class diagram of GameOn system.

| Identifier | Name                                  | Description                                                                                                                                              |
| ---------- | ------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------- |
| BR13       | Unique Association of Version_content | Version_content can be associated with either a question, a comment, or an answer at a time, but not with more than one of these classes simultaneously. |
| BR14       | Unique Association of Vote            | Vote can be associated with either a question or an answer at a time, but not with more than one of these classes simultaneously.                        |
| BR15       | Self-Reporting Prohibition            | A user cannot report themselves.                                                                                                                         |
| BR16       | Chronological Order of Post Elements  | The date of each question is always before its answers, comments and votes.                                                                              |
| BR17       | Single Vote Limitation                | A user can only vote on a question or answer once.                                                                                                       |
| BR18       | Self-Voting Prohibition               | A user cannot vote on its own questions or answers.                                                                                                      |
| BR19       | Private posts                         | A user cannot vote, answer nor comment on posts that are not public.                                                                                     |
| BR20       | Banned accounts                       | Users whose accounts are banned cannot vote, answer nor comment on any existing post.                                                                    |

Table 9: Additional Business Rules
---


## A5: Relational Schema, validation and schema refinement

This section contains the Relational Schema obtained from the Conceptual Data Model. 

The Relational Schema includes the relation schemas, attributes, domains, primary keys, foreign keys and other integrity rules: UNIQUE, DEFAULT, NOT NULL, CHECK.

### 1. Relational Schema

| Relation reference | Relation Compact Notation                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| ------------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| R01                | user(<ins>id</ins>, name **NN**, username **UK NN**, email **UK NN**, password **NN**, description, rank **NN DF** 'Bronze' **CK** rank **IN** Rank)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| R02                | admin(<ins>user_id</ins> -> user)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| R03                | banned(<ins>user_id</ins> -> user)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| R04                | badge(<ins>id</ins>, name **UK NN CK** name **IN** Badge_type)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| R05                | game_category(<ins>id</ins>, type **UK NN**, description **NN**)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| R06                | game(<ins>id</ins>, name **UK NN**, description **NN**, /nr_members **NN CK** nr_members >=0, game_category_id -> game_category)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| R07                | question(<ins>id</ins>, user_id -> user **NN**, create_date **NN CK** create_date <= Today, title **NN**, is_solved **NN DF** False, is_public **NN DF** True, nr_views **NN CK** nr_views >= 0, /votes **NN**, game_id -> game)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| R08                | comment(<ins>id</ins>, user_id -> user **NN**, answer_id -> answer **NN**, is_public **NN DF** True)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| R09                | answer(<ins>id</ins>, user_id -> user **NN**, question_id -> question **NN**, is_public **NN DF** True, top_asnwer **NN DF** False, /votes **NN**)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| R10                | vote(<ins>id</ins>, user_id -> user **NN**, date **NN CK** date <= Today, reaction **NN**, vote_type **NN CK** vote_type **IN** Vote_type, answer_id -> answer, question_id -> question,<br> **CK** ((vote_type = 'Question_vote' **AND** question_id **NN AND** answer_id **NULL**) <br> **OR** (vote_type = 'Answer_vote' **AND** answer_id **NN AND** question_id **NULL**)))                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| R11                | tag(<ins>id</ins>, name **UK NN**)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| R12                | version_content(<ins>id</ins>, date **NN CK** date <= Today, content **NN**, content_type **NN CK** content_type **IN** Content_type, question_id -> question, answer_id -> answer, comment_id -> comment, <br>**CK** ((content_type = 'Question_content' **AND** question_id **NN AND** answer_id **NULL AND** comment_id **NULL**) <br>**OR** (report_type = 'Answer_content' **AND** answer_id **NN AND** question_id **NULL AND** comment_id **NULL**), <br> **OR** (report_type = 'Comment_content' **AND** comment_id **NN AND** question_id **NULL AND** answer_id **NULL**)))                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
| R13                | report(<ins>id</ins>, date **NN CK** date <= Today, reason **NN**, is_solved **NN DF** False, reporter_id -> user **NN**, reported_id -> user **NN**, report_type **NN CK** report_type **IN** Report_type, question_id -> question, answer_id -> answer, comment_id -> comment,  <br> **CK** (reported_id <> reporter_id) **AND** ((report_type = 'Question_report' **AND** question_id **NN AND** answer_id **NULL AND** comment_id **NULL**) <br> **OR** (report_type = 'Answer_report' **AND** answer_id **NN AND** question_id **NULL AND** comment_id **NULL**), <br> **OR** (report_type = 'Comment_report' **AND** comment_id **NN AND** question_id **NULL AND** answer_id **NULL**)))                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| R14                | notification(<ins>id</ins>, date **NN CK** date <= Today, viewed **NN DF** False, user_id -> user **NN**, notification_type **NN CK** notification_type **IN** Notification_type, question_id -> question, answer_id -> answer, comment_id -> comment, vote_id -> vote, report_id -> report, badge_id -> badge, game_id -> game,<br> **CK** ((notification_type = 'Report_notification' **AND** report_id **NN AND** question_id **NULL AND** answer_id **NULL AND** comment_id **NULL AND** vote_id **NULL AND** bagde_id **NULL AND** game_id **NULL**)<br> **OR** (notification_type = 'Question_notification' **AND** question_id **NN AND** report_id **NULL AND** answer_id **NULL AND** comment_id **NULL AND** vote_id **NULL AND** bagde_id **NULL AND** game_id **NULL**)           <br> **OR** (notification_type = 'Answer_notification' **AND** answer_id **NN AND** report_id **NULL AND** question_id **NULL AND** comment_id **NULL AND** vote_id **NULL AND** bagde_id **NULL AND** game_id **NULL**)         <br> **OR** (notification_type = 'Comment_notification' **AND** comment_id **NN AND** report_id **NULL AND** answer_id **NULL AND** question_id **NULL AND** vote_id **NULL AND** bagde_id **NULL AND** game_id **NULL**)    <br> **OR** (notification_type = 'Vote_notification' **AND** vote_id **NN AND** report_id **NULL AND** answer_id **NULL AND** comment_id **NULL AND** question_id **NULL AND** bagde_id **NULL AND** game_id **NULL**)               <br> **OR** (notification_type = 'Rank_notification' **AND** question_id **NULL AND** report_id **NULL AND** answer_id **NULL AND** comment_id **NULL AND** vote_id **NULL AND** bagde_id **NULL AND** game_id **NULL**)                                                                                     <br> **OR** (notification_type = 'Badge_notification' **AND** badge_id **NN AND** question_id **NULL AND** report_id **NULL AND** answer_id **NULL AND** comment_id **NULL AND** vote_id **NULL AND** game_id **NULL**) <br> **OR** (notification_type = 'Game_notification' **AND** game_id **NN AND** question_id **NULL AND** report_id **NULL AND** answer_id **NULL AND** comment_id **NULL AND** vote_id **NULL AND** bagde_id **NULL**)               )) |
| R15                | user_badge(<ins>user_id</ins> -> user, <ins>badge_id</ins> -> badge)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| R16                | game_member(<ins>user_id</ins> -> user, <ins>game_id</ins> -> game)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| R17                | question_tag(<ins>question_id</ins> -> question, <ins>tag_id</ins> -> tag)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |  |

Table 10: GameOn Relational Schema

Legend:

- UK = UNIQUE;
- NN = NOT NULL;
- DF = DEFAULT;
- CK = CHECK;


### 2. Domains

Specification of additional domains:  

| Domain Name       | Domain Specification                                                                                                                                                                      |
| ----------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Today             | DATE DEFAULT CURRENT_DATE                                                                                                                                                                 |
| Rank              | ENUM ('Bronze', 'Gold', 'Master')                                                                                                                                                         |
| Badge_type        | ENUM ('Best_comment', 'Inquisitive_Pro', 'Well_Rounded', 'Diamond_Dog', 'Griefer')                                                                                                                                                              |
| Notification_type | ENUM ('Report_notification', 'Rank_notification', 'Badge_notification', 'Answer_notification', 'Question_notification', 'Comment_notification', 'Vote_notification', 'Game_notification') |
| Report_type       | ENUM ('Question_report', 'Answer_report', 'Comment_report')                                                                                                                               |
| Vote_type         | ENUM ('Question_vote', 'Answer_vote')                                                                                                                                                     |
| Content_type      | ENUM ('Question_content', 'Answer_content', 'Comment_content')                                                                                                                            |

Table 11: GameOn Domains

### 3. Schema validation

All functional dependencies are identified and the normalization of all relation schemas is accomplished.


| **TABLE R01**                | user                                                         |
| ---------------------------- | ------------------------------------------------------------ |
| **Keys**                     | { id }, { username }, { email }                              |
| **Functional Dependencies:** |                                                              |
| FD0101                       | id → { name, username, email, password, description, rank }  |
| FD0102                       | username →  { id, name, email, password, description, rank } |
| FD0103                       | email →  { id, name, username, password, description, rank } |
| **NORMAL FORM**              | BCNF                                                         |

Table 12: user schema validation

| **TABLE R02**                | admin       |
| ---------------------------- | ----------- |
| **Keys**                     | { user_id } |
| **Functional Dependencies:** | none        |
| **NORMAL FORM**              | BCNF        |

Table 13: admin schema validation

| **TABLE R03**                | banned      |
| ---------------------------- | ----------- |
| **Keys**                     | { user_id } |
| **Functional Dependencies:** | none        |
| **NORMAL FORM**              | BCNF        |

Table 14: banned schema validation

| **TABLE R04**                | badge            |
| ---------------------------- | ---------------- |
| **Keys**                     | { id }, { name } |
| **Functional Dependencies:** |                  |
| FD0301                       | id → { name }    |
| FD0302                       | name →  { id }   |
| **NORMAL FORM**              | BCNF             |

Table 15: badge schema validation

| **TABLE R05**                | game_category               |
| ---------------------------- | --------------------------- |
| **Keys**                     | { id }, { type }            |
| **Functional Dependencies:** |                             |
| FD0501                       | id → { type, description }  |
| FD0502                       | type →  { id, description } |
| **NORMAL FORM**              | BCNF                        |

Table 16: game_category schema validation

| **TABLE R06**                | game                                                      |
| ---------------------------- | --------------------------------------------------------- |
| **Keys**                     | { id }, { name }                                          |
| **Functional Dependencies:** |                                                           |
| FD0601                       | id → { name, description, nr_members, game_category_id }  |
| FD0602                       | name →  { id, description, nr_members, game_category_id } |
| **NORMAL FORM**              | BCNF                                                      |

Table 17: game schema validation

| **TABLE R07**                | question                                                                             |
| ---------------------------- | ------------------------------------------------------------------------------------ |
| **Keys**                     | { id }                                                                               |
| **Functional Dependencies:** |                                                                                      |
| FD0701                       | id → { user_id, create_date, title, is_solved, is_public, nr_views, votes, game_id } |
| **NORMAL FORM**              | BCNF                                                                                 |

Table 18: question schema validation

| **TABLE R08**                | comment                                |
| ---------------------------- | -------------------------------------- |
| **Keys**                     | { id }                                 |
| **Functional Dependencies:** |                                        |
| FD0801                       | id → { user_id, answer_id, is_public } |
| **NORMAL FORM**              | BCNF                                   |

Table 19: comment schema validation

| **TABLE R09**                | answer                                                      |
| ---------------------------- | ----------------------------------------------------------- |
| **Keys**                     | { id }                                                      |
| **Functional Dependencies:** |                                                             |
| FD0901                       | id → { user_id, question_id, is_public, top_answer, votes } |
| **NORMAL FORM**              | BCNF                                                        |

Table 20: answer schema validation

| **TABLE R10**                | vote                                                                            |
| ---------------------------- | ------------------------------------------------------------------------------- |
| **Keys**                     | { id }                                                                          |
| **Functional Dependencies:** |                                                                                 |
| FD1001                       | id → { user_id, date, reaction, vote_type, question_id, answer_id, comment_id } |
| **NORMAL FORM**              | BCNF                                                                            |

Table 21: vote schema validation


| **TABLE R11**                | tag              |
| ---------------------------- | ---------------- |
| **Keys**                     | { id }, { name } |
| **Functional Dependencies:** |                  |
| FD1101                       | id → { name }    |
| FD1101                       | name → { id }    |
| **NORMAL FORM**              | BCNF             |

Table 22: tag schema validation

| **TABLE R12**                | version_content                                                          |
| ---------------------------- | ------------------------------------------------------------------------ |
| **Keys**                     | { id }                                                                   |
| **Functional Dependencies:** |                                                                          |
| FD1201                       | id → { date, content, content_type, question_id, answer_id, comment_id } |
| **NORMAL FORM**              | BCNF                                                                     |

Table 23: version_content schema validation

| **TABLE R13**                | report                                                                                                      |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------- |
| **Keys**                     | { id }                                                                                                      |
| **Functional Dependencies:** |                                                                                                             |
| FD1301                       | id → { date, reason, is_solved, reporter_id, reported_id, report_type, question_id, answer_id, comment_id } |
| **NORMAL FORM**              | BCNF                                                                                                        |

Table 24: report schema validation

| **TABLE R14**                | notification                                                                                                                 |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| **Keys**                     | { id }                                                                                                                       |
| **Functional Dependencies:** |                                                                                                                              |
| FD1401                       | id → { date, viewed, user_id, notification_type, question_id, answer_id, comment_id, vote_id, report_id, badge_id, game_id } |
| **NORMAL FORM**              | BCNF                                                                                                                         |

Table 25: notification schema validation

| **TABLE R15**                | user_badge            |
| ---------------------------- | --------------------- |
| **Keys**                     | { user_id, badge_id } |
| **Functional Dependencies:** | none                  |
| **NORMAL FORM**              | BCNF                  |

Table 26: user_badge schema validation

| **TABLE R16**                | game_member          |
| ---------------------------- | -------------------- |
| **Keys**                     | { user_id, game_id } |
| **Functional Dependencies:** | none                 |
| **NORMAL FORM**              | BCNF                 |

Table 27: game_member schema validation

| **TABLE R17**                | question_tag            |
| ---------------------------- | ----------------------- |
| **Keys**                     | { question_id, tag_id } |
| **Functional Dependencies:** | none                    |
| **NORMAL FORM**              | BCNF                    |

Table 28: question_tag schema validation

Because all relations are in the Boyce–Codd Normal Form (BCNF), the relational schema is also in the BCNF and, therefore, the schema does not need to be further normalized.


---


## A6: Indexes, triggers, transactions and database population


### 1. Database Workload
 

| **Relation reference** | **Relation Name** | **Order of magnitude** | **Estimated growth** |
| ---------------------- | ----------------- | ---------------------- | -------------------- |
| R01                    | user              | 100 k                  | 100 / day            |
| R02                    | admin             | 100                    | 10 / year            |
| R03                    | banned            | 1 k                    | 10 / month           |
| R04                    | badge             | 10                     | no growth            |
| R05                    | game_category     | 100                    | 1 / month            |
| R06                    | game              | 1 k                    | 10 / month           |
| R07                    | question          | 1 M                    | 1 k / day            |
| R08                    | comment           | 100 k                  | 100 / day            |
| R09                    | answer            | 1 M                    | 1 k / day            |
| R10                    | vote              | 10 M                   | 1 k / day            |
| R11                    | tag               | 100                    | 1 / day              |
| R12                    | version_content   | 10 M                   | 1 k / day            |
| R13                    | report            | 10 k                   | 100 / week           |
| R14                    | notification      | 10 M                   | 10 k  / day          |
| R15                    | user_badge        | 100 k                  | 100 / day            |
| R16                    | game_member       | 100 k                  | 100 / day            |
| R17                    | question_tag      | 10 M                   | 1 k / day            |

Table 29: GameOn workload

### 2. Proposed Indices

#### 2.1. Performance Indices
 
Performance indexes are applied to improve the performance of select queries.

| **Index**         | IDX01                                                                                                                                                                                                                                                                                                                                          |
| ----------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Relation**      | question                                                                                                                                                                                                                                                                                                                                       |
| **Attribute**     | user_id                                                                                                                                                                                                                                                                                                                                        |
| **Type**          | Hash                                                                                                                                                                                                                                                                                                                                           |
| **Cardinality**   | medium                                                                                                                                                                                                                                                                                                                                         |
| **Clustering**    | no                                                                                                                                                                                                                                                                                                                                             |
| **Justification** | Table 'question' is very large. Several queries need to frequently filter access to the questions by its author (user). Filtering is done by exact match, thus an hash type index would be best suited. Considering the high update frequency, clustering the table is not proposed, as it would introduce additional overhead during updates. |
| **SQL Code**      | CREATE INDEX question_author ON question USING hash (user_id);                                                                                                                                                                                                                                                                                 |

Table 30: question_author index

| **Index**         | IDX02                                                                                                                                                                                                                                                                                                                                                                           |
| ----------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Relation**      | question                                                                                                                                                                                                                                                                                                                                                                        |
| **Attribute**     | create_date                                                                                                                                                                                                                                                                                                                                                                     |
| **Type**          | B-tree                                                                                                                                                                                                                                                                                                                                                                          |
| **Cardinality**   | medium                                                                                                                                                                                                                                                                                                                                                                          |
| **Clustering**    | no                                                                                                                                                                                                                                                                                                                                                                              |
| **Justification** | Table 'question' is frequently accessed based on the create date of each post. Implementing a B-tree index on the 'create_date' attribute enhances the efficiency of date range queries, optimizing the performance of these operations. Considering the high update frequency, clustering the table is not proposed, as it would introduce additional overhead during updates. |  |
| **SQL Code**      | CREATE INDEX question_post_date ON question USING btree (create_date);                                                                                                                                                                                                                                                                                                          |

Table 31: question_post_date index 

| **Index**         | IDX03                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| ----------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Relation**      | game                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
| **Attribute**     | nr_members                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| **Type**          | B-tree                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| **Cardinality**   | medium                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| **Clustering**    | no                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| **Justification** | Table 'game' is frequently accessed and displayed based on the number of members, making 'nr_members' a critical attribute for query performance. Creating a B-tree index on 'nr_members' enables efficient querying and sorting operations, especially when the application needs to display games ordered by the number of members. Considering the high update frequency, clustering the table is not proposed, as it would introduce additional overhead during updates. |
| **SQL Code**      | CREATE INDEX game_nr_members ON game USING btree (nr_members);                                                                                                                                                                                                                                                                                                                                                                                                               |
                                                                                                                                             Table 31: game_nr_members index                                               

#### 2.2. Full-text Search Indices 

To improve text search time, we created Full-Text Search (FTS) indexes on the tables and attributes we thought would be queried the most. Those indexes can be found in the following tables:  

<table>
  <tr>
    <th>Index</th>
    <th>IDX04</th>
  </tr>
  <tr>
    <td><b>Relation</b></td>
    <td>question</td>
  </tr>
  <tr>
    <td><b>Attribute</b></td>
    <td>title</td>
  </tr>
  <tr>
    <td><b>Type</b></td>
    <td>GIN</td>
  </tr>
  <tr>
    <td><b>Clustering</b></td>
    <td>No</td>
  </tr>
  <tr>
    <td><b>Justification</b></td>
    <td>To provide full-text search features to look for questions based on matching titles. The index type is GIN because the indexed fields are not expected to change often.</td>
  </tr>
  <tr>
    <td><b>SQL code</b></td>
    <td>
      <pre>
-- Add column to question to store computed ts_vectors.
ALTER TABLE question
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION question_search_update() RETURNS TRIGGER AS $$ 
BEGIN
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvectors = setweight(to_tsvector('english', NEW.title), 'A');
  END IF; 
  IF TG_OP = 'UPDATE' THEN 
    IF (NEW.title <> OLD.title) THEN 
      NEW.tsvectors = setweight(to_tsvector('english', NEW.title), 'A');
    END IF;
  END IF;
  RETURN NEW;
END $$ LANGUAGE plpgsql;

-- Create a trigger before insert or update on question.
CREATE TRIGGER question_search_update 
BEFORE INSERT OR UPDATE ON question 
FOR EACH ROW 
EXECUTE PROCEDURE question_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_question ON question USING GIN (tsvectors);
      </pre>
    </td>
  </tr>
</table>

Table 32: search_question index 


<table>
  <tr>
    <th>Index</th>
    <th>IDX05</th>
  </tr>
  <tr>
    <td><b>Relation</b></td>
    <td>version_content</td>
  </tr>
  <tr>
    <td><b>Attribute</b></td>
    <td>content</td>
  </tr>
  <tr>
    <td><b>Type</b></td>
    <td>GIN</td>
  </tr>
  <tr>
    <td><b>Clustering</b></td>
    <td>No</td>
  </tr>
  <tr>
    <td><b>Justification</b></td>
    <td>To provide full-text search features to look for all types of posts on matching content. The index type is GIN because the indexed fields are not expected to change often.</td>
  </tr>
  <tr>
    <td><b>SQL code</b></td>
    <td>
      <pre>
-- Add column to content to store computed ts_vectors.
ALTER TABLE content
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION content_search_update() RETURNS TRIGGER AS $$ 
BEGIN
  IF TG_OP = 'INSERT' THEN 
    NEW.tsvectors = setweight(to_tsvector('english', NEW.content), 'A');
  END IF; 
  IF TG_OP = 'UPDATE' THEN 
    IF (NEW.title <> OLD.title) THEN 
      NEW.tsvectors = setweight(to_tsvector('english', NEW.content), 'A');
    END IF;
  END IF;
  RETURN NEW;
END $$ LANGUAGE plpgsql;

-- Create a trigger before insert or update on content.
CREATE TRIGGER content_search_update 
BEFORE INSERT OR UPDATE ON content 
FOR EACH ROW 
EXECUTE PROCEDURE content_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_content ON content USING GIN (tsvectors);
      </pre>
    </td>
  </tr>
</table>

Table 33: search_content index 

<table>
  <tr>
    <th>Index</th>
    <th>IDX06</th>
  </tr>
  <tr>
    <td><b>Relation</b></td>
    <td>game</td>
  </tr>
  <tr>
    <td><b>Attribute</b></td>
    <td>name, description</td>
  </tr>
  <tr>
    <td><b>Type</b></td>
    <td>GIN</td>
  </tr>
  <tr>
    <td><b>Clustering</b></td>
    <td>No</td>
  </tr>
  <tr>
    <td><b>Justification</b></td>
    <td>To provide full-text search features to look for games based on matching names or descriptions. The index type is GIN because the indexed fields are not expected to change often.</td>
  </tr>
  <tr>
    <td><b>SQL code</b></td>
    <td>
      <pre>

-- Add column to game to store computed ts_vectors.
ALTER TABLE game
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION game_search_update() RETURNS TRIGGER AS $$ BEGIN IF TG_OP = 'INSERT' THEN NEW.tsvectors = (
    setweight(to_tsvector('english', NEW.name), 'A') || setweight(to_tsvector('english', NEW.description), 'B')
);

END IF;

IF TG_OP = 'UPDATE' THEN IF (
    NEW.name <> OLD.name
    OR NEW.description <> OLD.description
) THEN NEW.tsvectors = (
    setweight(to_tsvector('english', NEW.name), 'A') || setweight(to_tsvector('english', NEW.description), 'B')
);

END IF;

END IF;

RETURN NEW;

END $$ LANGUAGE plpgsql;

-- Create a trigger before insert or update on game.
CREATE TRIGGER game_search_update BEFORE
INSERT
    OR
UPDATE
    ON game FOR EACH ROW EXECUTE PROCEDURE game_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_game ON game USING GIN (tsvectors);
      </pre>
    </td>
  </tr>
</table>

Table 34: search_game index 


<table>
  <tr>
    <th>Index</th>
    <th>IDX07</th>
  </tr>
  <tr>
    <td><b>Relation</b></td>
    <td>user</td>
  </tr>
  <tr>
    <td><b>Attribute</b></td>
    <td>description</td>
  </tr>
  <tr>
    <td><b>Type</b></td>
    <td>GIN</td>
  </tr>
  <tr>
    <td><b>Clustering</b></td>
    <td>No</td>
  </tr>
  <tr>
    <td><b>Justification</b></td>
    <td>To provide full-text search features to look for users based on matching descriptions. The index type is GIN because the indexed field is not expected to change often.</td>
  </tr>
  <tr>
    <td><b>SQL code</b></td>
    <td>
      <pre>
-- Add column to "user" to store computed ts_vectors.
ALTER TABLE "user"
ADD COLUMN tsvectors TSVECTOR;

-- Create a function to automatically update ts_vectors.
CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$ BEGIN IF TG_OP = 'INSERT' THEN NEW.tsvectors = setweight(to_tsvector('english', NEW.description), 'A');

END IF;

IF TG_OP = 'UPDATE' THEN IF (
    NEW.description <> OLD.description
) THEN NEW.tsvectors = setweight(to_tsvector('english', NEW.description), 'A');

END IF;

END IF;

RETURN NEW;

END $$ LANGUAGE plpgsql;

-- Create a trigger before insert or update on "user".
CREATE TRIGGER user_search_update BEFORE
INSERT
    OR
UPDATE
    ON "user" FOR EACH ROW EXECUTE PROCEDURE user_search_update();

-- Finally, create a GIN index for ts_vectors.
CREATE INDEX search_user ON "user" USING GIN (tsvectors);
      </pre>
    </td>
  </tr>
</table>

Table 35: search_user index 


### 3. Triggers
 
> User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.  

| **Trigger**     | TRIGGER01                                                               |
| --------------- | ----------------------------------------------------------------------- |
| **Description** | Trigger description, including reference to the business rules involved |
| `SQL code`      |                                                                         |

Table 35: search_user index audiaiakhasddakdkdadkhkXIAJKDJKAJKSJDKAKJLDAKLAD

### 4. Transactions
 
> Transactions needed to assure the integrity of the data.  

| SQL Reference       | Transaction Name                    |
| ------------------- | ----------------------------------- |
| Justification       | Justification for the transaction.  |
| Isolation level     | Isolation level of the transaction. |
| `Complete SQL Code` |                                     |

Table 35: search_user index audiaiakhasddakdkdadkhkXIAJKDJKAJKSJDKAKJLDAKLAD

## Annex A. SQL Code

> The database scripts are included in this annex to the EBD component.
> 
> The database creation script and the population script should be presented as separate elements.
> The creation script includes the code necessary to build (and rebuild) the database.
> The population script includes an amount of tuples suitable for testing and with plausible values for the fields of the database.
>
> The complete code of each script must be included in the group's git repository and links added here.

### A.1. Database schema

> The complete database creation must be included here and also as a script in the repository.

### A.2. Database population

> Only a sample of the database population script may be included here, e.g. the first 10 lines. The full script must be available in the repository.

---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUPYYgg, DD/MM/20YY
 
* Group member 1 name, email (Editor)
* Group member 2 name, email
* ...