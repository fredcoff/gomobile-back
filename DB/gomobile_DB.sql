/* SQL Manager Lite for MySQL                              5.7.2.52112 */
/* ------------------------------------------------------------------- */
/* Host     : localhost                                                */
/* Port     : 3306                                                     */
/* Database : gomobile                                                 */


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES 'utf8' */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `gomobile`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `gomobile`;

/* Structure for the `admin_info` table : */

CREATE TABLE `admin_info` (
  `idx` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `admin_id` VARCHAR(50) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `admin_password` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY USING BTREE (`idx`)
) ENGINE=InnoDB
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

/* Structure for the `test_result_info` table : */

CREATE TABLE `test_result_info` (
  `idx` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `user_email` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` TINYINT(4) NOT NULL DEFAULT 0,
  `test_result` TEXT COLLATE utf8_general_ci NOT NULL,
  `reg_date` VARCHAR(30) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY USING BTREE (`idx`)
) ENGINE=InnoDB
AUTO_INCREMENT=1 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

/* Structure for the `user_info` table : */

CREATE TABLE `user_info` (
  `idx` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `first_name` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `last_name` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `password` VARCHAR(100) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `device_id` VARCHAR(200) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `product_id` TINYINT(4) NOT NULL DEFAULT 1,
  `wifi_product_id` TINYINT(4) NOT NULL DEFAULT 1,
  `activated` TINYINT(4) NOT NULL DEFAULT 1,
  `reg_date` VARCHAR(20) COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY USING BTREE (`idx`)
) ENGINE=InnoDB
AUTO_INCREMENT=2 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
;

/* Data for the `admin_info` table  (LIMIT 0,500) */

INSERT INTO `admin_info` (`idx`, `admin_id`, `admin_password`) VALUES
  (1,'admin','admin');
COMMIT;

/* Data for the `test_result_info` table  (LIMIT 0,500) */

INSERT INTO `test_result_info` (`idx`, `user_email`, `type`, `test_result`, `reg_date`) VALUES
  (1,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 18:02:26 PM'),
  (2,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 18:07:09 PM'),
  (3,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 07:06:53 PM'),
  (4,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 07:07:20 PM'),
  (5,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 07:08:33 PM'),
  (6,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":0,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:15:10 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":4}','18/05/2019 07:15:41 PM'),
  (7,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":0,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"0.00m\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":2,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:15:13 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":4}','18/05/2019 07:16:00 PM'),
  (8,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":0,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"84.31m\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":3,\"nLatitude\":39.3968,\"nLongitude\":116.40879833333335,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:15:16 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 07:16:15 PM'),
  (9,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":1,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"42.16m\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":5,\"nLatitude\":39.3983,\"nLongitude\":116.41029833333334,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:15:20 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\",\"nType\":0}','18/05/2019 07:17:10 PM'),
  (10,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:20:22 PM'),
  (11,'test1@test.com',0,'{\"bIsLte\":false,\"nGsmDbm\":-1,\"nGsmSS\":-1,\"nLteDbm\":-1,\"nLteSS\":-1,\"nWifiSS\":31,\"strDistFrom\":\"\",\"strIP\":\"192.168.232.2\",\"strLinkSpeed\":\"52Mbps\",\"strMAC\":\"02:00:00:00:00:00\",\"strSSID\":\"AndroidWifi\",\"bIsMobile\":false,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:20:07 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:21:00 PM'),
  (12,'test1@test.com',0,'{\"bIsLte\":false,\"nGsmDbm\":-1,\"nGsmSS\":-1,\"nLteDbm\":-1,\"nLteSS\":-1,\"nWifiSS\":31,\"strDistFrom\":\"126.47m\",\"strIP\":\"192.168.232.2\",\"strLinkSpeed\":\"52Mbps\",\"strMAC\":\"02:00:00:00:00:00\",\"strSSID\":\"AndroidWifi\",\"bIsMobile\":false,\"nAltitude\":5.0,\"nIdx\":2,\"nLatitude\":39.39619999999999,\"nLongitude\":116.40819833333335,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:20:10 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:21:09 PM'),
  (13,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":0,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:15:10 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:22:09 PM'),
  (14,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 01:27:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:23:31 PM'),
  (15,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":0,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:15:10 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:23:56 PM'),
  (16,'test1@test.com',4,'{\"bIsLte\":true,\"nCallDrop\":0,\"nGsmDbm\":-89,\"nGsmSS\":12,\"nLteDbm\":-100,\"nLteSS\":26,\"strDistFrom\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"nType\":4,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:25:12 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:26:22 PM'),
  (17,'test1@test.com',1,'{\"nDownloadRate\":1.2579205588595489E7,\"nLatency\":176,\"nTestCount\":1,\"nUploadRate\":1.1078855389984412E7,\"strAvgDownloadRates\":\"\",\"strAvgPings\":\"\",\"strAvgUploadRates\":\"\",\"strEndDateTime\":\"19/05/2019 03:28:48 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3968,\"nLongitude\":116.40879833333335,\"nType\":1,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:28:37 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:29:05 PM'),
  (18,'test1@test.com',1,'{\"nDownloadRate\":1.2579205588595489E7,\"nLatency\":176,\"nTestCount\":1,\"nUploadRate\":1.1078855389984412E7,\"strAvgDownloadRates\":\"\",\"strAvgPings\":\"\",\"strAvgUploadRates\":\"\",\"strEndDateTime\":\"19/05/2019 03:28:48 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3968,\"nLongitude\":116.40879833333335,\"nType\":1,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:28:37 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:31:40 PM'),
  (19,'test1@test.com',1,'{\"nDownloadRate\":1.2544804322738843E7,\"nLatency\":176,\"nTestCount\":1,\"nTestInterval\":0,\"nUploadRate\":9404350.554763636,\"strAvgDownloadRates\":\"\",\"strAvgPings\":\"\",\"strAvgUploadRates\":\"\",\"strEndDateTime\":\"19/05/2019 03:32:19 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.396499999999996,\"nLongitude\":116.40849833333334,\"nType\":1,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:32:09 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:32:46 PM'),
  (20,'test1@test.com',2,'{\"nDownloadRate\":1.2278150187774582E7,\"nLatency\":173,\"nTestCount\":2,\"nTestInterval\":0,\"nUploadRate\":1.0512817625345455E7,\"strAvgDownloadRates\":\".2f,.2f\",\"strAvgPings\":\".2f,.2f\",\"strAvgUploadRates\":\".2f,.2f\",\"strEndDateTime\":\"19/05/2019 03:33:23 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":2,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"nType\":2,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:33:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:33:53 PM'),
  (21,'test1@test.com',2,'{\"nDownloadRate\":1.2278150187774582E7,\"nLatency\":173,\"nTestCount\":2,\"nTestInterval\":0,\"nUploadRate\":1.0512817625345455E7,\"strAvgDownloadRates\":\".2f,.2f\",\"strAvgPings\":\".2f,.2f\",\"strAvgUploadRates\":\".2f,.2f\",\"strEndDateTime\":\"19/05/2019 03:33:23 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":2,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"nType\":2,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:33:02 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:40:44 PM'),
  (22,'test1@test.com',3,'{\"nDownloadRate\":7921806.181310125,\"nLatency\":172,\"nTestCount\":3,\"nTestInterval\":6,\"nUploadRate\":1.0899738475508228E7,\"strAvgDownloadRates\":\".2f,.2f,.2f\",\"strAvgPings\":\".2f,.2f,.2f\",\"strAvgUploadRates\":\".2f,.2f,.2f\",\"strEndDateTime\":\"19/05/2019 03:35:10 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":3,\"nLatitude\":39.415099999999995,\"nLongitude\":116.42709833333335,\"nType\":3,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:34:14 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 07:40:53 PM'),
  (23,'test1@test.com',3,'{\"nDownloadRate\":7921806.181310125,\"nLatency\":172,\"nTestCount\":3,\"nTestInterval\":6,\"nUploadRate\":1.0899738475508228E7,\"strAvgDownloadRates\":\".2f,.2f,.2f\",\"strAvgPings\":\".2f,.2f,.2f\",\"strAvgUploadRates\":\".2f,.2f,.2f\",\"strEndDateTime\":\"19/05/2019 03:35:10 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":3,\"nLatitude\":39.415099999999995,\"nLongitude\":116.42709833333335,\"nType\":3,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 03:34:14 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 08:40:48 PM'),
  (24,'test1@test.com',3,'{\"nDownloadRate\":4934740.111230056,\"nLatency\":173,\"nTestCount\":5,\"nTestInterval\":10,\"nUploadRate\":1.0030498194806857E7,\"strAvgDownloadRates\":\"12354912.56,12318787.99,0.00,0.00,0.00\",\"strAvgPings\":\"176,174,173,173,171\",\"strAvgUploadRates\":\"10907260.73,10241156.56,9113177.43,9525903.32,10364992.92\",\"strEndDateTime\":\"19/05/2019 04:30:19 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"nType\":3,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 04:28:53 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 08:41:01 PM'),
  (25,'test1@test.com',3,'{\"nDownloadRate\":7360928.318772815,\"nLatency\":169,\"nTestCount\":5,\"nTestInterval\":10,\"nUploadRate\":1.130954647179844E7,\"strAvgDownloadRates\":\"12344547.90,12269448.95,0.00,12190644.74,0.00\",\"strAvgPings\":\"171,170,170,169,169\",\"strAvgUploadRates\":\"11498870.14,9955567.20,12295154.47,11352376.74,11445763.80\",\"strEndDateTime\":\"19/05/2019 04:38:19 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":2,\"nLatitude\":39.5147,\"nLongitude\":116.52669833333334,\"nType\":3,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 04:35:32 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 08:41:08 PM'),
  (26,'test1@test.com',2,'{\"nDownloadRate\":1.217448256160327E7,\"nLatency\":174,\"nTestCount\":2,\"nTestInterval\":0,\"nUploadRate\":9842459.467111686,\"strAvgDownloadRates\":\"12.19,12.16\",\"strAvgPings\":\"175,174\",\"strAvgUploadRates\":\"9.57,10.12\",\"strEndDateTime\":\"19/05/2019 04:45:39 AM\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":1,\"nLatitude\":39.3953,\"nLongitude\":116.40729833333334,\"nType\":2,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 04:45:18 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 08:46:38 PM'),
  (27,'test1@test.com',0,'{\"bIsLte\":true,\"nGsmDbm\":-53,\"nGsmSS\":30,\"nLteDbm\":-80,\"nLteSS\":39,\"nWifiSS\":-1,\"strDistFrom\":\"\",\"strIP\":\"\",\"strLinkSpeed\":\"\",\"strMAC\":\"\",\"strSSID\":\"\",\"bIsMobile\":true,\"nAltitude\":5.0,\"nIdx\":0,\"nLatitude\":39.394999999999996,\"nLongitude\":116.40699833333335,\"nType\":0,\"strCarrier\":\"Android\",\"strComments\":\"\",\"strDateTime\":\"19/05/2019 05:24:00 AM\",\"strDevice\":\"Android SDK built for x86\",\"strPlace\":\"vehicle\",\"strUser\":\"test1@test.com\"}','18/05/2019 09:39:40 PM');
COMMIT;

/* Data for the `user_info` table  (LIMIT 0,500) */

INSERT INTO `user_info` (`idx`, `email`, `first_name`, `last_name`, `password`, `device_id`, `product_id`, `wifi_product_id`, `activated`, `reg_date`) VALUES
  (1,'test1@test.com','test1','test1','test1test1','dea0a23a27889be1225d3034d81b8f50f8cb7412f02604d684946aa969a9fd00adb5294eb24a2f3a236e7489223bd7f8',1,1,1,'2019-05-15  03:26:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;