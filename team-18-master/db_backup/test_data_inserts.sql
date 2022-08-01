INSERT INTO user(google_id, email, first_name, last_name, username, zip, profile_picture, bio)
VALUES('100233765235755679450', 'johndoe@gmail.com', 'John', 'Doe', 'johndoe', 46176, 'https://t4.ftcdn.net/jpg/03/46/93/61/360_F_346936114_RaxE6OQogebgAWTalE1myseY1Hbb5qPM.jpg', 'Hello there!'),
('100233765235755679451', 'janedoe@gmail.com', 'Jane', 'Doe', 'janedoe', 47401, 'https://moonvillageassociation.org/wp-content/uploads/2018/06/default-profile-picture1.jpg', 'Hi there!'),
('100233765235755679452', 'bobsmith@gmail.com', 'Bob', 'Smith', 'bobsmith', 47402, 'https://st.depositphotos.com/2101611/3925/v/600/depositphotos_39258143-stock-illustration-businessman-avatar-profile-picture.jpg', 'Just a simple man.'), 
('100233765235755679454', 'jillsmith@gmail.com', 'Jill', 'Smith', 'jillsmith' 46166, 'https://afmnoco.com/wp-content/uploads/2019/07/74046195_s.jpg', 'A girl looking for fun activities.'),
('100233765235755679455', 'mikebrown@gmail.com', 'Mike', 'Brown', 'mikebrown', 47448, 'https://st3.depositphotos.com/13159112/17145/v/600/depositphotos_171453724-stock-illustration-default-avatar-profile-icon-grey.jpg', 'A boring man trying to participate in fun activities.');


INSERT INTO is_friends(user1_id, user2_id)
VALUES('100233765235755679450', '100233765235755679451'),
('100233765235755679452', '100233765235755679454'),
('100233765235755679451', '100233765235755679454'),
('100233765235755679450', '100233765235755679452');


