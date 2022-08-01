-- trigger to send notification when two users become friends
DELIMITER $$
CREATE TRIGGER send_is_friends_notif
AFTER INSERT
ON is_friends FOR EACH ROW
BEGIN
INSERT INTO notification (type_id, send_date, sender, reciever_id)
VALUES(4, CURDATE(), NEW.user1_id, NEW.user2_id),
(4, CURDATE(), NEW.user2_id, NEW.user1_id);
END $$
DELIMITER;

--trigger to send out notification when invited to activity
DELIMITER $$
CREATE TRIGGER send_invite_notif
AFTER INSERT
ON invitees FOR EACH ROW
BEGIN
INSERT INTO notification (type_id, send_date, sender, reciever_id)
VALUES(3, CURDATE(), NEW.plan_id, NEW.user_id);
END $$
DELIMITER;

--trigger to send out welcome notification to new users
DELIMITER $$
CREATE TRIGGER send_welcome_notif
AFTER INSERT
ON user FOR EACH ROW
BEGIN
INSERT INTO notification (type_id, send_date, sender, reciever_id)
VALUES(5, CURDATE(), NEW.google_id, NEW.google_id);
END $$
DELIMITER;