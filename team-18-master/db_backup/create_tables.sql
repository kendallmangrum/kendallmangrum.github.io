DROP TABLE user;
DROP TABLE is_friends;
DROP TABLE activity;
DROP TABLE likes;
DROP TABLE category;
DROP TABLE user_categories;
DROP TABLE activity_categories;
DROP TABLE friend_group;
DROP TABLE is_member;
DROP TABLE planned_activity;
DROP TABLE invitees;
DROP TABLE notification_type;
DROP TABLE notification;


CREATE TABLE user
(
google_id VARCHAR(255) NOT NULL,
email VARCHAR(80) NOT NULL,
first_name VARCHAR(25) NOT NULL,
last_name VARCHAR(25) NOT NULL,
username VARCHAR(20) NOT NULL,
zip VARCHAR(5),
profile_picture VARCHAR(300) NOT NULL,
bio VARCHAR(300),
PRIMARY KEY (google_id),
UNIQUE (username)
)
engine=innodb;

CREATE TABLE is_friends
(
user1_id VARCHAR(255) NOT NULL,
user2_id VARCHAR(255) NOT NULL,
FOREIGN KEY (user1_id) REFERENCES user (google_id),
FOREIGN KEY (user2_id) REFERENCES user (google_id)
)
engine=innodb;

CREATE TABLE activity
(
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(25) NOT NULL,
description VARCHAR(1000) NOT NULL,
creator_id VARCHAR(255) NOT NULL,
open_time TIME,
close_time TIME,
price INT,
street1 VARCHAR(25),
street2 VARCHAR(25),
city VARCHAR(25),
state CHAR(2),
zip VARCHAR(5),
max_participants INT,
image VARCHAR(255),
about_url VARCHAR(255),
CHECK (price >= 1 AND price <= 5),
PRIMARY KEY (id),
FOREIGN KEY (creator_id) REFERENCES user (google_id)
)
engine=innodb;
ALTER TABLE activity
MODIFY COLUMN name VARCHAR(50);
ALTER TABLE activity
MODIFY COLUMN street1 VARCHAR(50);
ALTER TABLE activity
MODIFY COLUMN street2 VARCHAR(50);

CREATE TABLE likes
(
user_id VARCHAR(255) NOT NULL,
activity_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES user (google_id),
FOREIGN KEY (activity_id) REFERENCES activity (id)
)
engine=innodb;
ALTER TABLE likes
ADD CONSTRAINT like_once UNIQUE (user_id, activity_id);

CREATE TABLE category
(
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(25) NOT NULL,
PRIMARY KEY (id)
)
engine=innodb;

CREATE TABLE user_categories
(
user_id VARCHAR(255) NOT NULL,
category_id INT NOT NULL,
FOREIGN KEY (user_id) REFERENCES user (google_id),
FOREIGN KEY (category_id) REFERENCES category (id)
)
engine=innodb;
ALTER TABLE user_categories
ADD CONSTRAINT user_cat_once UNIQUE (user_id, category_id);

CREATE TABLE activity_categories
(
activity_id INT NOT NULL,
category_id INT NOT NULL,
FOREIGN KEY (activity_id) REFERENCES activity (id),
FOREIGN KEY (category_id) REFERENCES category (id)
)
engine=innodb;
ALTER TABLE activity_categories
ADD CONSTRAINT cat_once UNIQUE (activity_id, category_id);

CREATE TABLE friend_group
(
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(25) NOT NULL,
description VARCHAR(300),
PRIMARY KEY (id)
)
engine=innodb;

CREATE TABLE is_member
(
group_id INT NOT NULL,
user_id VARCHAR(255) NOT NULL,
FOREIGN KEY (group_id) REFERENCES friend_group (id),
FOREIGN KEY (user_id) REFERENCES user (google_id)
)
engine=innodb;
ALTER TABLE is_member
ADD CONSTRAINT member_once UNIQUE (group_id,user_id);

CREATE TABLE planned_activity
(
id INT NOT NULL AUTO_INCREMENT,
activity_id INT NOT NULL,
date DATE NOT NULL,
time TIME NOT NULL,
note VARCHAR(1000),
creator_id VARCHAR(255) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (activity_id) REFERENCES activity (id),
FOREIGN KEY (creator_id) REFERENCES user (google_id)
)
engine=innodb;

CREATE TABLE invitees
(
plan_id INT NOT NULL,
user_id VARCHAR(255) NOT NULL,
accepted BOOLEAN NOT NULL DEFAULT 0,
attended BOOLEAN NOT NULL DEFAULT 0,
FOREIGN KEY (plan_id) REFERENCES planned_activity (id),
FOREIGN KEY (user_id) REFERENCES user (google_id)
)
engine=innodb;
ALTER TABLE invitees
MODIFY accepted BOOLEAN NULL;
ALTER TABLE invitees
MODIFY attended BOOLEAN NULL;
ALTER TABLE invitees
ADD CONSTRAINT one_invite_only UNIQUE (plan_id,user_id);

CREATE TABLE notification_type
(
id INT NOT NULL AUTO_INCREMENT,
description VARCHAR(1000) NOT NULL,
sender_type VARCHAR(15) NOT NULL,
message VARCHAR(300) NOT NULL,
has_confirmation_req BOOLEAN NOT NULL,
has_time_req BOOLEAN NOT NULL,
PRIMARY KEY (id)
)
engine=innodb;

CREATE TABLE notification
(
id INT NOT NULL AUTO_INCREMENT,
type_id INT NOT NULL,
send_date DATE,
sender VARCHAR(255) NOT NULL,
reciever_id VARCHAR(255) NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (type_id) REFERENCES notification_type (id),
FOREIGN KEY (reciever_id) REFERENCES user (google_id)
)
engine=innodb;