INSERT INTO activity(name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants, image, about_url)
VALUES('Bowling', 'Play a game of bowling at the Indiana Memorial Union', '100233765235755679450', '13:00:00', '23:00:00', 7, '900 E 7th St', '', 'Bloomington', 'IN', 47405, 8, 'https://pbs.twimg.com/media/DXTW2LqXUAIrupO.jpg', 'https://imu.indiana.edu/activities/bowling-billiards/index.html'),
('Billiards', 'Play a game of billiards (pool) at the Indiana Memorial Union', '100233765235755679450', '13:00:00', '23:00:00', 6, '900 E 7th St', '', 'Bloomington', 'IN', 47405, 2, 'https://imu.indiana.edu/images/social/bowling-billards.jpg', 'https://imu.indiana.edu/activities/bowling-billiards/index.html'),
('Rock Climbing', 'Indoor Rock Climbing with a variety of walls to climb at Hoosier heights', '100233765235755679450', '10:00:00', '22:00:00', 25, '1008 S. Rogers St', '', 'Bloomington', 'IN', 47403, 50, 'https://images.squarespace-cdn.com/content/v1/57d183a9c534a562b13ffd5a/1575397741875-EP3CWNK1TKJJX0LZ69MQ/ke17ZwdGBToddI8pDm48kLkXF2pIyv_F2eUT9F60jBl7gQa3H78H3Y0txjaiv_0fDoOvxcdMmMKkDsyUqMSsMWxHk725yiiHCCLfrh8O1z4YTzHvnKhyp6Da-NYroOW3ZGjoBKy3azqku80C789l0iyqMbMesKd95J-X4EagrgU9L3Sa3U8cogeb0tjXbfawd0urKshkc5MgdBeJmALQKw/Loren+Wood+Builders-35.jpg?format=1500w', 'https://www.hoosierheightsbloomington.com/'),
('Ice Skating', 'Open ice skating for people of all ages', '100233765235755679450', '12:00:00', '21:00:00', 10, '2100 S Henderson', '', 'Bloomington', 'IN', 47401, 50, 'https://assets.simpleviewinc.com/simpleview/image/upload/crm/bloomington/Edited-380-ba35b92b5056a36_ba35bb3b-5056-a36a-06412a4e5f4bb618.jpg', 'https://bloomington.in.gov/parks/facilities/frank-southern'),
('Roller Skating', 'Open roller skating for people of all ages', '100233765235755679451', '11:00:00', '22:00:00', 9, '930 W 17th St', 'Bloomington', 'IN', 47404, 60, 'https://assets.simpleviewinc.com/simpleview/image/upload/crm/bloomington/WesternSkateland_44040141-5056-a36a-0676190513460c1a.jpg', 'http://www.westernskateland.com/'),
('Laser Tag', 'Play games of laser tag and arcade games at LaserLite', '100233765235755679451', '11:00:00', '23:00:00', 8, '4505 E 3rd St', 'Bloomington', 'IN', 47401, 15, 'https://images.squarespace-cdn.com/content/v1/5a0a3397d0e628c973ac0efd/1511641156429-UFYO4572NT45DZU8BL6W/ke17ZwdGBToddI8pDm48kD33KhhWEodMJvcytjXFyvFZw-zPPgdn4jUwVcJE1ZvWQUxwkmyExglNqGp0IvTJZamWLI2zvYWH8K3-s_4yszcp2ryTI0HqTOaaUohrI8PIXZi3p8TzzCd5LBww9rBU5Je7LlmHzK_8BCOYYXjEaPwKMshLAGzx4R3EDFOm1kBS/12565620_10153878309034146_1479413187819784775_n.jpg', 'https://www.lasertagandfun.com/'),
('Farmers Market', 'Come browse a wide selection of locally growth foods and handcrafted items', '100233765235755679451', '8:00:00', '13:00:00', 0, '401 N Morton St', '', 'Bloomington', 'IN', 47404, 80, 'https://assets.simpleviewinc.com/simpleview/image/fetch/c_fill,h_800,q_75,w_1200/http://res.cloudinary.com/simpleview/image/upload/v1522252101/clients/bloomington/FarmersMarket_Sept17_70_688260a9-224c-4bcc-9d14-8418af852144.jpg', 'https://bloomington.in.gov/farmers-market'),
('Hiking', 'Hike a variety of trails at Griffy Lake', '100233765235755679451', '05:00:00', '24:00:00', 0, '3595 N Headley Rd', '', 'Bloomington', 'IN', 47408, 100, 'https://assets.simpleviewinc.com/simpleview/image/upload/crm/bloomington/BtownFall_10.21.15-140-2fc22f095056a36_2fc2319f-5056-a36a-06f12fc579d32f65.jpg', 'https://bloomington.in.gov/parks/parks/griffy-lake/amenities'),
('Comedy Attic', 'Enjoy listening to several local comedians do stand up comedy', '100233765235755679452', '19:00:00', '23:00:00', 15, '123 S Walnut St', '', 'Bloomington', 'IN', 47408, 6, 'https://s3.amazonaws.com/seat-engine-files-production/styles/logos/206/original/comein1.jpg?1463329037', 'https://www.comedyattic.com/'),
('Boating', 'Spend a day out on the lake by renting one of our boats including pontoons and ski boats', '100233765235755679452', '08:00:00', '20:00:00', 400, '4855 S State Rd 446', 'Bloomington', 'IN', 47401, 8, 'https://www.lakemonroemarina.com/Super%208-22-07%20007.jpg', 'https://www.lakemonroeboatrental.com/'),
('Concert', 'Listen to live music at The Bluebird', '100233765235755679452', '21:00:00', '01:00:00', 10, '216 N Walnut St', '', 'Bloomington', 'IN', '47404', 5, 'https://assets.simpleviewinc.com/simpleview/image/upload/crm/bloomington/BluebirdNightclub_446cdeb0-5056-a36a-068d5cc77d900136.jpg', 'https://www.thebluebird.ws/'),
('Petting Zoo', 'Hand feed and pet animals at ZooOpolis', '100233765235755679454','11:00:00', '16:00:00', 15, '5718 State Road 46 W', 'Nashville', 'IN', 47448, 15, 'https://dehayf5mhw1h7.cloudfront.net/wp-content/uploads/sites/1317/2020/05/13123431/Zoopolis-photo.png', 'https://zoo-opolisexoticpettingworld.com/'),
('Dancing', 'Enjoy live music including country, ballroom, and oldies and have a dance', '100233765235755679454', '18:00:00', '23:00:00', 12, '2277 West State Road 46', 'Nashville', 'IN', 47448, 20, 'https://19aznq47tjgc24ewn3215ef2-wpengine.netdna-ssl.com/wp-content/uploads/2018/08/MikesDanceBarn-Dancing-544x360.jpg', 'https://www.browncounty.com/listings/mikes-music-dance-barn/');


