CREATE DATABASE IF NOT EXISTS motueka;
USE motueka;

-- The rooms for the bed and breakfast
DROP TABLE IF EXISTS room;
CREATE TABLE IF NOT EXISTS room (
  roomID int unsigned NOT NULL auto_increment,
  roomname varchar(100) NOT NULL,
  description text default NULL,
  roomtype character default 'D',  
  beds int,
  PRIMARY KEY (roomID)
) AUTO_INCREMENT=1;
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (1,"Kellie","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing","S",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (2,"Herman","Lorem ipsum dolor sit amet, consectetuer","D",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (3,"Scarlett","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur","D",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (4,"Jelani","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam","S",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (5,"Sonya","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.","S",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (6,"Miranda","Lorem ipsum dolor sit amet, consectetuer adipiscing","S",4);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (7,"Helen","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.","S",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (8,"Octavia","Lorem ipsum dolor sit amet,","D",3);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (9,"Gretchen","Lorem ipsum dolor sit","D",3);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (10,"Bernard","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer","S",5);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (11,"Dacey","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur","D",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (12,"Preston","Lorem","D",2);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (13,"Dane","Lorem ipsum dolor","S",4);
INSERT INTO `room` (`roomID`,`roomname`,`description`,`roomtype`,`beds`) VALUES (14,"Cole","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam","S",1);

-- Customers
DROP TABLE IF EXISTS customer;
CREATE TABLE IF NOT EXISTS customer (
  customerID int unsigned NOT NULL auto_increment,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(100) NOT NULL default '.',
  PRIMARY KEY (customerID)
) AUTO_INCREMENT=1;

-- Admin log in is; Username: admin@email.com, Password: admin -->
INSERT INTO customer (customerID,firstname,lastname,email,password) VALUES
(1, "Admin", "Admin","admin@email.com", "$2y$10$aInIMaOntrndynTaXayWvuvu7BGFwH2QdsHKjJLjpYOe3yczChrBy"),
(2,"Desiree","Collier","Maecenas@non.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(3,"Irene","Walker","id.erat.Etiam@id.org","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(4,"Forrest","Baldwin","eget.nisi.dictum@a.com","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(5,"Beverly","Sellers","ultricies.sem@pharetraQuisqueac.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(6,"Glenna","Kinney","dolor@orcilobortisaugue.org","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(7,"Montana","Gallagher","sapien.cursus@ultriciesdignissimlacus.edu","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(8,"Harlan","Lara","Duis@aliquetodioEtiam.edu","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(9,"Benjamin","King","mollis@Nullainterdum.org","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(10,"Rajah","Olsen","Vestibulum.ut.eros@nequevenenatislacus.ca","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(11,"Castor","Kelly","Fusce.feugiat.Lorem@porta.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(12,"Omar","Oconnor","eu.turpis@auctorvelit.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(13,"Porter","Leonard","dui.Fusce@accumsanlaoreet.net","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(14,"Buckminster","Gaines","convallis.convallis.dolor@ligula.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(15,"Hunter","Rodriquez","ridiculus.mus.Donec@est.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(16,"Zahir","Harper","vel@estNunc.com","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(17,"Sopoline","Warner","vestibulum.nec.euismod@sitamet.co.uk","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(18,"Burton","Parrish","consequat.nec.mollis@nequenonquam.org","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(19,"Abbot","Rose","non@et.ca","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle"),
(20,"Barry","Burks","risus@libero.net","$2y$10$RxUQPbHCiLkX1RTZAvWyqOKveoZUxiLGgY./MCVzBfH1bVZNpPLle");



-- Booking
DROP TABLE IF EXISTS booking;
CREATE TABLE IF NOT EXISTS booking (
bookingID int unsigned NOT NULL auto_increment,
customerID int unsigned NOT NULL,
roomID int unsigned NOT NULL,
checkinDate DATETIME NOT NULL,
checkoutDate DATETIME NOT NULL,
contactNumber varchar(15) NOT NULL,
bookingExtra varchar(150),
bookingReview varchar(150),
PRIMARY KEY (bookingID),
FOREIGN KEY (customerID) REFERENCES customer(customerID),
FOREIGN KEY (roomID) REFERENCES room(roomID)
) AUTO_INCREMENT=1;

-- Part 2 Task 2 assignment 2
INSERT INTO booking (customerID, roomID, checkinDate, checkoutDate, contactNumber, bookingExtra) VALUES
(3,3, '2023-05-23 12:00', '2023-06-01 12:00', '027 234 456', ''),
(4,6, '2023-05-26 12:00', '2023-06-23 12:00', '027 752 354', '')
