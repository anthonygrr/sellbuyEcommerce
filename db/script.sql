

USE `sellbuy_php_db`;


--
-- Estructura de tabla para la tabla `counter`
--

CREATE TABLE `counter` (
  `id_count` int(11) NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `counter`
--

INSERT INTO `counter` (`id_count`, `ip`, `fecha`) VALUES
(1, '189.243.27.234', '2021-11-29 23:18:07'),
(2, '74.125.214.54', '2021-11-30 05:24:12'),
(3, '200.68.138.24', '2021-12-02 21:41:55'),
(4, '64.233.172.43', '2021-12-05 02:57:28'),
(5, '189.243.42.185', '2022-01-06 01:23:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `code_order` int(11) NOT NULL,
  `code_user` int(11) NOT NULL,
  `code_prod` int(11) NOT NULL,
  `date_order` datetime NOT NULL,
  `state_order` int(11) NOT NULL,
  `address_order` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_order` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_order` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `code_prod` int(11) NOT NULL,
  `name_prod` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description_prod` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `price_prod` decimal(6,2) NOT NULL,
  `state_prod` int(11) NOT NULL,
  `image_route` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `offer_prod` int(11) NOT NULL,
  `category_prod` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`code_prod`, `name_prod`, `description_prod`, `price_prod`, `state_prod`, `image_route`, `offer_prod`, `category_prod`) VALUES
(1, 'Red Backpack', 'Is very useful for carry your scholar tools', 72.00, 1, 'redbackpack.jpg', 0, 'bags,backpacks'),
(2, 'Blue Tenis', 'Best election for practice sport', 91.00, 1, 'blue-tenis.jpg', 0, 'shoes,tenis,boots'),
(3, 'Bee White Tenis', 'Incredible tenis only in white', 80.23, 1, 'bee-white-tenis.jpg', 0, 'shoes,tenis,boots'),
(4, 'Blue Shirt', 'Elegant shirt only for men', 89.90, 1, 'blue-shirt.jpg', 0, 'shirt'),
(5, 'Dolce Backpack', 'Black Dolce backpack with cool decorations', 78.56, 1, 'dolce-backpack.jpg', 0, 'bags,backpacks'),
(6, 'Fancy Shirt', 'Buy this amazing shirt to impress everyone', 120.99, 1, 'fancy-shirt.jpg', 0, 'shirt'),
(7, 'Gucci Watch', 'Modern elegant watch', 300.89, 1, 'gucci-watch.jpg', 0, 'accesories'),
(8, 'Black Nike Tenis', 'New Cool Nike Tennis  ', 250.00, 1, 'nike-black.jpg', 0, 'shoes,tenis,boots'),
(9, 'Elegant Bag', 'Useful to carry what a woman needs', 80.00, 1, 'bag.jpg', 1, 'bags,backpacks'),
(10, 'Elegant Boots', 'Wear these elegant boots ', 80.00, 1, 'black_boots.jpg', 1, 'shoes,tenis,boots'),
(11, 'Brown Bag', 'Now in color Brown', 80.00, 1, 'brown_bag.jpg', 1, 'bags,backpacks'),
(12, 'Red Tenis Nike', 'Amazing Red Nike Tenis', 80.00, 1, 'nike-red.jpg', 1, 'shoes,tenis,boots'),
(13, 'Baseball Cap', 'Baseball Cap with Lion print', 80.00, 1, 'baseball_cap.png', 1, 'accesories'),
(14, 'Alien Cap', 'Cap with alien embroidery.', 80.00, 1, 'cap_with_alien_embroidery.png', 1, 'accesories'),
(15, 'Skate Tenis', 'Men\'s skate tennis', 80.00, 1, 'men\'s_skate_tennis.png', 1, 'shoes,tenis,boots'),
(16, 'Sunglasses', 'Cool Sunglasses', 80.00, 1, 'Sunglasses.png', 1, 'accesories'),
(17, 'Backpack Joy', 'Joy Star Backpack', 97.00, 1, 'joy_star_backpack.png', 0, 'bags,backpacks'),
(18, 'Baseball Cap', 'Men\'s baseball cap', 56.00, 1, 'men\'s_baseball_cap.png', 0, 'accesories'),
(19, 'Black Sweater', 'sweater with fire embroidery', 120.00, 1, 'sweater_with_fire_embroidery.png', 0, 'shirt'),
(20, 'White Sweater', 'Sweatshirt With Print', 120.00, 1, 'sweatshirt_with_print.png', 0, 'shirt'),
(21, 'Sport Sunglasses', 'Sports Cycling Sunglasses', 135.00, 1, 'sports_cycling_sunglasses.png', 0, 'accesories');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `code_user` int(11) NOT NULL,
  `name_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secondname_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `email_user` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password_user` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `state_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`code_user`, `name_user`, `secondname_user`, `email_user`, `password_user`, `state_user`) VALUES
(1, 'user', 'demo', 'example@gmail.com', '1234', 1),
(2, 'user2', 'demo', 'example2@gmail.com', '1234', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`id_count`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`code_order`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`code_prod`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`code_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `counter`
--
ALTER TABLE `counter`
  MODIFY `id_count` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `code_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `code_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `code_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;