INSERT INTO likes(user_id, activity_id)
VALUES('100233765235755679450', 6),
('100233765235755679450', 8),
('100233765235755679451', 4),
('100233765235755679451', 5),
('100233765235755679452', 3),
('100233765235755679452', 10),
('100233765235755679454', 13)
('100233765235755679455', 9);


INSERT INTO category(name)
VALUES('Music'),
('Sports'),
('Food'),
('Nature'),
('Outdoors'),
('Shopping'),
('Recreation'),
('Religious'),
('Shows'),
('Movies');


INSERT INTO user_categories(user_id, category_id)
VALUES('100233765235755679450', 2),
('100233765235755679450', 3),
('100233765235755679450', 5),
('100233765235755679451', 1),
('100233765235755679451', 6),
('100233765235755679451', 8),
('100233765235755679452', 2),
('100233765235755679452', 5),
('100233765235755679452', 7),
('100233765235755679454', 4),
('100233765235755679454', 5)
('100233765235755679455', 7),
('100233765235755679455', 10);


INSERT INTO activity_categories(activity_id, category_id)
VALUES(1, 2),
(2, 2),
(2, 6),
(3, 7),
(4, 7),
(5, 7),
(6, 7),
(7, 6),
(8, 5),
(9, 9),
(10, 5),
(11, 1),
(12, 4),
(13, 1);


INSERT INTO friend_group(name, description)
VALUES('Jane and John', 'A couple planning dates.')
('Bob and Jill', 'Siblings trying not to be bored.'),
('Jane, John, Bob, and Jill', 'Two families enjoying company.'),
('Pizza Group', 'We love pizza');


INSERT INTO is_member(group_id, user_id)
VALUES(1, '100233765235755679450'),
(1, '100233765235755679451'),
(2, '100233765235755679452'),
(2, '100233765235755679454'),
(3, '100233765235755679450'),
(3, '100233765235755679451'),
(3, '100233765235755679452'),
(3, '100233765235755679454');

INSERT INTO planned_activity(activity_id, date, time, note, creator_id)
VALUES(3, '2021-02-15', '12:00:00', 'See if kids want to go.', '100233765235755679450'),
(11, '2021-03-02', '21:00:00', 'Potential date night.', '100233765235755679451'),
(8, '2021-02-20', '11:00:00', 'Family activity for good weather.', '100233765235755679451'),
(12, '2021-04-08', '13:00:00', 'Activity for the kids', '100233765235755679451'),
(7, '2021-03-17', '10:00:00', 'Get some locally grown food.', '100233765235755679452'),
(13, '2021-04-01', '19:00:00', 'Try a new dancing place.', '100233765235755679454'),
(9, '2021-03-23', '21:30:00', 'Friend is trying open mic night.', '100233765235755679455');


INSERT INTO invitees(plan_id, user_id, accepted, attended)
VALUES(1, '100233765235755679451', 0, 0),
(2, '100233765235755679450', 1, 1),
(3, '100233765235755679450', 1, 0),
(4, '100233765235755679450', 0, 0),
(5, '100233765235755679454', 1, 1);

INSERT INTO invitees(plan_id, user_id, accepted, attended)
VALUES(1, '100233765235755679454', 0, 0);


INSERT INTO notification_type(id, description, sender_type, message, has_confirmation_req, has_time_req)
VALUES(1, 'Invitation to become friends.', 'user', 'You have a new friend request!', 1, 0),
(2, 'Invitation to join group.', 'friend_group', 'You have been invited to join a new group!', 1, 1)
(3, 'Invitation to attend event', 'planned_activity', 'You have been invited to attend an activity.', 1, 1),
(4, 'Notice of friend request acceptance', 'user', 'You and another user are now friends!', 0, 0),
(5, 'Welcome Notice', 'user', 'Welcome to What Now!', 0, 0);

UPDATE notification_type
SET message="USER has requested to be your friend."
WHERE id=1;

UPDATE notification_type
SET message="You have been invited to join the group GROUP."
WHERE id=2;

