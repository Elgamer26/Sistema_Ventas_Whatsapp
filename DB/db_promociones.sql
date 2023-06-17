/*
 Navicat Premium Data Transfer

 Source Server         : Mysql
 Source Server Type    : MySQL
 Source Server Version : 80028
 Source Host           : localhost:3306
 Source Schema         : db_promociones

 Target Server Type    : MySQL
 Target Server Version : 80028
 File Encoding         : 65001

 Date: 01/11/2022 09:28:46
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for agg_cart
-- ----------------------------
DROP TABLE IF EXISTS `agg_cart`;
CREATE TABLE `agg_cart`  (
  `cliente_id` int NULL DEFAULT NULL,
  `producto_id` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `promocion` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo_promo` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `porcentaje` int NULL DEFAULT NULL,
  `descuento_promo` decimal(10, 2) NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `sale` int NULL DEFAULT NULL,
  INDEX `cliente_id`(`cliente_id`) USING BTREE,
  INDEX `producto_id`(`producto_id`) USING BTREE,
  CONSTRAINT `agg_cart_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `agg_cart_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of agg_cart
-- ----------------------------

-- ----------------------------
-- Table structure for banco
-- ----------------------------
DROP TABLE IF EXISTS `banco`;
CREATE TABLE `banco`  (
  `id_banco` int NOT NULL AUTO_INCREMENT,
  `nombre_banco` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_banco`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banco
-- ----------------------------
INSERT INTO `banco` VALUES (1, 'Pichincha', 1);
INSERT INTO `banco` VALUES (2, 'GUAYAQUIL', 1);
INSERT INTO `banco` VALUES (3, 'Machala', 1);

-- ----------------------------
-- Table structure for calificacion
-- ----------------------------
DROP TABLE IF EXISTS `calificacion`;
CREATE TABLE `calificacion`  (
  `id_calificacion` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NULL DEFAULT NULL,
  `calificar` char(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `detalle` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `fecha` datetime(0) NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_calificacion`) USING BTREE,
  INDEX `id_cliente`(`id_cliente`) USING BTREE,
  CONSTRAINT `calificacion_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of calificacion
-- ----------------------------
INSERT INTO `calificacion` VALUES (1, 1, 'Regular', 'regular', '2022-06-09 19:06:56', 1);
INSERT INTO `calificacion` VALUES (2, 1, 'Excelente', 'Excelente', '2022-06-09 19:06:12', 1);
INSERT INTO `calificacion` VALUES (3, 1, 'Excelente', 'Excelente', '2022-06-09 19:06:26', 1);
INSERT INTO `calificacion` VALUES (4, 1, 'Necesita Mejorar', 'Necesita Mejorar', '2022-06-09 20:06:17', 1);
INSERT INTO `calificacion` VALUES (5, 1, 'Regular', 'Regular', '2022-06-09 20:06:24', 1);
INSERT INTO `calificacion` VALUES (6, 1, 'Bueno', 'Bueno', '2022-06-09 20:06:28', 1);
INSERT INTO `calificacion` VALUES (7, 1, 'Muy Bueno', 'Muy Bueno', '2022-06-09 20:06:33', 1);
INSERT INTO `calificacion` VALUES (8, 1, 'Excelente', 'Excelente', '2022-06-09 20:06:36', 1);
INSERT INTO `calificacion` VALUES (9, 1, 'Regular', 'as', '2022-08-14 19:08:14', 1);

-- ----------------------------
-- Table structure for calificacion_producto
-- ----------------------------
DROP TABLE IF EXISTS `calificacion_producto`;
CREATE TABLE `calificacion_producto`  (
  `calificaion_pro_id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NULL DEFAULT NULL,
  `calificar` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `detalle` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `fecha` datetime(0) NULL DEFAULT NULL,
  `id_producto` int NULL DEFAULT NULL,
  PRIMARY KEY (`calificaion_pro_id`) USING BTREE,
  INDEX `id_cliente`(`id_cliente`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `calificacion_producto_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `calificacion_producto_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of calificacion_producto
-- ----------------------------
INSERT INTO `calificacion_producto` VALUES (1, 1, 'Excelente', 'me gusto el producto', '2022-07-09 10:07:41', 7);
INSERT INTO `calificacion_producto` VALUES (2, 1, 'Excelente', 'me sgusto', '2022-07-09 11:07:54', 7);
INSERT INTO `calificacion_producto` VALUES (3, 1, 'Excelente', 'me gusto', '2022-07-09 11:07:13', 4);
INSERT INTO `calificacion_producto` VALUES (4, 1, 'Excelente', 'uy Bueno', '2022-07-09 11:07:28', 4);
INSERT INTO `calificacion_producto` VALUES (5, 1, 'Excelente', 'Me gusto mucho el producto', '2022-07-25 20:07:30', 7);
INSERT INTO `calificacion_producto` VALUES (6, 1, 'Excelente', 'El producto esta bueno pero demora en llegar', '2022-07-25 20:07:47', 7);
INSERT INTO `calificacion_producto` VALUES (7, 1, 'Excelente', 'No me gusto el timpo de entrega', '2022-07-25 20:07:37', 7);
INSERT INTO `calificacion_producto` VALUES (8, 1, 'Excelente', 'Que mal servicio de entrega', '2022-07-25 20:07:53', 7);
INSERT INTO `calificacion_producto` VALUES (9, 1, 'Excelente', 'Me encanto el producto', '2022-07-26 11:07:59', 7);
INSERT INTO `calificacion_producto` VALUES (10, 1, 'Regular', 'Regular', '2022-08-03 09:08:29', 7);
INSERT INTO `calificacion_producto` VALUES (11, 1, 'Bueno', 'Bueno', '2022-08-03 09:08:34', 7);
INSERT INTO `calificacion_producto` VALUES (12, 1, 'Muy Bueno', 'Muy Bueno', '2022-08-03 09:08:39', 7);
INSERT INTO `calificacion_producto` VALUES (13, 1, 'Excelente', 'Excelente', '2022-08-03 09:08:42', 7);
INSERT INTO `calificacion_producto` VALUES (14, 1, 'Necesita Mejorar', 'Necesita Mejorar', '2022-08-03 09:08:13', 7);
INSERT INTO `calificacion_producto` VALUES (15, 1, 'Necesita Mejorar', 'aaa', '2022-08-14 19:08:27', 5);

-- ----------------------------
-- Table structure for cliente
-- ----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente`  (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cedula` char(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `correo` char(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `direcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `sexo` char(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  `telefono` char(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ppassword` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `web` int NULL DEFAULT 0,
  PRIMARY KEY (`id_cliente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cliente
-- ----------------------------
INSERT INTO `cliente` VALUES (1, 'DON JOSE ', 'ZAVALA RAMIREZ', '0940321852', 'elgamer-26@hotmail.com', 'MILAGRO, AV. AMAZONAS', 'Masculino', 1, '0985906677', '123', 1);
INSERT INTO `cliente` VALUES (2, 'JOSE LUIS', 'ZAMORA LOPEZ', '0940321855', 'jennifferbarreto88@gmail.com', 'MILAGRO, AV PIÑAS', 'Masculino', 1, '0985906677', '123', 0);
INSERT INTO `cliente` VALUES (3, 'ANGEL GUARACA', 'LALAL LALAL', '0987654321', 'isabelguaman488@gmail.com', 'MILAGRO, AV PIÑAS', 'Masculino', 1, '099613057', '123', 0);
INSERT INTO `cliente` VALUES (33, 'MILTON', 'OCHOA ', '0940321854', 'eduardo2811@gmail.com', 'MILAGRO, AV. AMAZONAS', 'Masculino', 1, '0987654321', 'w4vjii0unj', 0);
INSERT INTO `cliente` VALUES (34, 'cliente web', 'de la web', '0940321800', 'eduardoaucancela2811@gmail.com', 'MILAGRO, AV PIÑAS', 'Masculino', 1, '0987654321', 'Webcien123+', 1);

-- ----------------------------
-- Table structure for compra
-- ----------------------------
DROP TABLE IF EXISTS `compra`;
CREATE TABLE `compra`  (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `id_proveedor` int NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `tipo_doc` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `numero_compra` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `iva` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  `sub_total` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `sub_iva` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_compra`) USING BTREE,
  INDEX `id_proveedor`(`id_proveedor`) USING BTREE,
  CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of compra
-- ----------------------------
INSERT INTO `compra` VALUES (7, 2, '2022-06-04', 'Factura', '20220418180441', 12, 3, 0, 80757.00, 90447.84, 9690.84);
INSERT INTO `compra` VALUES (8, 2, '2022-06-04', 'Factura', '20220418190415', 12, 4, 0, 168450.00, 188664.00, 20214.00);
INSERT INTO `compra` VALUES (9, 1, '2022-06-05', 'Factura', '20220604180616', 12, 1, 1, 12300.00, 13776.00, 1476.00);
INSERT INTO `compra` VALUES (10, 1, '2022-07-17', 'Boleta', '20220605190629', 0, 1, 1, 12.00, 0.00, 0.00);

-- ----------------------------
-- Table structure for detalle_compra
-- ----------------------------
DROP TABLE IF EXISTS `detalle_compra`;
CREATE TABLE `detalle_compra`  (
  `id_detalle_compra` int NOT NULL AUTO_INCREMENT,
  `id_compra` int NULL DEFAULT NULL,
  `id_producto` int NULL DEFAULT NULL,
  `cantidad` decimal(10, 2) NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `descuento` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_detalle_compra`) USING BTREE,
  INDEX `id_compra`(`id_compra`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_compra
-- ----------------------------
INSERT INTO `detalle_compra` VALUES (3, 7, 6, 100.00, 123.00, 0.00, 12300.00, 0);
INSERT INTO `detalle_compra` VALUES (4, 7, 5, 200.00, 321.00, 0.00, 64200.00, 0);
INSERT INTO `detalle_compra` VALUES (5, 7, 7, 99.00, 43.00, 0.00, 4257.00, 0);
INSERT INTO `detalle_compra` VALUES (6, 8, 7, 100.00, 123.00, 0.00, 12300.00, 0);
INSERT INTO `detalle_compra` VALUES (7, 8, 6, 200.00, 321.00, 0.00, 64200.00, 0);
INSERT INTO `detalle_compra` VALUES (8, 8, 5, 200.00, 432.00, 0.00, 86400.00, 0);
INSERT INTO `detalle_compra` VALUES (9, 8, 4, 50.00, 111.00, 0.00, 5550.00, 0);
INSERT INTO `detalle_compra` VALUES (10, 9, 1, 100.00, 123.00, 0.00, 12300.00, 1);
INSERT INTO `detalle_compra` VALUES (11, 10, 7, 1.00, 12.00, 0.00, 12.00, 1);

-- ----------------------------
-- Table structure for detalle_envios
-- ----------------------------
DROP TABLE IF EXISTS `detalle_envios`;
CREATE TABLE `detalle_envios`  (
  `detalle_envio_id` int NOT NULL AUTO_INCREMENT,
  `envio_id` int NULL DEFAULT NULL,
  `venta_online_id` int NULL DEFAULT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `refrencia` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `num_venta` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `valor` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`detalle_envio_id`) USING BTREE,
  INDEX `envio_id`(`envio_id`) USING BTREE,
  INDEX `venta_online_id`(`venta_online_id`) USING BTREE,
  CONSTRAINT `detalle_envios_ibfk_1` FOREIGN KEY (`envio_id`) REFERENCES `envios` (`envio_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_envios_ibfk_2` FOREIGN KEY (`venta_online_id`) REFERENCES `venta_online` (`id_venta_online_trans`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_envios
-- ----------------------------
INSERT INTO `detalle_envios` VALUES (7, 9, 13, 'aaaaaaaaa', 'bbbbbbbbbbbbb', '20220624090600', 4, 10.00);
INSERT INTO `detalle_envios` VALUES (8, 9, 14, 'aaaaaaaaa', 'bbbbbbbbbbb', '20220624140603', 4, 10.00);
INSERT INTO `detalle_envios` VALUES (9, 9, 15, 'zzzzzzz', 'xxxxxxxxxxx', '20220624150617', 1, 5.00);
INSERT INTO `detalle_envios` VALUES (10, 10, 16, 'gato111', 'aaa', '20220628110622', 1, 20.00);
INSERT INTO `detalle_envios` VALUES (11, 11, 19, 'Dirección', 'Referencia de ubicación', '20220628180600', 1, 10.00);
INSERT INTO `detalle_envios` VALUES (12, 11, 20, 'aaaaaaaaaaa', 'aaaaaaaa', '20220709120710', 1, 10.00);
INSERT INTO `detalle_envios` VALUES (13, 11, 21, 'MI CASA', 'FRENTE A MI CASA', '20220729190735', 1, 10.00);
INSERT INTO `detalle_envios` VALUES (14, 11, 22, 'aaaaaaa', 'bbbbbb', '20220729190718', 1, 10.00);
INSERT INTO `detalle_envios` VALUES (15, 12, 23, 'zzzzzzzzz', 'yyyyyyyyy', '20220729190703', 1, 12.00);
INSERT INTO `detalle_envios` VALUES (16, 12, 24, 'xxxxxxxxxxxxxx', 'wwwwwwwwwwwwwwww', '20220803100804', 1, 21.00);
INSERT INTO `detalle_envios` VALUES (17, 13, 25, 'NUEVA DIRECCION', 'NUEVA REFERENCIA', '20220803120826', 2, 30.00);
INSERT INTO `detalle_envios` VALUES (18, 14, 27, 'aaaaa', 'bbbbbbbb', '20220814090843', 2, 12.00);
INSERT INTO `detalle_envios` VALUES (19, 15, 26, 'aaaa', 'aaaaaaa', '20220812110843', 1, 1.00);
INSERT INTO `detalle_envios` VALUES (20, 15, 28, 'CCCC', 'CCCCCCCC', '20220814190856', 2, 1.00);
INSERT INTO `detalle_envios` VALUES (21, 15, 29, 'AA', 'AA', '20220814190815', 1, 1.00);
INSERT INTO `detalle_envios` VALUES (22, 16, 30, 'zzz', 'zz', '20220814190838', 1, 10.00);
INSERT INTO `detalle_envios` VALUES (23, 16, 31, 'mmm', 'mmm', '20220814190808', 1, 5.00);
INSERT INTO `detalle_envios` VALUES (24, 17, 32, 'AAA', 'BBB', '20220927140912', 2, 2.00);
INSERT INTO `detalle_envios` VALUES (25, 18, 33, 'CCCC', 'DDDD', '20220927140948', 1, 23.00);
INSERT INTO `detalle_envios` VALUES (26, 19, 34, 'EEEE', 'FFFF', '20220927140930', 2, 6.00);

-- ----------------------------
-- Table structure for detalle_separar_pro
-- ----------------------------
DROP TABLE IF EXISTS `detalle_separar_pro`;
CREATE TABLE `detalle_separar_pro`  (
  `id_detalle_separar_pro` int NOT NULL AUTO_INCREMENT,
  `id_separar_pro` int NULL DEFAULT NULL,
  `id_producto` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `descuento` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_separar_pro`) USING BTREE,
  INDEX `id_separar_pro`(`id_separar_pro`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `detalle_separar_pro_ibfk_1` FOREIGN KEY (`id_separar_pro`) REFERENCES `separar_producto` (`id_separar_prod`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_separar_pro
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_vent_pro
-- ----------------------------
DROP TABLE IF EXISTS `detalle_vent_pro`;
CREATE TABLE `detalle_vent_pro`  (
  `id_detalle_venta_pro` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NULL DEFAULT NULL,
  `id_producto` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `sale` int NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `tipo_oferta` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `des_pferta` decimal(10, 2) NULL DEFAULT NULL,
  `descuento` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_detalle_venta_pro`) USING BTREE,
  INDEX `id_venta`(`id_venta`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `detalle_vent_pro_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_vent_pro_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_vent_pro
-- ----------------------------
INSERT INTO `detalle_vent_pro` VALUES (1, 5, 1, 1, 1, 123.00, 'No promoción', 0.00, 0.00, 123.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (2, 6, 1, 1, 1, 123.00, 'No promoción', 0.00, 0.00, 123.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (3, 7, 4, 1, 3, 123.00, '3x1', 0.00, 0.00, 123.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (4, 7, 6, 1, 2, 231.00, '2x1', 0.00, 0.00, 231.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (5, 8, 1, 1, 1, 123.00, 'No promoción', 0.00, 0.00, 123.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (6, 8, 4, 1, 3, 123.00, '3x1', 0.00, 0.00, 123.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (7, 9, 5, 2, 2, 124.00, 'No promoción', 0.00, 0.00, 248.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (8, 9, 7, 2, 2, 123.00, 'No promoción', 0.00, 0.00, 246.00, 0);
INSERT INTO `detalle_vent_pro` VALUES (9, 10, 1, 1, 1, 123.00, 'No promoción', 0.00, 0.00, 123.00, 1);
INSERT INTO `detalle_vent_pro` VALUES (10, 11, 1, 2, 2, 123.00, 'No promoción', 0.00, 0.00, 246.00, 1);
INSERT INTO `detalle_vent_pro` VALUES (11, 11, 5, 1, 1, 124.00, 'Descuento', 12.40, 0.00, 111.60, 1);

-- ----------------------------
-- Table structure for detalle_venta_online
-- ----------------------------
DROP TABLE IF EXISTS `detalle_venta_online`;
CREATE TABLE `detalle_venta_online`  (
  `id_detalle_ventas_online` int NOT NULL AUTO_INCREMENT,
  `id_venta_online` int NULL DEFAULT NULL,
  `id_producto` int NULL DEFAULT NULL,
  `cantidad` decimal(10, 2) NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_detalle_ventas_online`) USING BTREE,
  INDEX `id_venta_online`(`id_venta_online`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `detalle_venta_online_ibfk_1` FOREIGN KEY (`id_venta_online`) REFERENCES `ventas_online` (`id_ventas_online`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_venta_online
-- ----------------------------

-- ----------------------------
-- Table structure for detalle_venta_online_transferencia
-- ----------------------------
DROP TABLE IF EXISTS `detalle_venta_online_transferencia`;
CREATE TABLE `detalle_venta_online_transferencia`  (
  `detalle_venta_online_transferencia_id` int NOT NULL AUTO_INCREMENT,
  `id_venta_online` int NULL DEFAULT NULL,
  `producto_id` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `descuento_oferta` decimal(10, 2) NULL DEFAULT NULL,
  `tipo_oferta` char(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `subtotal` decimal(10, 2) NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`detalle_venta_online_transferencia_id`) USING BTREE,
  INDEX `producto_id`(`producto_id`) USING BTREE,
  INDEX `detalle_venta_online_transferencia_ibfk_1`(`id_venta_online`) USING BTREE,
  CONSTRAINT `detalle_venta_online_transferencia_ibfk_1` FOREIGN KEY (`id_venta_online`) REFERENCES `venta_online` (`id_venta_online_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_venta_online_transferencia_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 54 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_venta_online_transferencia
-- ----------------------------
INSERT INTO `detalle_venta_online_transferencia` VALUES (23, 13, 1, 2, 123.00, 0.00, '2x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (24, 13, 4, 3, 123.00, 0.00, '3x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (25, 13, 5, 1, 124.00, 12.40, 'Descuento', 111.60, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (26, 13, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (27, 14, 1, 2, 123.00, 0.00, '2x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (28, 14, 4, 3, 123.00, 0.00, '3x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (29, 14, 5, 1, 124.00, 12.40, 'Descuento', 111.60, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (30, 14, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (31, 15, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (32, 16, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (34, 19, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (35, 20, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (36, 21, 4, 3, 123.00, 0.00, '3x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (37, 22, 5, 2, 124.00, 0.00, 'No oferta', 248.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (38, 23, 1, 2, 123.00, 0.00, '2x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (39, 24, 7, 1, 322.00, 0.00, 'No oferta', 322.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (40, 25, 5, 1, 124.00, 0.00, 'No oferta', 124.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (41, 25, 6, 1, 231.00, 0.00, 'No oferta', 231.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (42, 26, 1, 2, 123.00, 0.00, '2x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (43, 27, 5, 1, 124.00, 0.00, 'No oferta', 124.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (44, 27, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (45, 28, 6, 1, 231.00, 0.00, 'No oferta', 231.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (46, 28, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (47, 29, 5, 1, 124.00, 0.00, 'No oferta', 124.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (48, 30, 5, 1, 124.00, 0.00, 'No oferta', 124.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (49, 31, 1, 2, 123.00, 0.00, '2x1', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (50, 32, 1, 992, 123.00, 0.00, '2x1', 61008.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (51, 32, 4, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (52, 33, 5, 1, 124.00, 0.00, 'No oferta', 124.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (53, 34, 4, 1, 123.00, 0.00, 'No oferta', 123.00, 1);
INSERT INTO `detalle_venta_online_transferencia` VALUES (54, 34, 7, 1, 123.00, 0.00, 'No oferta', 123.00, 1);

-- ----------------------------
-- Table structure for detalle_venta_servicio
-- ----------------------------
DROP TABLE IF EXISTS `detalle_venta_servicio`;
CREATE TABLE `detalle_venta_servicio`  (
  `id_venta_servicio` int NULL DEFAULT NULL,
  `id_servicio` int NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `descuento` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  INDEX `id_venta_servicio`(`id_venta_servicio`) USING BTREE,
  INDEX `id_servicio`(`id_servicio`) USING BTREE,
  CONSTRAINT `detalle_venta_servicio_ibfk_1` FOREIGN KEY (`id_venta_servicio`) REFERENCES `venta_servicio` (`id_venta_servico`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `detalle_venta_servicio_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of detalle_venta_servicio
-- ----------------------------
INSERT INTO `detalle_venta_servicio` VALUES (3, 2, 1, 20.00, 0.00, 20.00);
INSERT INTO `detalle_venta_servicio` VALUES (3, 1, 1, 12.00, 0.00, 12.00);
INSERT INTO `detalle_venta_servicio` VALUES (4, 2, 1, 20.00, 0.00, 20.00);
INSERT INTO `detalle_venta_servicio` VALUES (4, 1, 2, 12.00, 0.00, 24.00);
INSERT INTO `detalle_venta_servicio` VALUES (4, 3, 3, 30.00, 0.00, 90.00);
INSERT INTO `detalle_venta_servicio` VALUES (5, 1, 1, 12.00, 0.00, 12.00);
INSERT INTO `detalle_venta_servicio` VALUES (6, 3, 1, 30.00, 0.00, 30.00);
INSERT INTO `detalle_venta_servicio` VALUES (7, 2, 2, 20.00, 0.00, 40.00);
INSERT INTO `detalle_venta_servicio` VALUES (7, 3, 2, 30.00, 0.00, 60.00);

-- ----------------------------
-- Table structure for efectivo
-- ----------------------------
DROP TABLE IF EXISTS `efectivo`;
CREATE TABLE `efectivo`  (
  `efectivo_id` int NOT NULL AUTO_INCREMENT,
  `id_venta_online` int NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `referencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `fecha` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `monto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 0,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `fecha_proceso` date NULL DEFAULT NULL,
  `detalle` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  PRIMARY KEY (`efectivo_id`) USING BTREE,
  INDEX `id_venta_online`(`id_venta_online`) USING BTREE,
  CONSTRAINT `efectivo_ibfk_1` FOREIGN KEY (`id_venta_online`) REFERENCES `venta_online` (`id_venta_online_trans`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of efectivo
-- ----------------------------
INSERT INTO `efectivo` VALUES (3, 19, 'Dirección', 'Referencia de ubicación', '2022-06-28', '137.76', 1, 'img/efectivo/IMG38202211374.png', '2022-08-03', '12345');
INSERT INTO `efectivo` VALUES (4, 22, 'aaaaaaa', 'bbbbbb', '2022-07-29', '277.76', 1, 'img/efectivo/IMG38202211344.png', '2022-08-03', '123');
INSERT INTO `efectivo` VALUES (5, 24, 'xxxxxxxxxxxxxx', 'wwwwwwwwwwwwwwww', '2022-08-03', '360.64', 1, 'img/efectivo/IMG382022124537.png', '2022-08-03', '321');
INSERT INTO `efectivo` VALUES (6, 25, 'NUEVA DIRECCION', 'NUEVA REFERENCIA', '2022-08-03', '397.60', 1, 'img/efectivo/IMG38202212497.png', '2022-08-03', '123');
INSERT INTO `efectivo` VALUES (7, 27, 'aaaaa', 'bbbbbbbb', '2022-08-14', '276.64', 1, 'img/efectivo/IMG1482022102340.jpeg', '2022-08-14', '30 de $10, 2 de $5');
INSERT INTO `efectivo` VALUES (8, 28, 'CCCC', 'CCCCCCCC', '2022-08-14', '396.48', 1, NULL, NULL, NULL);
INSERT INTO `efectivo` VALUES (9, 29, 'AA', 'AA', '2022-08-14', '138.88', 1, 'img/efectivo/IMG2792022142814.png', '2022-09-27', '123');
INSERT INTO `efectivo` VALUES (10, 30, 'zzz', 'zz', '2022-08-14', '138.88', 0, NULL, NULL, NULL);
INSERT INTO `efectivo` VALUES (11, 31, 'mmm', 'mmm', '2022-08-14', '137.76', 0, NULL, NULL, NULL);
INSERT INTO `efectivo` VALUES (12, 32, 'AAA', 'BBB', '2022-09-27', '68466.72', 0, NULL, NULL, NULL);
INSERT INTO `efectivo` VALUES (13, 33, 'CCCC', 'DDDD', '2022-09-27', '138.88', 1, 'img/efectivo/IMG2792022142245.png', '2022-09-27', '123');
INSERT INTO `efectivo` VALUES (14, 34, 'EEEE', 'FFFF', '2022-09-27', '275.52', 0, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for empresa
-- ----------------------------
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa`  (
  `empresa_id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ruc` char(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `telefono` char(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `propietario` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `iva` int NULL DEFAULT NULL,
  PRIMARY KEY (`empresa_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of empresa
-- ----------------------------
INSERT INTO `empresa` VALUES (1, 'INSETECH', '1234567890', 'MILAGRO', '0987654321', 'ISETECH_12@HOTMAIL.COM', 'EL JEFE', 'VENTA DE REPUESTOS DE PC', 'img/empresa/IMG46202292913.png', 12);

-- ----------------------------
-- Table structure for envios
-- ----------------------------
DROP TABLE IF EXISTS `envios`;
CREATE TABLE `envios`  (
  `envio_id` int NOT NULL AUTO_INCREMENT,
  `repartidor_id` int NULL DEFAULT NULL,
  `vehículo_id` int NULL DEFAULT NULL,
  `num_envio` char(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `fecha_envio` date NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `countt` int NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`envio_id`) USING BTREE,
  INDEX `repartidor_id`(`repartidor_id`) USING BTREE,
  INDEX `vehículo_id`(`vehículo_id`) USING BTREE,
  CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`repartidor_id`) REFERENCES `repartidor` (`repartidor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `envios_ibfk_2` FOREIGN KEY (`vehículo_id`) REFERENCES `vehiculo` (`id_vehiculo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of envios
-- ----------------------------
INSERT INTO `envios` VALUES (9, 3, 4, '20220719180700', '2022-07-19', 25.00, 3, 2);
INSERT INTO `envios` VALUES (10, 2, 3, '20220719190709', '2022-07-19', 20.00, 1, 1);
INSERT INTO `envios` VALUES (11, 3, 2, '20220729190742', '2022-07-29', 40.00, 4, 2);
INSERT INTO `envios` VALUES (12, 3, 1, '20220803110836', '2022-08-03', 33.00, 2, 2);
INSERT INTO `envios` VALUES (13, 3, 3, '20220803120804', '2022-08-03', 30.00, 1, 2);
INSERT INTO `envios` VALUES (14, 3, 1, '20220814090849', '2022-08-14', 12.00, 1, 2);
INSERT INTO `envios` VALUES (15, 3, 1, '20220815200831', '2022-08-15', 3.00, 3, 2);
INSERT INTO `envios` VALUES (16, 1, 2, '20220927140953', '2022-09-27', 15.00, 2, 1);
INSERT INTO `envios` VALUES (17, 1, 2, '20220927140910', '2022-09-27', 2.00, 1, 1);
INSERT INTO `envios` VALUES (18, 3, 3, '20220927140923', '2022-09-27', 23.00, 1, 2);
INSERT INTO `envios` VALUES (19, 2, 4, '20220927140935', '2022-09-27', 6.00, 1, 1);

-- ----------------------------
-- Table structure for marca
-- ----------------------------
DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca`  (
  `id_marca` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_marca`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of marca
-- ----------------------------
INSERT INTO `marca` VALUES (1, 'MARCA', 1);
INSERT INTO `marca` VALUES (2, 'DUREX', 1);
INSERT INTO `marca` VALUES (3, 'DURAMAX', 1);

-- ----------------------------
-- Table structure for ofertas
-- ----------------------------
DROP TABLE IF EXISTS `ofertas`;
CREATE TABLE `ofertas`  (
  `id_ofertas` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NULL DEFAULT NULL,
  `fecha_inicio` date NULL DEFAULT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `tipo_oferta` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `descuento` int NULL DEFAULT NULL,
  PRIMARY KEY (`id_ofertas`) USING BTREE,
  INDEX `id_producto`(`id_producto`) USING BTREE,
  CONSTRAINT `ofertas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ofertas
-- ----------------------------

-- ----------------------------
-- Table structure for permisos
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos`  (
  `permisos_id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NULL DEFAULT NULL,
  `usuario` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cliente` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `proveedor` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `datos_empresa` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `banco` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo_servicio` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `producto` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `compras` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `facturacion` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `calificacion` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ventas_online` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipos_pagos` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `envios` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `registro_promo` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `promo_vigentes` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `reportes` char(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`permisos_id`) USING BTREE,
  INDEX `usuario_id`(`usuario_id`) USING BTREE,
  CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permisos
-- ----------------------------
INSERT INTO `permisos` VALUES (1, 4, 'true', 'true', 'true', 'true', 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false');
INSERT INTO `permisos` VALUES (2, 1, 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true', 'true');
INSERT INTO `permisos` VALUES (3, 2, 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false');
INSERT INTO `permisos` VALUES (4, 3, 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false');
INSERT INTO `permisos` VALUES (6, 6, 'true', 'true', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false', 'false');

-- ----------------------------
-- Table structure for producto
-- ----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto`  (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `codigo` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombre_producto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `id_tipo_producto` int NULL DEFAULT NULL,
  `id_marca` int NULL DEFAULT NULL,
  `precio_venta` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `stock` int NULL DEFAULT NULL,
  `estado` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `eliminado` int NULL DEFAULT 1,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `oferta` int NULL DEFAULT 0,
  PRIMARY KEY (`id_producto`) USING BTREE,
  INDEX `id_tipo_producto`(`id_tipo_producto`) USING BTREE,
  INDEX `id_marca`(`id_marca`) USING BTREE,
  CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_tipo_producto`) REFERENCES `tipo_producto` (`id_tipo_produto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of producto
-- ----------------------------
INSERT INTO `producto` VALUES (1, '58714', 'CAMRA LUNEX editado', 4, 2, '123', 'img/prouducto/foto.jpg', 0, 'Agotado', 1, 'CAMARA DE ALTA CALIDAD editad', 0);
INSERT INTO `producto` VALUES (4, '4637312', 'CAMRA LUNEX 4', 2, 3, '123', 'img/prouducto/IMG462022195738.png', 992, 'Activo', 1, 'ASASA', 0);
INSERT INTO `producto` VALUES (5, '4310099', 'aa', 4, 3, '124', 'img/prouducto/foto.jpg', 115, 'Activo', 1, 'abbbbb', 0);
INSERT INTO `producto` VALUES (6, '9934263', 'ccccccccc', 1, 2, '231', 'img/prouducto/IMG462022195712.png', 998, 'Activo', 1, 'ddddddddd', 0);
INSERT INTO `producto` VALUES (7, '1583558', 'zzzzz', 1, 2, '123', 'img/prouducto/IMG462022195723.png', 318, 'Activo', 1, 'xxxxxxxxx', 0);

-- ----------------------------
-- Table structure for proveedor
-- ----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor`  (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `razon_social` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `ruc` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `telefono` char(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `encargado` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `sexo` char(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `descripcions` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_proveedor`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proveedor
-- ----------------------------
INSERT INTO `proveedor` VALUES (1, 'CLARO EDITA S.A.', '0987654321234', '0987654321', 'CALROEDITSA@HOTMAIL.COM', 'MILAGRO, AV PIÑAS', 'ROSA ANGELICA', 'Femenino', 'VENTA DE CLARO EDIT', 1);
INSERT INTO `proveedor` VALUES (2, 'EMPREXT', '1234567890987', '0987654321', 'EMPREXT@HOTMAIL.COM', 'GUAYAQUIL', 'ANGEL JOSE', 'Masculino', 'VENTA DE PC', 1);

-- ----------------------------
-- Table structure for repartidor
-- ----------------------------
DROP TABLE IF EXISTS `repartidor`;
CREATE TABLE `repartidor`  (
  `repartidor_id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cedula` char(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `telefono` char(15) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `correo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `direcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `sexo` char(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo_licencia` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  `usuario` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `passwordd` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `imagen` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`repartidor_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of repartidor
-- ----------------------------
INSERT INTO `repartidor` VALUES (1, 'DON ANDRES', 'ZAVALA RAMIREZ', '11111111111', '0987654321', 'CALROEDITSA@HOTMAIL.COM', 'MILAGRO, AV PIÑAS', 'Femenino', 'TIPO A', 1, 'lolo', 'aa', 'img/repartidor/repartidor.jpg');
INSERT INTO `repartidor` VALUES (2, 'DON CARLOS', 'DELGADO', '0940321850', '0985906677', 'EMPREXT@HOTMAIL.COM', 'MILAGRO, AV. AMAZONAS', 'Masculino', 'TIPO C', 1, 'aaaa', 'bbbbbbb', 'img/repartidor/repartidor.jpg');
INSERT INTO `repartidor` VALUES (3, 'DON ANDRES', 'RUIS ROJAS', '0940321852', '0985906677', '1EMPREXT@HOTMAIL.COM', 'MILAGRO, AV. AMAZONAS', 'Masculino', 'TIPO A', 1, 'admin123', '123', 'img/repartidor/IMG292022111957.jpeg');

-- ----------------------------
-- Table structure for separar_producto
-- ----------------------------
DROP TABLE IF EXISTS `separar_producto`;
CREATE TABLE `separar_producto`  (
  `id_separar_prod` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NULL DEFAULT NULL,
  `fecha` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_separar_prod`) USING BTREE,
  INDEX `id_cliente`(`id_cliente`) USING BTREE,
  CONSTRAINT `separar_producto_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of separar_producto
-- ----------------------------

-- ----------------------------
-- Table structure for servicio
-- ----------------------------
DROP TABLE IF EXISTS `servicio`;
CREATE TABLE `servicio`  (
  `id_servicio` int NOT NULL AUTO_INCREMENT,
  `servicio` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `precio` decimal(10, 2) NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_servicio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of servicio
-- ----------------------------
INSERT INTO `servicio` VALUES (1, 'INSTALCION DE CAMARAS', 12.00, 1);
INSERT INTO `servicio` VALUES (2, 'INSTALCION DE CABLE', 20.00, 1);
INSERT INTO `servicio` VALUES (3, 'SERVICIO TECNICO', 30.00, 1);

-- ----------------------------
-- Table structure for tipo_producto
-- ----------------------------
DROP TABLE IF EXISTS `tipo_producto`;
CREATE TABLE `tipo_producto`  (
  `id_tipo_produto` int NOT NULL AUTO_INCREMENT,
  `tipo_producto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_tipo_produto`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_producto
-- ----------------------------
INSERT INTO `tipo_producto` VALUES (1, 'NUEVO TIPOO', 1);
INSERT INTO `tipo_producto` VALUES (2, 'camaras', 1);
INSERT INTO `tipo_producto` VALUES (3, 'microfonos', 1);
INSERT INTO `tipo_producto` VALUES (4, 'cables', 1);

-- ----------------------------
-- Table structure for tipo_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario`  (
  `id_tipo_usuario` int NOT NULL AUTO_INCREMENT,
  `tipo_usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_tipo_usuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES (1, 'administrador', 1);
INSERT INTO `tipo_usuario` VALUES (2, 'vendedor', 1);
INSERT INTO `tipo_usuario` VALUES (12, 'cajerO', 1);
INSERT INTO `tipo_usuario` VALUES (13, 'cajero', 1);

-- ----------------------------
-- Table structure for transferencia
-- ----------------------------
DROP TABLE IF EXISTS `transferencia`;
CREATE TABLE `transferencia`  (
  `transferencia_id` int NOT NULL AUTO_INCREMENT,
  `id_venta_online` int NULL DEFAULT NULL,
  `tipo_banco` int NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `monto` decimal(10, 2) NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `fecha_deposito` date NULL DEFAULT NULL,
  `fecha_proceso` date NULL DEFAULT NULL,
  `codigo` char(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 0,
  PRIMARY KEY (`transferencia_id`) USING BTREE,
  INDEX `id_venta_online`(`id_venta_online`) USING BTREE,
  INDEX `tipo_banco`(`tipo_banco`) USING BTREE,
  CONSTRAINT `transferencia_ibfk_1` FOREIGN KEY (`id_venta_online`) REFERENCES `venta_online` (`id_venta_online_trans`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transferencia_ibfk_2` FOREIGN KEY (`tipo_banco`) REFERENCES `banco` (`id_banco`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transferencia
-- ----------------------------
INSERT INTO `transferencia` VALUES (11, 13, 1, '2022-06-24', 538.27, 'img/transferencia/IMG256202292753.png', '2022-06-25', '2022-06-25', '1234567890', 2);
INSERT INTO `transferencia` VALUES (12, 14, 1, '2022-06-24', 538.27, 'img/transferencia/IMG256202292343.png', '2022-06-25', '2022-06-25', '1234567890', 2);
INSERT INTO `transferencia` VALUES (13, 15, 2, '2022-06-24', 137.76, 'img/transferencia/IMG246202220548.png', '2022-06-24', '2022-06-25', '1234567890', 2);
INSERT INTO `transferencia` VALUES (14, 16, 2, '2022-06-28', 137.76, 'img/transferencia/IMG2862022111114.png', '2022-06-28', '2022-07-04', '1234567890', 2);
INSERT INTO `transferencia` VALUES (16, 20, 1, '2022-07-09', 137.76, 'img/transferencia/IMG2972022193049.jpeg', '2022-07-29', '2022-07-29', '0987654321', 2);
INSERT INTO `transferencia` VALUES (17, 21, 1, '2022-07-29', 137.76, 'img/transferencia/IMG297202219135.jpeg', '2022-07-29', '2022-07-29', '1234567890', 2);
INSERT INTO `transferencia` VALUES (18, 23, 1, '2022-07-29', 137.76, 'img/transferencia/IMG297202219373.jpeg', '2022-07-29', '2022-07-29', '1234567', 2);
INSERT INTO `transferencia` VALUES (19, 26, 1, '2022-08-12', 137.76, 'img/transferencia/IMG1282022111643.jpeg', '2022-08-12', '2022-08-14', '1234', 2);

-- ----------------------------
-- Table structure for usuario
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario`  (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `nombres` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `documento` char(13) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `id_tipo_usuario` int NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  INDEX `id_tipo_usuario`(`id_tipo_usuario`) USING BTREE,
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES (1, 'admin', '123', 'img/usuarios/IMG28202214259.jpg', 'JORGE MOISES', 'RAMIREZ ZAVALA', '0940321854', 1, 1);
INSERT INTO `usuario` VALUES (2, 'jose', '1234', 'img/usuarios/user.jpg', 'JOSE LARGON', 'AAAAAABBBBBB', '0940321854', 2, 1);
INSERT INTO `usuario` VALUES (3, 'admina', '12345', 'img/usuarios/user.jpg', 'aaaaaaaaa', 'bbbbbbbbbbb', '1234567890', 12, 1);
INSERT INTO `usuario` VALUES (4, 'Lokochon', '123', 'img/usuarios/user.jpg', 'BACILIO TONTO', 'jorge', '0940321854', 2, 1);
INSERT INTO `usuario` VALUES (6, 'adminqw', 'Jorgw12@', 'img/usuarios/user.jpg', 'BACILIO TONT', 'jorge', '0940321853', 2, 1);

-- ----------------------------
-- Table structure for vehiculo
-- ----------------------------
DROP TABLE IF EXISTS `vehiculo`;
CREATE TABLE `vehiculo`  (
  `id_vehiculo` int NOT NULL AUTO_INCREMENT,
  `tipo` char(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `marca` char(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `matricula` char(40) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `numero_serie` char(60) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `detalle_p` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL,
  `modelo` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_vehiculo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of vehiculo
-- ----------------------------
INSERT INTO `vehiculo` VALUES (1, 'Auto', 'TOYOTA', '123-ABC', '123456', 'COLOR NEGRO', '123BAC', 1);
INSERT INTO `vehiculo` VALUES (2, 'Camión', 'MAZDA', 'abc-321', '2342121', 'DE TODO UN POCO\n', 'ABC123', 1);
INSERT INTO `vehiculo` VALUES (3, 'Moto', 'TOYOTA', 'GTA-123', 'NEGRO', 'Detalle MOTO ', 'ALFA123', 1);
INSERT INTO `vehiculo` VALUES (4, 'Auto', 'MAZDA', 'GTA-321', 'AMARILLO', 'Detalle DE CARRO', 'FORTROLL', 1);

-- ----------------------------
-- Table structure for venta
-- ----------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta`  (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `tipo_doc` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `numero_compra` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `iva` int NULL DEFAULT NULL,
  `sub_total` decimal(10, 2) NULL DEFAULT NULL,
  `sub_iva` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_venta`) USING BTREE,
  INDEX `id_cliente`(`id_cliente`) USING BTREE,
  CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of venta
-- ----------------------------
INSERT INTO `venta` VALUES (5, 1, '2022-06-06', 'Factura', '20220606110636', 12, 123.00, 14.76, 137.76, 1, 0);
INSERT INTO `venta` VALUES (6, 1, '2022-06-06', 'Factura', '20220606110643', 12, 123.00, 14.76, 137.76, 1, 0);
INSERT INTO `venta` VALUES (7, 1, '2022-06-06', 'Factura', '20220606110639', 12, 354.00, 42.48, 396.48, 2, 0);
INSERT INTO `venta` VALUES (8, 1, '2022-06-06', 'Factura', '20220606110654', 12, 246.00, 29.52, 275.52, 2, 0);
INSERT INTO `venta` VALUES (9, 1, '2022-06-07', 'Factura', '20220607100656', 12, 494.00, 59.28, 553.28, 2, 0);
INSERT INTO `venta` VALUES (10, 1, '2022-07-11', 'Boleta', '20220711190716', 0, 123.00, 0.00, 0.00, 1, 1);
INSERT INTO `venta` VALUES (11, 1, '2022-07-13', 'Factura', '20220713140737', 12, 357.60, 42.91, 400.51, 2, 1);

-- ----------------------------
-- Table structure for venta_online
-- ----------------------------
DROP TABLE IF EXISTS `venta_online`;
CREATE TABLE `venta_online`  (
  `id_venta_online_trans` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int NULL DEFAULT NULL,
  `tipo_pago` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `numero_compra` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `subtotal` decimal(10, 2) NULL DEFAULT NULL,
  `impuesto` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `direccion` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `referencia` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  `pago` int NULL DEFAULT 0,
  `fecha_envio` date NULL DEFAULT NULL,
  `cod_envio` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado_envio` char(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_venta_online_trans`) USING BTREE,
  INDEX `cliente_id`(`cliente_id`) USING BTREE,
  CONSTRAINT `venta_online_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of venta_online
-- ----------------------------
INSERT INTO `venta_online` VALUES (13, 1, 'Transferencia', '20220624090600', '2022-06-24', 4, 480.60, 57.67, 538.27, 'aaaaaaaaa', 'bbbbbbbbbbbbb', 1, 2, '2022-07-19', '20220719180700', 'Entregado');
INSERT INTO `venta_online` VALUES (14, 1, 'Transferencia', '20220624140603', '2022-06-24', 4, 480.60, 57.67, 538.27, 'aaaaaaaaa', 'bbbbbbbbbbb', 1, 2, '2022-07-19', '20220719180700', 'Entregado');
INSERT INTO `venta_online` VALUES (15, 1, 'Transferencia', '20220624150617', '2022-06-24', 1, 123.00, 14.76, 137.76, 'zzzzzzz', 'xxxxxxxxxxx', 1, 2, '2022-07-19', '20220719180700', 'Entregado');
INSERT INTO `venta_online` VALUES (16, 1, 'Transferencia', '20220628110622', '2022-06-28', 1, 123.00, 14.76, 137.76, 'gato111', 'aaa', 1, 2, '2022-07-19', '20220719190709', 'Enviado');
INSERT INTO `venta_online` VALUES (19, 1, 'Efectivo', '20220628180600', '2022-06-28', 1, 123.00, 14.76, 137.76, 'Dirección', 'Referencia de ubicación', 1, 2, '2022-07-29', '20220729190742', 'Entregado');
INSERT INTO `venta_online` VALUES (20, 1, 'Transferencia', '20220709120710', '2022-07-09', 1, 123.00, 14.76, 137.76, 'aaaaaaaaaaa', 'aaaaaaaa', 1, 2, '2022-07-29', '20220729190742', 'Entregado');
INSERT INTO `venta_online` VALUES (21, 1, 'Transferencia', '20220729190735', '2022-07-29', 1, 123.00, 14.76, 137.76, 'MI CASA', 'FRENTE A MI CASA', 1, 2, '2022-07-29', '20220729190742', 'Entregado');
INSERT INTO `venta_online` VALUES (22, 1, 'Efectivo', '20220729190718', '2022-07-29', 1, 248.00, 29.76, 277.76, 'aaaaaaa', 'bbbbbb', 1, 2, '2022-07-29', '20220729190742', 'Entregado');
INSERT INTO `venta_online` VALUES (23, 1, 'Transferencia', '20220729190703', '2022-07-29', 1, 123.00, 14.76, 137.76, 'zzzzzzzzz', 'yyyyyyyyy', 1, 2, '2022-08-03', '20220803110836', 'Entregado');
INSERT INTO `venta_online` VALUES (24, 1, 'Efectivo', '20220803100804', '2022-08-03', 1, 322.00, 38.64, 360.64, 'xxxxxxxxxxxxxx', 'wwwwwwwwwwwwwwww', 1, 2, '2022-08-03', '20220803110836', 'Entregado');
INSERT INTO `venta_online` VALUES (25, 1, 'Efectivo', '20220803120826', '2022-08-03', 2, 355.00, 42.60, 397.60, 'NUEVA DIRECCION', 'NUEVA REFERENCIA', 1, 2, '2022-08-03', '20220803120804', 'Entregado');
INSERT INTO `venta_online` VALUES (26, 1, 'Transferencia', '20220812110843', '2022-08-12', 1, 123.00, 14.76, 137.76, 'aaaa', 'aaaaaaa', 1, 2, '2022-08-15', '20220815200831', 'Entregado');
INSERT INTO `venta_online` VALUES (27, 1, 'Efectivo', '20220814090843', '2022-08-14', 2, 247.00, 29.64, 276.64, 'aaaaa', 'bbbbbbbb', 1, 2, '2022-08-14', '20220814090849', 'Entregado');
INSERT INTO `venta_online` VALUES (28, 1, 'Efectivo', '20220814190856', '2022-08-14', 2, 354.00, 42.48, 396.48, 'CCCC', 'CCCCCCCC', 1, 2, '2022-08-15', '20220815200831', 'Entregado');
INSERT INTO `venta_online` VALUES (29, 1, 'Efectivo', '20220814190815', '2022-08-14', 1, 124.00, 14.88, 138.88, 'AA', 'AA', 1, 2, '2022-08-15', '20220815200831', 'Entregado');
INSERT INTO `venta_online` VALUES (30, 1, 'Efectivo', '20220814190838', '2022-08-14', 1, 124.00, 14.88, 138.88, 'zzz', 'zz', 1, 0, '2022-09-27', '20220927140953', 'Enviado');
INSERT INTO `venta_online` VALUES (31, 1, 'Efectivo', '20220814190808', '2022-08-14', 1, 123.00, 14.76, 137.76, 'mmm', 'mmm', 1, 0, '2022-09-27', '20220927140953', 'Enviado');
INSERT INTO `venta_online` VALUES (32, 1, 'Efectivo', '20220927140912', '2022-09-27', 2, 61131.00, 7335.72, 68466.72, 'AAA', 'BBB', 1, 0, '2022-09-27', '20220927140910', 'Enviado');
INSERT INTO `venta_online` VALUES (33, 1, 'Efectivo', '20220927140948', '2022-09-27', 1, 124.00, 14.88, 138.88, 'CCCC', 'DDDD', 1, 2, '2022-09-27', '20220927140923', 'Entregado');
INSERT INTO `venta_online` VALUES (34, 1, 'Efectivo', '20220927140930', '2022-09-27', 2, 246.00, 29.52, 275.52, 'EEEE', 'FFFF', 1, 0, '2022-09-27', '20220927140935', 'Enviado');

-- ----------------------------
-- Table structure for venta_servicio
-- ----------------------------
DROP TABLE IF EXISTS `venta_servicio`;
CREATE TABLE `venta_servicio`  (
  `id_venta_servico` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NULL DEFAULT NULL,
  `numero_compra` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo_doc` char(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `iva` int NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `sub_total` decimal(10, 2) NULL DEFAULT NULL,
  `sub_iva` decimal(10, 2) NULL DEFAULT NULL,
  `total` decimal(10, 2) NULL DEFAULT NULL,
  `cantidad` int NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_venta_servico`) USING BTREE,
  INDEX `id_cliente`(`id_cliente`) USING BTREE,
  CONSTRAINT `venta_servicio_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of venta_servicio
-- ----------------------------
INSERT INTO `venta_servicio` VALUES (3, 1, '20220604190650', 'Factura', 12, '2022-06-04', 32.00, 3.84, 35.84, 2, 0);
INSERT INTO `venta_servicio` VALUES (4, 1, '20220604190626', 'Factura', 12, '2022-06-04', 134.00, 16.08, 150.08, 3, 0);
INSERT INTO `venta_servicio` VALUES (5, 1, '20220607100626', 'Factura', 12, '2022-06-07', 12.00, 1.44, 13.44, 1, 1);
INSERT INTO `venta_servicio` VALUES (6, 1, '20220711190757', 'Boleta', 0, '2022-07-11', 30.00, 0.00, 0.00, 1, 1);
INSERT INTO `venta_servicio` VALUES (7, 1, '20220713140706', 'Factura', 12, '2022-07-13', 100.00, 12.00, 112.00, 2, 1);

-- ----------------------------
-- Table structure for ventas_online
-- ----------------------------
DROP TABLE IF EXISTS `ventas_online`;
CREATE TABLE `ventas_online`  (
  `id_ventas_online` int NOT NULL,
  `id_cliente` int NULL DEFAULT NULL,
  `fecha` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `tipo_pago` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `cantidad` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `estado` int NULL DEFAULT 1,
  PRIMARY KEY (`id_ventas_online`) USING BTREE,
  INDEX `id_cliente`(`id_cliente`) USING BTREE,
  CONSTRAINT `ventas_online_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ventas_online
-- ----------------------------

-- ----------------------------
-- Table structure for web
-- ----------------------------
DROP TABLE IF EXISTS `web`;
CREATE TABLE `web`  (
  `id_web` int NOT NULL AUTO_INCREMENT,
  `foto1` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `foto2` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `foto3` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `detalle1` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `detalle2` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  `detalle3` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_web`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of web
-- ----------------------------
INSERT INTO `web` VALUES (1, 'img/web/IMG1482022133414.jpg', 'img/web/IMG1482022133430.png', 'img/web/IMG1482022133436.png', 'Detalle puente', 'Detalle calle', 'Detalle comedor');

-- ----------------------------
-- Procedure structure for caificacion
-- ----------------------------
DROP PROCEDURE IF EXISTS `caificacion`;
delimiter ;;
CREATE PROCEDURE `caificacion`(in id int)
BEGIN
	DECLARE
		muy_bueno INT;
	DECLARE
		bueno INT;
	DECLARE
		regular INT;
	DECLARE
		nejorar INT;
	DECLARE
		exelente INT;
		
	SELECT
	COUNT(calificacion_producto.calificar)
	INTO muy_bueno FROM calificacion_producto WHERE
	calificacion_producto.id_producto = id 
	AND calificacion_producto.calificar = "Muy Bueno";
	
	SELECT
	COUNT(calificacion_producto.calificar)
	INTO bueno FROM calificacion_producto WHERE
	calificacion_producto.id_producto = id 
	AND calificacion_producto.calificar = "Bueno";
	
		SELECT
	COUNT(calificacion_producto.calificar)
	INTO regular FROM calificacion_producto WHERE
	calificacion_producto.id_producto = id 
	AND calificacion_producto.calificar = "Regular";
	
			SELECT
	COUNT(calificacion_producto.calificar)
	INTO nejorar FROM calificacion_producto WHERE
	calificacion_producto.id_producto = id 
	AND calificacion_producto.calificar = "Necesita Mejorar";
	
				SELECT
	COUNT(calificacion_producto.calificar)
	INTO exelente FROM calificacion_producto WHERE
	calificacion_producto.id_producto = id 
	AND calificacion_producto.calificar = "Excelente";
	

	SELECT
		muy_bueno,
		bueno,
		regular,
		nejorar,
		exelente;
	
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for datadeshboard
-- ----------------------------
DROP PROCEDURE IF EXISTS `datadeshboard`;
delimiter ;;
CREATE PROCEDURE `datadeshboard`()
BEGIN
	DECLARE
		productos INT;
	DECLARE
		servicios INT;
	DECLARE
		clientes INT;
	DECLARE
		ofertas INT;
	SELECT
		COUNT(*) INTO productos 
	FROM
		producto 
	WHERE
		eliminado = 1;
	SELECT
		COUNT(*) INTO servicios 
	FROM
		servicio 
	WHERE
		estado = 1;
	SELECT
		COUNT(*) INTO clientes 
	FROM
		cliente 
	WHERE
		estado = 1;
	SELECT
		COUNT(*) INTO ofertas 
	FROM
		ofertas;
	SELECT
		productos,
		servicios,
		clientes,
		ofertas;

END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
