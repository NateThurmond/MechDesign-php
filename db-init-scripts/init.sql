CREATE DATABASE IF NOT EXISTS MechDesign;
USE MechDesign;

CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `gv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwHash` varchar(255) NOT NULL,
  `firstName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `lastName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `loginCount` int NOT NULL DEFAULT '0',
  `timeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- You can optionally insert a default user here
-- INSERT INTO `members` (`username`, `email`, `pwHash`) VALUES
-- ('firstUser', 'firstUser@mail.com', '<HASHED_PASSWORD_YOU_WANT>');

CREATE TABLE `mecharm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `partLeftorRight` int DEFAULT '0',
  `slot1` varchar(255) DEFAULT '',
  `slot2` varchar(255) DEFAULT '',
  `slot3` varchar(255) DEFAULT '',
  `slot4` varchar(255) DEFAULT '',
  `slot5` varchar(255) DEFAULT '',
  `slot6` varchar(255) DEFAULT '',
  `slot7` varchar(255) DEFAULT '',
  `slot8` varchar(255) DEFAULT '',
  `slot9` varchar(255) DEFAULT '',
  `slot10` varchar(255) DEFAULT '',
  `slot11` varchar(255) DEFAULT '',
  `slot12` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechengine` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `engineName` varchar(255) DEFAULT '',
  `activeEngine` tinyint(1) DEFAULT '0',
  `engineRating` int DEFAULT '0',
  `mechWalk` int DEFAULT '0',
  `mechRun` int DEFAULT '0',
  `mechJump` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechexternalarmor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `armLeftArmor` int NOT NULL DEFAULT '0',
  `armRightArmor` int NOT NULL DEFAULT '0',
  `headArmor` int NOT NULL DEFAULT '0',
  `centerArmor` int NOT NULL DEFAULT '0',
  `rearCenterArmor` int NOT NULL DEFAULT '0',
  `torsoLeftArmor` int NOT NULL DEFAULT '0',
  `torsoRightArmor` int NOT NULL DEFAULT '0',
  `rearLeftTorsoArmor` int NOT NULL DEFAULT '0',
  `rearRightTorsoArmor` int NOT NULL DEFAULT '0',
  `legLeftArmor` int NOT NULL DEFAULT '0',
  `legRightArmor` int NOT NULL DEFAULT '0',
  `mechArmorTotal` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechhead` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `partLeftorRight` varchar(255) DEFAULT '2',
  `slot1` varchar(255) DEFAULT '',
  `slot2` varchar(255) DEFAULT '',
  `slot3` varchar(255) DEFAULT '',
  `slot4` varchar(255) DEFAULT '',
  `slot5` varchar(255) DEFAULT '',
  `slot6` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechinternals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `jumpJetsNum` int DEFAULT '0',
  `internalStructureTonnage` int DEFAULT '0',
  `engineTonnage` int DEFAULT '0',
  `gyroTonnage` int DEFAULT '0',
  `jumpJetsTonnage` int DEFAULT '0',
  `cockpitTonnage` int DEFAULT '0',
  `heatSinksTonnage` int DEFAULT '0',
  `totalInternalTonnage` int DEFAULT '0',
  `internalStructureCriticals` int DEFAULT '0',
  `engineCriticals` int DEFAULT '0',
  `gyroCriticals` int DEFAULT '0',
  `cockpitCriticals` int DEFAULT '0',
  `heatSinksCriticals` int DEFAULT '0',
  `enhancementsTonnage` int DEFAULT '0',
  `enhancementsCriticals` int DEFAULT '0',
  `jumpJetsCriticals` int DEFAULT '0',
  `heatSinkType` varchar(255) DEFAULT 'Singles',
  `heatSinksNum` int DEFAULT '0',
  `weaponTonnage` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechleg` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `partLeftorRight` int DEFAULT '0',
  `slot1` varchar(255) DEFAULT '',
  `slot2` varchar(255) DEFAULT '',
  `slot3` varchar(255) DEFAULT '',
  `slot4` varchar(255) DEFAULT '',
  `slot5` varchar(255) DEFAULT '',
  `slot6` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechs` (
  `mechID` int NOT NULL AUTO_INCREMENT,
  `mechName` varchar(255) DEFAULT '',
  `armor` int DEFAULT '0',
  `maxTonnage` int DEFAULT '0',
  `introDate` int DEFAULT '3000',
  `mechModel` varchar(255) DEFAULT '',
  `era` varchar(255) DEFAULT 'Star League',
  `techBase` varchar(255) DEFAULT 'Inner-Sphere',
  `productionYear` varchar(255) DEFAULT '3030',
  PRIMARY KEY (`mechID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechtorso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `partLeftorRight` varchar(255) DEFAULT '0',
  `slot1` varchar(255) DEFAULT '',
  `slot2` varchar(255) DEFAULT '',
  `slot3` varchar(255) DEFAULT '',
  `slot4` varchar(255) DEFAULT '',
  `slot5` varchar(255) DEFAULT '',
  `slot6` varchar(255) DEFAULT '',
  `slot7` varchar(255) DEFAULT '',
  `slot8` varchar(255) DEFAULT '',
  `slot9` varchar(255) DEFAULT '',
  `slot10` varchar(255) DEFAULT '',
  `slot11` varchar(255) DEFAULT '',
  `slot12` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechtorsocenter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mechID` int DEFAULT NULL,
  `partLeftorRight` varchar(255) DEFAULT '2',
  `slot1` varchar(255) DEFAULT '',
  `slot2` varchar(255) DEFAULT '',
  `slot3` varchar(255) DEFAULT '',
  `slot4` varchar(255) DEFAULT '',
  `slot5` varchar(255) DEFAULT '',
  `slot6` varchar(255) DEFAULT '',
  `slot7` varchar(255) DEFAULT '',
  `slot8` varchar(255) DEFAULT '',
  `slot9` varchar(255) DEFAULT '',
  `slot10` varchar(255) DEFAULT '',
  `slot11` varchar(255) DEFAULT '',
  `slot12` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `mechweapons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `weaponName` varchar(255) DEFAULT '',
  `damage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `heat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `rangeMin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `rangeShort` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `rangeMed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `rangeLong` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `tons` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `slotsRequired` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `ammoNeeded` varchar(255) DEFAULT '',
  `weaponType` varchar(255) DEFAULT '',
  `availableDate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Reference data, not modified but used for other calcuations
CREATE TABLE engineratingweights (
    engineRating INT PRIMARY KEY,
    regEngWeight FLOAT NOT NULL,
    xlEngWeight FLOAT NOT NULL,
    gyroWeight FLOAT NOT NULL
);

INSERT INTO `mecharm` (`mechID`, `partLeftorRight`) VALUES
(1, 0),
(2, 0),
(1, 1),
(2, 1);

INSERT INTO `mechengine` (`mechID`, `engineName`, `activeEngine`, `engineRating`, `mechWalk`, `mechRun`, `mechJump`) VALUES
(1, 'Fusion Engine', 1, 2, 5, 8, 5),
(2, 'XL Engine', 1, 3, 6, 9, 6);

INSERT INTO `mechexternalarmor` (`mechID`, `armLeftArmor`, `armRightArmor`, `headArmor`, `centerArmor`, `rearCenterArmor`, `torsoLeftArmor`, `torsoRightArmor`, `rearLeftTorsoArmor`, `rearRightTorsoArmor`, `legLeftArmor`, `legRightArmor`, `mechArmorTotal`) VALUES
(1, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 120),
(2, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 100);

INSERT INTO `mechhead` (`mechID`, `partLeftorRight`) VALUES
(1, '2'),
(2, '2');

INSERT INTO `mechinternals` (`mechID`, `jumpJetsNum`, `internalStructureTonnage`, `engineTonnage`, `gyroTonnage`, `jumpJetsTonnage`, `cockpitTonnage`, `heatSinksTonnage`, `totalInternalTonnage`, `internalStructureCriticals`, `engineCriticals`, `gyroCriticals`, `cockpitCriticals`, `heatSinksCriticals`, `enhancementsTonnage`, `enhancementsCriticals`, `jumpJetsCriticals`, `heatSinkType`, `heatSinksNum`, `weaponTonnage`) VALUES
(1, 3, 30, 10, 5, 3, 10, 20, 70, 5, 3, 3, 1, 2, 0, 0, 2, 'Singles', 10, 10),
(2, 5, 25, 8, 4, 5, 8, 18, 65, 4, 2, 2, 2, 3, 1, 1, 3, 'Singles', 12, 12);

INSERT INTO `mechleg` (`mechID`, `partLeftorRight`) VALUES
(1, 0),
(2, 0),
(1, 1),
(2, 1);

INSERT INTO `mechs` (`mechID`, `mechName`, `armor`, `maxTonnage`, `introDate`, `mechModel`, `era`, `techBase`, `productionYear`) VALUES
(1, 'MadCat', 120, 80, 3025, 'Prime', 'Star League', 'Inner-Sphere', '3030'),
(2, 'MadDog', 115, 65, 3033, 'Alpha', 'Succession War', 'Clan', '3055');

INSERT INTO `mechtorso` (`mechID`, `partLeftorRight`) VALUES
(1, '0'),
(2, '0'),
(1, '1'),
(2, '1');

INSERT INTO `mechtorsocenter` (`mechID`, `partLeftorRight`) VALUES
(1, '2'),
(2, '2');

-- Always insert these, these are static and are added to mech customizations
INSERT INTO `mechweapons` (`weaponName`, `damage`, `heat`, `rangeMin`, `rangeShort`, `rangeMed`, `rangeLong`, `tons`, `slotsRequired`, `ammoNeeded`, `weaponType`, `availableDate`) VALUES
('Medium Laser', '5', '3', '0', '3', '6', '9', '1', '3', 'N/A', 'Energy', '3000'),
('Small Laser', '3', '1', '0', '1', '2', '3', '0.5', '1', 'N/A', 'Energy', '3000'),
('Large Laser', '8', '8', '0', '5', '10', '15', '5', '2', 'N/A', 'Energy', '3000'),
('PPC', '10', '10', '3', '6', '12', '18', '7', '3', 'N/A', 'Energy', '3000'),
('Flamer', '2', '3', '0', '1', '2', '3', '0.5', '1', 'N/A', 'Energy', '3000'),
('Vehicle Flamer', '2', '3', '0', '1', '2', '3', '0.5', '1', 'Yes', 'Energy', '3000'),
('Machine Gun', '2', '0', '0', '1', '2', '3', '1', '1', 'Yes', 'Ballistics', '3000'),
('Autocannon 2', '2', '1', '0', '8', '16', '24', '6', '1', 'Yes', 'Ballistics', '3000'),
('Autocannon 5', '5', '1', '3', '6', '12', '18', '8', '4', 'Yes', 'Ballistics', '3000'),
('Autocannon 10', '10', '3', '0', '5', '10', '15', '12', '7', 'Yes', 'Ballistics', '3000'),
('Autocannon 20', '20', '7', '0', '3', '6', '9', '14', '10', 'Yes', 'Ballistics', '3000'),
('SRM-2', '4', '2', '0', '3', '6', '9', '1', '1', 'Yes', 'Missiles', '3000'),
('SRM-4', '8', '3', '0', '3', '6', '9', '2', '1', 'Yes', 'Missiles', '3000'),
('SRM-6', '12', '4', '0', '3', '6', '9', '3', '2', 'Yes', 'Missiles', '3000'),
('LRM-5', '5', '2', '6', '7', '14', '21', '2', '2', 'Yes', 'Missiles', '3000'),
('LRM-10', '10', '4', '6', '7', '14', '21', '5', '2', 'Yes', 'Missiles', '3000'),
('LRM-15', '15', '5', '6', '7', '14', '21', '7', '3', 'Yes', 'Missiles', '3000'),
('LRM-20', '20', '6', '6', '7', '14', '21', '10', '5', 'Yes', 'Missiles', '3000'),
('SRM-2 Ammo', '', '', '', '', '', '', '1', '1', '', 'Ammunition', '3000'),
('SRM-4 Ammo', '', '', '', '', '', '', '2', '2', '', 'Ammunition', '3000'),
('SRM-6 Ammo', '', '', '', '', '', '', '3', '3', '', 'Ammunition', '3000'),
('LRM-5 Ammo', '', '', '', '', '', '', '1', '1', '', 'Ammunition', '3000'),
('LRM-10 Ammo', '', '', '', '', '', '', '2', '2', '', 'Ammunition', '3000'),
('LRM-15 Ammo', '', '', '', '', '', '', '3', '3', '', 'Ammunition', '3000'),
('LRM-20 Ammo', '', '', '', '', '', '', '4', '4', '', 'Ammunition', '3000'),
('Machine Gun Ammo', '', '', '', '', '', '', '0.5', '1', '', 'Ammunition', '3000'),
('Autocannon 2 Ammo', '', '', '', '', '', '', '1', '1', '', 'Ammunition', '3000'),
('Autocannon 5 Ammo', '', '', '', '', '', '', '2', '1', '', 'Ammunition', '3000'),
('Autocannon 10 Ammo', '', '', '', '', '', '', '4', '2', '', 'Ammunition', '3000'),
('Autocannon 20 Ammo', '', '', '', '', '', '', '6', '3', '', 'Ammunition', '3000'),
('Vehicle Flamer Ammo', '', '', '', '', '', '', '1', '1', '', 'Ammunition', '3000');

-- Reference data, not modified but used for other calcuations
INSERT INTO engineratingweights (engineRating, regEngWeight, xlEngWeight, gyroWeight) VALUES
(100, 5.0, 2.5, 1.0),
(200, 10.0, 5.0, 2.0),
(300, 15.0, 7.5, 3.0),
(400, 20.0, 10.0, 4.0),
(500, 25.0, 12.5, 5.0),
(600, 30.0, 15.0, 6.0),
(700, 35.0, 17.5, 7.0),
(800, 40.0, 20.0, 8.0);
