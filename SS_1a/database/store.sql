
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(12),
  `password` text,
  `admin` boolean DEFAULT false,
  PRIMARY KEY (id)
);
drop table `shoes`;
CREATE TABLE IF NOT EXISTS `shoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shoeName` text,
  `shoeBrand` text,
  `showImg` text,
  `colorWay` text,
  `shoeCost` int,
  PRIMARY KEY (id)
);
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `shoe_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (id)
);
INSERT INTO `shoes`
   (`showImg`,`shoeName`, `shoeBrand`, `colorWay`, `shoeCost`)
-- start with https://images.stockx.com/images/
-- add $ sign beofre cost
-- all prices are Resale cost, we can Add some shipping or change the cost a little cause they are exclusivly on our website
VALUES
   -- Nike
   ('Nike-Dunk-Low-Retro-White-Black-2021-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1633027409&q=80','Nike Dunk Low Retro', 'Nike', 'White Black Panda', 205),
   ('Air-Jordan-1-Retro-High-OG-Stage-Haze-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1653035159&q=80', 'Jordan 1 Retro High OG','Nike','Bleached Coral', 212),
   ('Nike-Air-Force-1-Low-White-07_V2-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1631122839&q=80', 'Nike Air Force 1 Low 2007', 'Nike', 'White', 103),
   ('Nike-Dunk-Low-Sun-Club-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1656520314&q=800', 'Nike Dunk Low', 'Nike', 'Next Nature Sun Club Arctic Orange', 125),
   ('Nike-LeBron-Soldier-12-Game-Royal-Promo.png?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1627415488&q=80','Nike LeBron Soldier 12','Nike','Game Royal', 100),
   ('Nike-Dunk-Low-Chlorophyll-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1653041272&q=80', 'Nike Dunk Low', 'Nike', 'Chlorophyll', 125),
   ('Nike-Dunk-High-Pink-Prime-W-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1641573308&q=80', 'Nike Dunk High', 'Nike','Pink Prime', 164),
   ('Nike-Dunk-Low-Team-Red-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1648821059&q=80', 'Nike Dunk Low', 'Nike', 'Team Red', 136),
   ('Nike-Air-Max-Penny-1-Social-Status-Photon-Dust.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1656705065&q=80','Nike Air Max Penny 1', 'Nike', 'Social Status Recess Photon Dust', 226),
   ('Nike-Dunk-Low-Essential-Paisley-Pack-Orange-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1651513357&q=80', 'Nike Dunk Low Essential', 'Nike', 'Paisley Pack Orange', 145),
   ('Air-Jordan-1-Retro-High-OG-Bred-Patent-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1633542046&q=80', 'Jordan 1 Retro High OG','Nike','Patent Bred', 223),
   ('Air-Jordan-1-Retro-High-OG-Dark-Marina-Blue-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1642023273&q=80', 'Jordan 1 Retro High OG','Nike', 'Dark Marina Blue', 187),
   ('Air-Jordan-1-Mid-Sonics-2021-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1646934930&q=80', 'Jordan 1 Mid', 'Nike', 'Sonics', 105),
   ('Air-Jordan-1-Low-fragment-design-x-Travis-Scott-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1629307046&q=80', 'Jordan 1 Low', 'Nike', 'Fragment x Travis Scott', 1300),
   ('Air-Jordan-1-Retro-High-Travis-Scott-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1608736403&q=80','Jordan 1 Retro High','Nike','Travis Scott Mocha', 1699),
   ('Nike-Dunk-Low-Safari-Mix-W-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1650480982&q=80', 'Nike Dunk Low', 'Nike', 'Safari Mix', 140),
   -- Puma
   ('Puma-MB1-Purple-Glimmer-GS-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1648504053&q=80', 'Puma MB1', 'Puma', 'Queen City', 216),
   ('Puma-MB01-LaMelo-Ball-Buzz-City.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1641587333&q=80','Puma LaMelo Ball MB.01', 'Puma', 'Buzz City', 234),
   ('Puma-MB01-LaMelo-Ball-Galaxy-GS-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1651844996&q=80','Puma LaMelo Ball MB.01', 'Puma', 'Galaxy', 86 ),
   ('Puma-RS-LaMelo-Ball-Galaxy.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1654465662&q=80', 'Puma RS-X','Puma','LaMelo Ball Galaxy', 116),
   ('Puma-MB01-Lo-UFO.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1654652541&q=80', 'Puma LaMelo Ball MB.01','Puma','UFO', 172),
   ('Puma-MB01-LaMelo-Ball-Black-Red-Blast-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1645556409&q=80','Puma LaMelo Ball MB.01', 'Puma', 'Black Red Blast', 282),
   ('Puma-MB01-Not-From-Here-PS.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1652750901&q=80', 'Puma LaMelo Ball MB.01', 'Puma', 'Not From Here', 85),
   ('Puma-MB01-LaMelo-Ball-Grey-Red-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1648066335&q=80', 'Puma LaMelo Ball MB.01', 'Puma','Rock Ridge Red Blast', 138),
   ('Puma-Thunder-Scuderia-Ferrari.png?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1626899515&q=80','Puma Thunder','Puma','Scuderia Ferrari', 87),
   ('Puma-RS-Rick-and-Morty.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1653667127&q=80','Puma RS-X','Puma','Rick and Morty', 100),
   ('Puma-RS-Dreamer-J-Cole-Ebony-and-Ivory.png?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1607107260&q=80','Puma RS-Dreamer','Puma','J Cole Ebony and Ivory', 82),
   ('Puma-Suede-Vintage-Bombay-Brown.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1637291568&q=80', 'Puma Suede Vintage','Puma','Bombay Brown', 120),
   ('Puma-RS-Dreamer-J-Cole-Red-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1626806139&q=80','Puma RS-Dreamer','Puma','J Cole Red', 59),
   ('Puma-RS-Dreamer-J-Cole-Blue-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1642071731&q=80', 'Puma RS-Dreamer','Puma', 'J Cole Aquarius', 55),
   ('Puma-RS-Dreamer-E-Line.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1646278080&q=80','Puma RS-Dreamer','Puma','E-Line', 57),
   ('Puma-Slipstream-Low-Butter-Goods-Whisper-White-Prism-Violet-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1651856901&q=80', 'Puma Slipstream Low', 'Puma', 'Butter Goods Whisper White Prism Violet', 148),
   -- Adidas shoes=
   ('adidas-Yeezy-Foam-RNNR-Onyx-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1654264132&q=80', 'Adidas Yeezy Foam RNR', 'Adidas', 'Onyx', 220),
   ('Adidas-Yeezy-Boost-350-V2-Zebra-Product-1.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1606321670&q=80', 'Adidas Yeezy Boost 350 V2','Adidas', 'Zebra',273),
   ('adidas-Yeezy-Boost-350-V2-Pure-Oat-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1648503664&q=80','adidas Yeezy Slide', 'Adidas', 'Pure', 198),
   ('adidas-Yeezy-Boost-350-V2-Pure-Oat-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1648503664&q=80', 'Adidas Yeezy Boost 350 V2', 'Adidas', 'Bone', 221),
   ('adidas-Yeezy-Boost-700-Hi-Red-Red-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1655732626&q=80', 'Adidas Yeezy Boost 700', 'Adidas', 'Hi-Res Red', 315),
   ('adidas-Yeezy-Foam-RNNR-Vermillion-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1635875119&q=80', 'Addidas Yeezy Foam RNNR', 'Adidas', 'Vermillion',296),
   ('Adidas-Yeezy-500-Blush-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1606320491&q=80', 'Addidas Yeezy 500', 'Adidas', 'Blush',246),
   ('adidas-Yeezy-450-Sulfur-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1651599570&q=80', 'Addidas Yeezy 450', 'Adidas', 'Sulfur',150),
   ('adidas-Forum-Low-Hebru-Brantley-Rocket.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1657601623&q=80', 'Adidas Forum Low', 'Adidas', 'Hebru Brantley Rocket',191),
   ('adidas-Forum-Low-Donovan-Mitchell.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1629223311&q=80', 'Adidas Forum Low', 'Adidas', 'Donovan Mitchell',150),
   ('adidas-Forum-Low-Mesa.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1652142755&q=80', 'Adidas Forum Low', 'Adidas', 'Messa',72),
   ('adidas-Forum-84-Low-Arwa-Al-Banawi-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=&auto=compress&dpr=1&trim=color&updated_at=1626289055&q=80', 'Adidas Forum 84 Low', 'Adidas', 'Arwa Al Banawi',85),
   ('adidas-Forum-Low-Quiccs.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1644696739&q=80', 'Adidas Forum Low', 'Adidas', 'Quiccs',109),
   ('adidas-Forum-Low-Xiangi.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1642573026&q=80', 'Adidas Forum Low', 'Adidas', 'Xiangi',85),
   ('adidas-Forum-Low-Yoyogi-Park.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1624648481&q=80', 'Adidas Forum Low', 'Adidas', 'Yoyogi Park',106),
   ('adidas-Forum-Low-M-Ms-Red-Product.jpg?fit=fill&bg=FFFFFF&w=480&h=320&fm=avif&auto=compress&dpr=1&trim=color&updated_at=1654263904&q=80', 'Adidas Forum Low', 'Adidas', 'M&M Red',134);
END IF;

ALTER TABLE `cart`
ADD FOREIGN KEY (shoe_id) REFERENCES shoes(`id`);

ALTER TABLE `cart`
ADD FOREIGN KEY (user_id) REFERENCES users(`id`),
