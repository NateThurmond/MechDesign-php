-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2014 at 01:12 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `btdesign`
--

-- --------------------------------------------------------

--
-- Table structure for table `engineratingweights`
--

CREATE TABLE IF NOT EXISTS `engineratingweights` (
  `engineRating` int(11) NOT NULL,
  `regEngWeight` float NOT NULL,
  `xlEngWeight` float NOT NULL,
  `gyroWeight` float NOT NULL,
  PRIMARY KEY (`engineRating`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `engineratingweights`
--

INSERT INTO `engineratingweights` (`engineRating`, `regEngWeight`, `xlEngWeight`, `gyroWeight`) VALUES
(20, 3, 1.5, 1),
(25, 3, 1.5, 1),
(30, 3, 1.5, 1),
(35, 3, 1.5, 1),
(40, 3, 1.5, 1),
(45, 3, 1.5, 1),
(50, 3, 1.5, 1),
(55, 3, 1.5, 1),
(60, 3, 1.5, 1),
(65, 3, 1.5, 1),
(70, 3, 1.5, 1),
(75, 3, 1.5, 1),
(80, 3, 1.5, 1),
(85, 3, 1.5, 1),
(90, 3, 1.5, 1),
(95, 3, 1.5, 1),
(100, 3, 1.5, 1),
(105, 3.5, 2, 2),
(110, 3.5, 2, 2),
(115, 4, 2, 2),
(120, 4, 2, 2),
(125, 4, 2, 2),
(130, 4.5, 2.5, 2),
(135, 4.5, 2.5, 2),
(140, 5, 2.5, 2),
(145, 5, 2.5, 2),
(150, 5.5, 3, 2),
(155, 5.5, 3, 2),
(160, 6, 3, 2),
(165, 6, 3, 2),
(170, 6.5, 3, 2),
(175, 7, 3.5, 2),
(180, 7, 3.5, 2),
(185, 7.5, 4, 2),
(190, 7.5, 4, 2),
(195, 8, 4, 2),
(200, 8.5, 4.5, 2),
(205, 8.5, 4.5, 3),
(210, 9, 4.5, 3),
(215, 9.5, 5, 3),
(220, 10, 5, 3),
(225, 10, 5, 3),
(230, 10.5, 5.5, 3),
(235, 11, 5.5, 3),
(240, 11.5, 6, 3),
(245, 12, 6, 3),
(250, 12.5, 6.5, 3),
(255, 13, 6.5, 3),
(260, 13.5, 7, 3),
(265, 14, 7, 3),
(270, 14.5, 7.5, 3),
(275, 15.5, 8, 3),
(280, 16, 8, 3),
(285, 16.5, 8.5, 3),
(290, 17.5, 9, 3),
(295, 18, 9, 3),
(300, 19, 9.5, 3),
(305, 19.5, 10, 4),
(310, 20.5, 10.5, 4),
(315, 21.5, 11, 4),
(320, 22.5, 11.5, 4),
(325, 23.5, 12, 4),
(330, 24.5, 12.5, 4),
(335, 25.5, 13, 4),
(340, 27, 13.5, 4),
(345, 28.5, 14.5, 4),
(350, 29.5, 15, 4),
(355, 31.5, 16, 4),
(360, 33, 16.5, 4),
(365, 34.5, 17.5, 4),
(370, 37, 18.5, 4),
(375, 38.5, 19.5, 4),
(380, 41, 20.5, 4),
(385, 43.5, 22, 4),
(390, 46, 23, 4),
(395, 49, 24.5, 4),
(400, 52.5, 26.5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `maxarmorfortonnage`
--

CREATE TABLE IF NOT EXISTS `maxarmorfortonnage` (
  `mechTonnage` int(11) NOT NULL AUTO_INCREMENT,
  `headMax` int(11) NOT NULL,
  `torsoMax` int(11) NOT NULL,
  `armMax` int(11) NOT NULL,
  `centerTorsoMax` int(11) NOT NULL,
  `legMax` int(11) NOT NULL,
  PRIMARY KEY (`mechTonnage`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `maxarmorfortonnage`
--

INSERT INTO `maxarmorfortonnage` (`mechTonnage`, `headMax`, `torsoMax`, `armMax`, `centerTorsoMax`, `legMax`) VALUES
(20, 9, 10, 6, 12, 8),
(25, 9, 12, 8, 16, 12),
(30, 9, 14, 10, 20, 14),
(35, 9, 16, 12, 22, 16),
(40, 9, 20, 12, 24, 12),
(45, 9, 22, 14, 28, 22),
(50, 9, 24, 16, 32, 24),
(55, 9, 26, 18, 36, 26),
(60, 9, 28, 20, 40, 28),
(65, 9, 30, 20, 42, 30),
(70, 9, 30, 22, 44, 30),
(75, 9, 32, 24, 46, 32),
(80, 9, 34, 26, 50, 34),
(85, 9, 36, 28, 54, 36),
(90, 9, 38, 30, 58, 38),
(95, 9, 40, 32, 60, 40),
(100, 9, 42, 34, 62, 42);

-- --------------------------------------------------------

--
-- Table structure for table `mecharm`
--

CREATE TABLE IF NOT EXISTS `mecharm` (
  `mechArmID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `partLeftorRight` int(11) NOT NULL,
  `totalSlots` int(11) NOT NULL,
  `totalSlotsAvailable` int(11) NOT NULL,
  `slotsUnmovable` int(11) NOT NULL,
  `slot1` varchar(30) NOT NULL,
  `slot2` varchar(30) NOT NULL,
  `slot3` varchar(30) NOT NULL,
  `slot4` varchar(30) NOT NULL,
  `slot5` varchar(30) NOT NULL,
  `slot6` varchar(30) NOT NULL,
  `slot7` varchar(30) NOT NULL,
  `slot8` varchar(30) NOT NULL,
  `slot9` varchar(30) NOT NULL,
  `slot10` varchar(30) NOT NULL,
  `slot11` varchar(30) NOT NULL,
  `slot12` varchar(30) NOT NULL,
  `armorPoints` int(11) NOT NULL,
  `armorMax` int(11) NOT NULL,
  PRIMARY KEY (`mechArmID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `mecharm`
--

INSERT INTO `mecharm` (`mechArmID`, `mechID`, `partLeftorRight`, `totalSlots`, `totalSlotsAvailable`, `slotsUnmovable`, `slot1`, `slot2`, `slot3`, `slot4`, `slot5`, `slot6`, `slot7`, `slot8`, `slot9`, `slot10`, `slot11`, `slot12`, `armorPoints`, `armorMax`) VALUES
(1, 1, 0, 12, 7, 4, 'shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', '', '', '', '', '', '', '', 5, 10),
(2, 1, 1, 12, 7, 4, 'shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', '', '', '', '', '', '', '', 5, 10),
(3, 2, 0, 12, 7, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', '', '', '', '', '', '', '', 22, 22),
(4, 2, 1, 12, 7, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', '', '', '', '', '', '', '', 22, 22),
(5, 3, 0, 12, 7, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', '', '', '', '', '', '', '', 10, 30),
(6, 3, 1, 12, 7, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', '', '', '', '', '', '', '', 10, 30),
(7, 4, 1, 12, 6, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'SRM-6', 'overflow', '', '', '', '', '', '', 34, 34),
(8, 4, 0, 12, 4, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', 'Medium Laser', 'Medium Laser', 'Medium Laser', '', '', '', '', 34, 34),
(30, 30, 0, 12, 6, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'Medium Laser', 'Medium Laser', '', '', '', '', '', '', 22, 22),
(31, 30, 1, 12, 5, 4, 'Shoulder', 'Upper Arm Actuator', 'Lower Arm Actuator', 'Hand Actuator', 'PPC', 'overflow', 'overflow', '', '', '', '', '', 22, 22);

-- --------------------------------------------------------

--
-- Table structure for table `mechdetails`
--

CREATE TABLE IF NOT EXISTS `mechdetails` (
  `mechDetsID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `era` varchar(50) NOT NULL,
  `techBase` varchar(50) NOT NULL,
  `eraID` int(11) NOT NULL,
  `techBaseID` int(11) NOT NULL,
  `productionYear` int(11) NOT NULL,
  PRIMARY KEY (`mechDetsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `mechdetails`
--

INSERT INTO `mechdetails` (`mechDetsID`, `mechID`, `era`, `techBase`, `eraID`, `techBaseID`, `productionYear`) VALUES
(1, 1, 'Star League', 'Inner Sphere', 1, 1, 2650),
(2, 2, 'Star League', 'Inner Sphere', 1, 1, 2780),
(3, 3, 'Star League', 'Inner Sphere', 1, 1, 2710),
(4, 4, 'Star League', 'Inner Sphere', 1, 1, 2755),
(30, 30, 'Star League', 'Inner Sphere', 30, 1, 2925);

-- --------------------------------------------------------

--
-- Table structure for table `mechengine`
--

CREATE TABLE IF NOT EXISTS `mechengine` (
  `engineID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `engineName` varchar(111) NOT NULL,
  `engineTonnage` float NOT NULL,
  `engineSlotsUsed` int(11) NOT NULL,
  `engineRating` int(11) NOT NULL,
  `engineSlotsLocation` int(11) NOT NULL,
  `engineType` int(11) NOT NULL,
  `activeEngine` int(11) NOT NULL DEFAULT '1',
  `mechWalk` int(11) NOT NULL,
  `mechRun` int(11) NOT NULL,
  `mechJump` int(11) NOT NULL,
  PRIMARY KEY (`engineID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `mechengine`
--

INSERT INTO `mechengine` (`engineID`, `mechID`, `engineName`, `engineTonnage`, `engineSlotsUsed`, `engineRating`, `engineSlotsLocation`, `engineType`, `activeEngine`, `mechWalk`, `mechRun`, `mechJump`) VALUES
(1, 1, 'Fusion Engine', 11.5, 6, 240, 1, 1, 1, 8, 12, 8),
(2, 2, 'Fusion Engine', 16, 6, 280, 1, 1, 1, 4, 6, 4),
(3, 3, 'Fusion Engine', 33, 6, 360, 1, 1, 1, 4, 6, 0),
(4, 4, 'Fusion Engine', 19, 6, 300, 1, 1, 1, 3, 5, 0),
(30, 30, 'Fusion Engine', 16, 6, 280, 1, 1, 1, 4, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `mechexternalarmor`
--

CREATE TABLE IF NOT EXISTS `mechexternalarmor` (
  `mechID` int(11) NOT NULL AUTO_INCREMENT,
  `mechArmorTotal` int(11) NOT NULL,
  `headArmor` int(11) NOT NULL,
  `torsoLeftArmor` int(11) NOT NULL,
  `torsoRightArmor` int(11) NOT NULL,
  `armLeftArmor` int(11) NOT NULL,
  `armRightArmor` int(11) NOT NULL,
  `centerArmor` int(11) NOT NULL,
  `legLeftArmor` int(11) NOT NULL,
  `legRightArmor` int(11) NOT NULL,
  `rearLeftTorsoArmor` int(11) NOT NULL,
  `rearRightTorsoArmor` int(11) NOT NULL,
  `rearCenterArmor` int(11) NOT NULL,
  PRIMARY KEY (`mechID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `mechexternalarmor`
--

INSERT INTO `mechexternalarmor` (`mechID`, `mechArmorTotal`, `headArmor`, `torsoLeftArmor`, `torsoRightArmor`, `armLeftArmor`, `armRightArmor`, `centerArmor`, `legLeftArmor`, `legRightArmor`, `rearLeftTorsoArmor`, `rearRightTorsoArmor`, `rearCenterArmor`) VALUES
(1, 56, 6, 6, 6, 5, 5, 8, 6, 6, 2, 2, 4),
(2, 208, 9, 20, 20, 22, 22, 30, 26, 26, 10, 10, 13),
(3, 160, 9, 20, 20, 10, 10, 30, 17, 17, 8, 8, 11),
(4, 304, 9, 32, 32, 34, 34, 47, 41, 41, 10, 10, 14),
(30, 208, 9, 22, 22, 22, 22, 32, 26, 26, 8, 8, 11);

-- --------------------------------------------------------

--
-- Table structure for table `mechhead`
--

CREATE TABLE IF NOT EXISTS `mechhead` (
  `mechHeadID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `totalSlotsAvailable` int(11) NOT NULL,
  `slotsUnmovable` int(11) NOT NULL,
  `slot1` varchar(111) NOT NULL,
  `slot2` varchar(111) NOT NULL,
  `slot3` varchar(111) NOT NULL,
  `slot4` varchar(111) NOT NULL,
  `slot5` varchar(111) NOT NULL,
  `slot6` varchar(111) NOT NULL,
  `armorPoints` int(11) NOT NULL,
  `armorMax` int(11) NOT NULL,
  `partLeftorRight` int(11) NOT NULL,
  PRIMARY KEY (`mechHeadID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `mechhead`
--

INSERT INTO `mechhead` (`mechHeadID`, `mechID`, `totalSlotsAvailable`, `slotsUnmovable`, `slot1`, `slot2`, `slot3`, `slot4`, `slot5`, `slot6`, `armorPoints`, `armorMax`, `partLeftorRight`) VALUES
(1, 1, 1, 5, 'Life Support', 'Sensors', 'Cockpit', 'Sensors', 'Life Support', '', 6, 9, 2),
(2, 2, 1, 5, 'Life Support', 'Sensors', 'Cockpit', 'Sensors', 'Life Support', '', 9, 9, 2),
(3, 3, 1, 5, 'Life Support', 'Sensors', 'Cockpit', 'Sensors', 'Life Support', '', 9, 9, 2),
(4, 4, 1, 5, 'Life Support', 'Sensors', 'Cockpit', 'Sensors', 'Life Support', '', 9, 9, 2),
(30, 30, 1, 5, 'Life Support', 'Sensors', 'Cockpit', 'Sensors', 'Life Support', '', 9, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mechinternalarmorbyweight`
--

CREATE TABLE IF NOT EXISTS `mechinternalarmorbyweight` (
  `head` int(11) NOT NULL,
  `torso` int(11) NOT NULL,
  `arm` int(11) NOT NULL,
  `center` int(11) NOT NULL,
  `leg` int(11) NOT NULL,
  `mechTonnage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mechinternalarmorbyweight`
--

INSERT INTO `mechinternalarmorbyweight` (`head`, `torso`, `arm`, `center`, `leg`, `mechTonnage`) VALUES
(3, 5, 3, 6, 4, 20),
(3, 6, 4, 8, 6, 25),
(3, 7, 5, 10, 7, 30),
(3, 8, 6, 11, 8, 35),
(3, 10, 6, 12, 10, 40),
(3, 11, 7, 14, 11, 45),
(3, 12, 8, 16, 12, 50),
(3, 13, 9, 18, 13, 55),
(3, 14, 10, 20, 14, 60),
(3, 15, 10, 21, 15, 65),
(3, 15, 11, 22, 15, 70),
(3, 16, 12, 23, 16, 75),
(3, 17, 13, 25, 17, 80),
(3, 18, 14, 27, 18, 85),
(3, 19, 15, 29, 19, 90),
(3, 20, 16, 30, 20, 95),
(3, 21, 17, 31, 21, 100);

-- --------------------------------------------------------

--
-- Table structure for table `mechinternals`
--

CREATE TABLE IF NOT EXISTS `mechinternals` (
  `mechInternalsID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `totalInternalTonnage` float NOT NULL,
  `weaponTonnage` float NOT NULL,
  `internalStructureTonnage` float NOT NULL,
  `internalStructureCriticals` int(11) NOT NULL,
  `engineTonnage` float NOT NULL,
  `engineCriticals` int(11) NOT NULL,
  `gyroTonnage` float NOT NULL,
  `gyroCriticals` int(11) NOT NULL,
  `cockpitTonnage` float NOT NULL,
  `cockpitCriticals` int(11) NOT NULL,
  `heatSinkType` varchar(20) NOT NULL DEFAULT 'Single Heat Sinks',
  `heatSinksNum` int(11) NOT NULL,
  `heatSinksTonnage` float NOT NULL,
  `heatSinksCriticals` int(11) NOT NULL,
  `enhancementsTonnage` float NOT NULL,
  `enhancementsCriticals` int(11) NOT NULL,
  `jumpJetsNum` float NOT NULL,
  `jumpJetsTonnage` float NOT NULL,
  `jumpJetsCriticals` int(11) NOT NULL,
  PRIMARY KEY (`mechInternalsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `mechinternals`
--

INSERT INTO `mechinternals` (`mechInternalsID`, `mechID`, `totalInternalTonnage`, `weaponTonnage`, `internalStructureTonnage`, `internalStructureCriticals`, `engineTonnage`, `engineCriticals`, `gyroTonnage`, `gyroCriticals`, `cockpitTonnage`, `cockpitCriticals`, `heatSinkType`, `heatSinksNum`, `heatSinksTonnage`, `heatSinksCriticals`, `enhancementsTonnage`, `enhancementsCriticals`, `jumpJetsNum`, `jumpJetsTonnage`, `jumpJetsCriticals`) VALUES
(1, 1, 26.5, 2, 3, 0, 11.5, 6, 3, 4, 3, 5, 'Singles', 10, 0, 1, 0, 0, 8, 4, 8),
(2, 2, 54, 9, 7, 0, 16, 6, 3, 4, 3, 5, 'Singles', 22, 12, 11, 0, 0, 4, 4, 4),
(3, 3, 53, 2, 9, 0, 33, 6, 4, 4, 3, 5, 'Singles', 12, 2, 0, 0, 0, 0, 0, 0),
(4, 4, 81, 36, 10, 0, 19, 6, 3, 4, 3, 5, 'Singles', 20, 10, 9, 0, 0, 0, 0, 0),
(30, 30, 57, 12, 7, 0, 16, 6, 3, 4, 3, 5, 'Singles', 22, 12, 11, 0, 0, 4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `mechleg`
--

CREATE TABLE IF NOT EXISTS `mechleg` (
  `mechLegID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `partLeftorRight` int(11) NOT NULL,
  `totalSlots` int(11) NOT NULL,
  `totalSlotsAvailable` int(11) NOT NULL,
  `slotsUnmovable` int(11) NOT NULL,
  `slot1` varchar(255) NOT NULL,
  `slot2` varchar(255) NOT NULL,
  `slot3` varchar(255) NOT NULL,
  `slot4` varchar(255) NOT NULL,
  `slot5` varchar(255) NOT NULL,
  `slot6` varchar(255) NOT NULL,
  `armorPoints` int(11) NOT NULL,
  `armorMax` int(11) NOT NULL,
  PRIMARY KEY (`mechLegID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mechleg`
--

INSERT INTO `mechleg` (`mechLegID`, `mechID`, `partLeftorRight`, `totalSlots`, `totalSlotsAvailable`, `slotsUnmovable`, `slot1`, `slot2`, `slot3`, `slot4`, `slot5`, `slot6`, `armorPoints`, `armorMax`) VALUES
(1, 1, 0, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 6, 14),
(2, 1, 1, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 6, 14),
(3, 2, 0, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 26, 30),
(4, 2, 1, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 26, 30),
(5, 3, 0, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 17, 38),
(6, 3, 1, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 17, 38),
(7, 4, 1, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 41, 42),
(8, 4, 0, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 41, 42),
(30, 30, 0, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 28, 30),
(31, 30, 1, 6, 2, 4, 'Hip', 'Upper Leg Actuator', 'Lower Leg Actuator', 'Foot Actuator', '', '', 28, 30);

-- --------------------------------------------------------

--
-- Table structure for table `mechs`
--

CREATE TABLE IF NOT EXISTS `mechs` (
  `mechID` int(11) NOT NULL AUTO_INCREMENT,
  `mechName` varchar(60) NOT NULL,
  `modelNum` varchar(255) NOT NULL,
  `armor` int(11) NOT NULL,
  `members_memberID` int(11) NOT NULL,
  `customName` varchar(255) NOT NULL,
  `factionMostUsedBy` varchar(255) NOT NULL,
  `tonnage` int(11) NOT NULL,
  `maxTonnage` int(11) NOT NULL,
  `introDate` int(11) NOT NULL,
  `omniMech` int(11) NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `mechLogoSrc` varchar(50) NOT NULL,
  PRIMARY KEY (`mechID`),
  UNIQUE KEY `mechID` (`mechID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `mechs`
--

INSERT INTO `mechs` (`mechID`, `mechName`, `modelNum`, `armor`, `members_memberID`, `customName`, `factionMostUsedBy`, `tonnage`, `maxTonnage`, `introDate`, `omniMech`, `editable`, `mechLogoSrc`) VALUES
(1, 'Spider', 'SDR-5V', 108, 0, '', 'Various', 30, 30, 2650, 0, 0, 'images/spiderLogo.gif'),
(2, 'Grasshopper', 'GHR-5H', 125, 0, '', 'Various', 70, 70, 2780, 0, 0, 'images/grasshopperLogo.jpg'),
(3, 'Cyclops', 'CP-10-Z', 160, 0, '', 'Various', 90, 90, 2710, 0, 0, 'images/cyclops.jpg'),
(4, 'Atlas', 'AS7-D', 306, 0, '', 'Various', 100, 100, 2755, 0, 0, 'images/atlas.jpg'),
(30, 'Grasshopper Custom', 'GHR-Cust-1', 125, 1, 'Magnus-Custom', 'Hounds', 70, 70, 3025, 0, 1, 'images/customMechLogo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mechtorso`
--

CREATE TABLE IF NOT EXISTS `mechtorso` (
  `mechTorsoID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `partLeftorRight` int(11) NOT NULL,
  `totalSlots` int(11) NOT NULL,
  `totalSlotsAvailable` int(11) NOT NULL,
  `slotsUnmovable` int(11) NOT NULL,
  `slot1` varchar(255) NOT NULL,
  `slot2` varchar(255) NOT NULL,
  `slot3` varchar(255) NOT NULL,
  `slot4` varchar(255) NOT NULL,
  `slot5` varchar(255) NOT NULL,
  `slot6` varchar(255) NOT NULL,
  `slot7` varchar(255) NOT NULL,
  `slot8` varchar(255) NOT NULL,
  `slot9` varchar(255) NOT NULL,
  `slot10` varchar(255) NOT NULL,
  `slot11` varchar(50) NOT NULL,
  `slot12` varchar(50) NOT NULL,
  `armorPoints` int(11) NOT NULL,
  `armorMax` int(11) NOT NULL,
  PRIMARY KEY (`mechTorsoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mechtorso`
--

INSERT INTO `mechtorso` (`mechTorsoID`, `mechID`, `partLeftorRight`, `totalSlots`, `totalSlotsAvailable`, `slotsUnmovable`, `slot1`, `slot2`, `slot3`, `slot4`, `slot5`, `slot6`, `slot7`, `slot8`, `slot9`, `slot10`, `slot11`, `slot12`, `armorPoints`, `armorMax`) VALUES
(1, 1, 0, 12, 12, 0, '', '', '', '', '', '', '', '', '', '', '', '', 6, 14),
(2, 1, 1, 12, 12, 0, '', '', '', '', '', '', '', '', '', '', '', '', 6, 14),
(3, 2, 0, 12, 11, 0, 'Medium Laser', '', '', '', '', '', '', '', '', '', '', '', 20, 30),
(4, 2, 1, 12, 11, 0, 'Medium Laser', '', '', '', '', '', '', '', '', '', '', '', 20, 30),
(5, 3, 1, 12, 12, 0, '', '', '', '', '', '', '', '', '', '', '', '', 20, 38),
(6, 3, 0, 12, 12, 0, '', '', '', '', '', '', '', '', '', '', '', '', 20, 38),
(7, 4, 0, 12, 1, 0, 'Autocannon 20', 'overflow', 'overflow', 'overflow', 'overflow', 'overflow', 'overflow', 'overflow', 'overflow', 'overflow', 'SRM-6 Ammo', '', 32, 42),
(8, 4, 1, 12, 3, 0, 'LRM-20', 'overflow', 'overflow', 'overflow', 'overflow', 'LRM-20 Ammo', 'Autocannon 20 Ammo', 'Autocannon 20 Ammo', 'LRM-20 Ammo', '', '', '', 32, 42),
(30, 30, 0, 12, 10, 0, 'Medium Laser', 'Medium Laser', '', '', '', '', '', '', '', '', '', '', 24, 30),
(31, 30, 1, 12, 11, 0, 'Medium Laser', '', '', '', '', '', '', '', '', '', '', '', 24, 30);

-- --------------------------------------------------------

--
-- Table structure for table `mechtorsocenter`
--

CREATE TABLE IF NOT EXISTS `mechtorsocenter` (
  `mechTorsoID` int(11) NOT NULL AUTO_INCREMENT,
  `mechID` int(11) NOT NULL,
  `totalSlots` int(11) NOT NULL,
  `totalSlotsAvailable` int(11) NOT NULL,
  `slotsUnmovable` int(11) NOT NULL,
  `slot1` varchar(255) NOT NULL,
  `slot2` varchar(255) NOT NULL,
  `slot3` varchar(255) NOT NULL,
  `slot4` varchar(255) NOT NULL,
  `slot5` varchar(255) NOT NULL,
  `slot6` varchar(255) NOT NULL,
  `slot7` varchar(255) NOT NULL,
  `slot8` varchar(255) NOT NULL,
  `slot9` varchar(255) NOT NULL,
  `slot10` varchar(255) NOT NULL,
  `slot11` varchar(50) NOT NULL,
  `slot12` varchar(50) NOT NULL,
  `armorPoints` int(11) NOT NULL,
  `armorMax` int(11) NOT NULL,
  `partLeftorRight` int(11) NOT NULL,
  PRIMARY KEY (`mechTorsoID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mechtorsocenter`
--

INSERT INTO `mechtorsocenter` (`mechTorsoID`, `mechID`, `totalSlots`, `totalSlotsAvailable`, `slotsUnmovable`, `slot1`, `slot2`, `slot3`, `slot4`, `slot5`, `slot6`, `slot7`, `slot8`, `slot9`, `slot10`, `slot11`, `slot12`, `armorPoints`, `armorMax`, `partLeftorRight`) VALUES
(1, 1, 12, 2, 10, 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', 'Gyro', 'Gyro', 'Gyro', 'Gyro', 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', '', '', 8, 20, 2),
(2, 2, 12, 0, 10, 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', 'Gyro', 'Gyro', 'Gyro', 'Gyro', 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', 'Large Laser', 'overflow', 30, 44, 2),
(3, 3, 12, 2, 10, 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', 'Gyro', 'Gyro', 'Gyro', 'Gyro', 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', '', '', 30, 58, 2),
(4, 4, 12, 2, 10, 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', 'Gyro', 'Gyro', 'Gyro', 'Gyro', 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', '', '', 47, 62, 2),
(30, 30, 12, 2, 10, 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', 'Gyro', 'Gyro', 'Gyro', 'Gyro', 'Fusion Engine', 'Fusion Engine', 'Fusion Engine', '', '', 32, 44, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mechweapons`
--

CREATE TABLE IF NOT EXISTS `mechweapons` (
  `weaponID` int(11) NOT NULL AUTO_INCREMENT,
  `weaponName` varchar(255) NOT NULL,
  `damage` int(11) NOT NULL,
  `heat` int(11) NOT NULL,
  `rangeMin` int(11) NOT NULL,
  `rangeShort` int(11) NOT NULL,
  `rangeMed` int(11) NOT NULL,
  `rangeLong` int(11) NOT NULL,
  `tons` float NOT NULL,
  `slotsRequired` int(11) NOT NULL,
  `ammoNeeded` varchar(20) NOT NULL,
  `weaponType` varchar(20) NOT NULL,
  `availableDate` int(11) DEFAULT NULL,
  PRIMARY KEY (`weaponID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `mechweapons`
--

INSERT INTO `mechweapons` (`weaponID`, `weaponName`, `damage`, `heat`, `rangeMin`, `rangeShort`, `rangeMed`, `rangeLong`, `tons`, `slotsRequired`, `ammoNeeded`, `weaponType`, `availableDate`) VALUES
(1, 'Small Laser', 3, 1, 0, 1, 2, 3, 0.5, 1, 'None', 'Directed Energy', 2300),
(2, 'Medium Laser', 5, 3, 0, 3, 6, 9, 1, 1, 'None', 'Directed Energy', 2300),
(3, 'Large Laser', 8, 8, 0, 5, 10, 15, 5, 2, 'None', 'Directed Energy', 2430),
(4, 'PPC', 10, 10, 3, 6, 12, 18, 7, 3, 'None', 'Directed Energy', 2460),
(5, 'Flamer', 2, 3, 0, 1, 2, 3, 1, 1, 'None', 'Directed Energy', 2025),
(6, 'Vehicle Flamer', 2, 3, 0, 1, 2, 3, 0.5, 1, 'Vehicle Flamer Ammo', 'Directed Energy', 2025),
(7, 'Machine Gun', 2, 0, 0, 1, 2, 3, 0.5, 1, 'Machine Gun Ammo', 'Ballistic', 1950),
(8, 'Autocannon 2', 2, 1, 4, 8, 16, 24, 6, 1, 'Autocannon 2 Ammo', 'Ballistic', 2300),
(9, 'Autocannon 5', 5, 1, 3, 6, 12, 18, 8, 4, 'Autocannon 5 Ammo', 'Ballistic', 2250),
(10, 'Autocannon 10', 10, 3, 0, 5, 10, 15, 12, 7, 'Autocannon 10 Ammo', 'Ballistic', 2460),
(11, 'Autocannon 20', 20, 7, 0, 3, 6, 9, 14, 10, 'Autocannon 20 Ammo', 'Ballistic', 2500),
(12, 'SRM-2', 2, 2, 0, 3, 6, 9, 1, 1, 'SRM-2 Ammo', 'Missile', 2370),
(13, 'SRM-4', 4, 3, 0, 3, 6, 9, 2, 1, 'SRM-4 Ammo', 'Missile', 2370),
(14, 'SRM-6', 6, 4, 0, 3, 6, 9, 3, 2, 'SRM-6 Ammo', 'Missile', 2370),
(15, 'LRM-5', 5, 2, 6, 7, 14, 21, 2, 1, 'LRM-5 Ammo', 'Missile', 2400),
(16, 'LRM-10', 10, 2, 6, 7, 14, 21, 5, 2, 'LRM-10 Ammo', 'Missile', 2400),
(17, 'LRM-15', 15, 5, 6, 7, 14, 21, 7, 3, 'LRM-15 Ammo', 'Missile', 2400),
(18, 'LRM-20', 20, 6, 6, 7, 14, 21, 10, 5, 'LRM-20 Ammo', 'Missile', 2400),
(19, 'SRM-2 Ammo', 2, 0, 0, 3, 6, 9, 1, 1, 'N/A', 'Ammo', 2370),
(20, 'SRM-4 Ammo', 4, 0, 0, 3, 6, 9, 1, 1, 'N/A', 'Ammo', 2370),
(21, 'SRM-6 Ammo', 6, 0, 0, 3, 6, 9, 1, 1, 'N/A', 'Ammo', 2370),
(22, 'LRM-5 Ammo', 5, 0, 6, 7, 14, 21, 1, 1, 'N/A', 'Ammo', 2300),
(23, 'LRM-10 Ammo', 10, 0, 6, 7, 14, 21, 1, 1, 'N/A', 'Ammo', 2300),
(24, 'LRM-15 Ammo', 15, 0, 6, 7, 14, 21, 1, 1, 'N/A', 'Ammo', 2300),
(25, 'LRM-20 Ammo', 20, 0, 6, 7, 14, 21, 1, 1, 'N/A', 'Ammo', 2300),
(26, 'Autocannon 2 Ammo', 2, 1, 4, 8, 16, 24, 1, 1, 'N/A', 'Ammo', 2300),
(27, 'Autocannon 5 Ammo', 5, 0, 3, 6, 12, 18, 1, 1, 'N/A', 'Ammo', 2250),
(28, 'Autocannon 10 Ammo', 10, 0, 0, 5, 10, 15, 1, 1, 'N/A', 'Ammo', 2460),
(29, 'Autocannon 20 Ammo', 20, 0, 0, 3, 6, 9, 1, 1, 'N/A', 'Ammo', 2500),
(30, 'Machine Gun Ammo', 2, 0, 0, 1, 2, 3, 1, 1, 'N/A', 'Ammo', 1950),
(31, 'Vehicle Flamer Ammo', 2, 0, 0, 1, 2, 3, 1, 1, 'N/A', 'Ammo', 1950);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(65) NOT NULL DEFAULT '',
  `password` varchar(65) NOT NULL DEFAULT '',
  `email` varchar(65) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `email`) VALUES
(1, 'john', '1234', 'john@john.com'),
(2, 'joe', 'asd', 'jo3@asd'),
(8, 'hope12', '12', ''),
(45, 'fgh', 'asd', 'ads'),
(46, 'this', '1234', ''),
(47, 'hobo', '1234', ''),
(48, 'shimmy', 'password', 'shimmy@shimsham'),
(49, 'joeBOB', '1234', ''),
(50, 'joejoe', 'shiggy', ''),
(51, 'shak', 'shak', ''),
(52, 'joejoebrigss', 'aiop', ''),
(53, 'keykey', 'key', ''),
(54, 'nathan', '1234', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