UPDATE notification_type
SET message="USER has invited you to attend ACTIVITY."
WHERE id=3;

UPDATE notification_type
SET message="You and USER are now friends!"
WHERE id=4;

UPDATE notification_type
SET message="USER, welcome to What Now?!"
WHERE id=5;

INSERT INTO notification(id, type_id, send_date, sender, reciever_id)
VALUES(1, 1, '2021-02-13', '100233765235755679450', '100233765235755679451'),
(2, 1, '2021-3-01', '100233765235755679452', '100233765235755679454'),
(3, 2, '2021-2-26', '1', '100233765235755679454');

-- new inserts on 3/3/21
INSERT INTO category(name)
VALUES('Family Friendly'),
('Attractions'),
('Theme Parks'),
('History'),
('Nightlife'),
('Wellness'),
('Workshops'),
('Culture');

INSERT INTO activity(name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants, image, about_url)
VALUES('Zip Line Canopy Tours', 'Soar over a mile of cable from heights of 20 to 70 foot (6 to 21 m) through treetops, over hollows, and a lake. Your 5 line route is built in the true Costa Rican canopy style, incorporating trees and poles with a mix of both ground and elevated take-offs and landings.

Begin your adventure by climbing aboard a jungle safari vehicle—a Vietnam War Era 2-1/2 ton Military Deuce that has 10-wheel drive. Hang on as you wind along rugged backcountry roads over a half mile to your first zipline platform.

Step out onto the welcoming stage and feel your adrenaline begin to pump while you gaze out onto the high zipline cables anchored from tree to tree and tower to tower. After a safety orientation, training session, and question and answer period, get suited up for the ride of your life.', '100233765235755679454', '', '', 3, '2620 Valley Branch Road', '', 'Nashville', 'IN', '47448', 8, 'https://mediaim.expedia.com/localexpert/303300/3216aeab-6a7f-4e3e-9f42-dee9e7ef41ae.jpg?impolicy=resizecrop&rw=1005&rh=565', 'https://explorebrowncounty.com/');

INSERT INTO activity(name, description, creator_id, open_time, close_time, price, street1, street2, city, state, zip, max_participants, image, about_url)
VALUES('McCormicks Creek State Park', 'The first state park in Indiana, McCormicks Creek is just 15 miles northwest of Bloomington. Limestone caves, rushing water, and the dense forested landscapes at McCormicks Creek provide beautiful scenery to explore on a day trip or overnight adventure.', '100233765235755679454', '07:00:00', '23:00:00', 1, '250 McCormick Creek Park Road', '', 'Spencer', 'IN', '47460', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-mccormick_s-creek-state-park.jpg.jpg', 'http://www.in.gov/dnr/parklake/2978.htm'),

('Hoosier National Forest', 'Encompassing more than 200,000 acres of natural habitat, the Hoosier National Forest provides true adventure to south-central Indiana. Spread across nine counties, Hoosier National Forest is split between two natural regions of the state, with the northern portion easily accessed from Bloomington. This means that for city residents and tourists, escaping into the natural space is an easy thing to do.
The northern portion of Hoosier National Forest near Bloomington caters to a wide variety of recreation. Common activities include backpacking, fishing, scenic driving, rock climbing, and wildlife viewing. Numerous campgrounds can be found throughout the entire forest for both RV dwellers and primitive campers.', '100233765235755679454', '07:00:00', '23:00:00', 1, '811 Constitution Ave', '', 'Bedford', 'IN', '47421', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-hoosier-national-forest.jpg.jpg', 'https://www.fs.usda.gov/hoosier/'),

('Fountain Square Mall', 'At the heart of downtown, less than a half mile from Sample Gates and the Indiana University campus, Fountain Square Mall is a historic building filled with many local shops to discover. Ranging from fashion and jewelry to health and fitness, including arts and hobbies, nearly every store within Fountain Square Mall is unique to Bloomington.
Within the shopping space, a historic ballroom also beckons and can be rented out for special occasions. Fountain Square Mall receives due credit for revitalizing the downtown area during the 1980s, and during any visit today, its hard to imagine this bustling district ever needing an economic boost.', '100233765235755679454', '07:00:00', '21:00:00', 0, '101 West Kirkwood Avenue', '', 'Bloomington', 'IN', '47404', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-fountain-square-mall.jpg.jpg', 'https://www.fountainsquarebloomington.com/'),

('WonderLab Museum of Science, Health & Technology', 'This downtown childrens museum sparks the imagination with hands-on science activity and interactive exhibits. Easily accessed via the B-Line Trail, a few of the permanent exhibits at WonderLab include a Kaleidoscope Cave, Bubble Airium, and Hall of Natural Science.
Outside on the grounds, the Lester P. Bushnell WonderGarden is a bountiful natural space filled with living exhibits. As part of the mission of this non-profit institution, WonderLab also offers a variety of programs, including STEM-oriented "IDEA Labs," adult social functions, and WonderCamps for kids.', '100233765235755679454', '09:00:00', '16:00:00', 1, '308 West Fourth Street', '', 'Bloomington', 'IN', '47404', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-wonderlab-science-museum.jpg.jpg', 'http://www.wonderlab.org/'),

('Wylie House Museum', 'On the southern outskirts of campus, the Wylie House Museum is a historic home built and lived in by Dr. Andrew Wylie, the first president of Indiana University. The entire estate is now a public museum open to all members of the community to enjoy. Free guided tours of this 1835 home occur between 10am and 2pm Tuesday through Saturday.
Upon entry to the home, the shock of time travel may occur, for the house still appears to support a 19th-century lifestyle, adorned with many original artifacts.
On the grounds outside, an heirloom garden provides even more to admire, and the neighboring Morton C. Bradley, Jr. Education Center provides deeper insight into various influential members of the Wylie family.', '100233765235755679454', '07:00:00', '23:00:00', 1, '307 East Second Street', '', 'Bloomington', 'IN', '47404', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-wylie-house-museum.jpg.jpg', 'https://libraries.indiana.edu/wylie-house-museum'),

('Wapehani Mountain Bike Park', 'Southeast of downtown and the Indiana University campus, Wapehani Mountain Bike Park is one of the first of its kind in Indiana. Tucked away on a quiet 50 acres of land, the mountain bike park also caters to hikers, trail runners, mushroom hunters, and wildlife watchers.
With nearly eight miles of trails, ranging from intermediate runs to more advanced downhills and obstacles, Wapehani sees plenty of traffic on the weekends and evenings. If you are planning to bike with friends, carpooling is a great option, as the gravel parking lot has enough room for maybe a dozen cars.', '100233765235755679454', '07:00:00', '23:00:00', 1, '3401 West Wapehani Road', '', 'Bloomington', 'IN', '47404', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-wapehani-mountain-bike-park.jpg.jpg', null),

('Tibetan Mongolian Buddhist Cultural Center', 'Located southeast of the city, halfway between downtown and Monroe Lake, this cultural center and monastery provides a unique look into a different culture. Or for many that visit, a valuable resource to express their values.
Founded in 1979, this cultural center has evolved over the years and now strives to preserve and nurture Tibetan and Mongolian culture in the United States. This inspiring campus provides classes, workshops, and opportunities such as summer retreats and weekly teachings including prayer, meditation, and yoga.
The intricately decorated grounds are also available to tour and provide a tranquil moment during the day. Several works of art and architecture punctuate much of the space at the cultural center, with notable features including Kumbum Chamtse Ling Temple and a Tibetan stupa.', '100233765235755679454', '09:00:00', '18:00:00', 0, '3655 South Snoddy Road', '', 'Bloomington', 'IN', '47404', null, 'https://www.planetware.com/wpimages/2018/05/indiana-bloomington-things-to-do-tibetan-mongolian-buddhist-cultural-center-masks.jpg.jpg', 'https://www.tmbcc.org/');

INSERT INTO activity_categories(activity_id, category_id)
VALUES(14, 2),
(14, 4),
(14, 5),
(14, 7),
(14, 11),
(22, 4),
(22, 5),
(22, 7),
(23, 4),
(23, 5),
(23, 7),
(24, 14),
(24, 18),
(24, 6),
(25, 11),
(25, 12),
(26, 11),
(26, 12),
(26, 14),
(26, 18),
(27, 2),
(27, 4),
(27, 5),
(27, 7),
(28, 4),
(28, 5),
(28, 6),
(28, 8),
(28, 11),
(28, 14),
(28, 16),
(28, 18),
(11, 15),
(13, 17);