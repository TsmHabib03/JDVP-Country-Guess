-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2026 at 12:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `country_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `capital` varchar(255) NOT NULL,
  `flag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_name`, `capital`, `flag`) VALUES
(1, 'Afghanistan', 'Kabul', './flags/Afghanistan.png'),
(2, 'Albania', 'Tirana', './flags/Albania.png'),
(3, 'Algeria', 'Algiers', './flags/Algeria.png'),
(4, 'American Samoa', 'Pago Pago', './flags/American_Samoa.png'),
(5, 'Andorra', 'Andorra la Vella', './flags/Andorra.png'),
(6, 'Angola', 'Luanda', './flags/Angola.png'),
(7, 'Anguilla', 'The Valley', './flags/Anguilla.png'),
(8, 'Antarctica', '', './flags/Antarctica.png'),
(9, 'Antigua and Barbuda', 'Saint John\'s', './flags/Antigua_and_Barbuda.png'),
(10, 'Argentina', 'Buenos Aires', './flags/Argentina.png'),
(11, 'Armenia', 'Yerevan', './flags/Armenia.png'),
(12, 'Aruba', 'Oranjestad', './flags/Aruba.png'),
(13, 'Australia', 'Canberra', './flags/Australia.png'),
(14, 'Austria', 'Vienna', './flags/Austria.png'),
(15, 'Azerbaijan', 'Baku', './flags/Azerbaijan.png'),
(16, 'Bahamas', 'Nassau', './flags/Bahamas.png'),
(17, 'Bahrain', 'Manama', './flags/Bahrain.png'),
(18, 'Bangladesh', 'Dhaka', './flags/Bangladesh.png'),
(19, 'Barbados', 'Bridgetown', './flags/Barbados.png'),
(20, 'Belarus', 'Minsk', './flags/Belarus.png'),
(21, 'Belgium', 'Brussels', './flags/Belgium.png'),
(22, 'Belize', 'Belmopan', './flags/Belize.png'),
(23, 'Benin', 'Porto-Novo', './flags/Benin.png'),
(24, 'Bermuda', 'Hamilton', './flags/Bermuda.png'),
(25, 'Bhutan', 'Thimphu', './flags/Bhutan.png'),
(26, 'Bolivia', 'Sucre', './flags/Bolivia.png'),
(27, 'Bosnia and Herzegovina', 'Sarajevo', './flags/Bosnia_and_Herzegovina.png'),
(28, 'Botswana', 'Gaborone', './flags/Botswana.png'),
(29, 'Bouvet Island', '', './flags/Bouvet_Island.png'),
(30, 'Brazil', 'Brasília', './flags/Brazil.png'),
(31, 'British Indian Ocean Territory', 'Diego Garcia', './flags/British_Indian_Ocean_Territory.png'),
(32, 'British Virgin Islands', 'Road Town', './flags/British_Virgin_Islands.png'),
(33, 'Brunei', 'Bandar Seri Begawan', './flags/Brunei.png'),
(34, 'Bulgaria', 'Sofia', './flags/Bulgaria.png'),
(35, 'Burkina Faso', 'Ouagadougou', './flags/Burkina_Faso.png'),
(36, 'Burundi', 'Gitega', './flags/Burundi.png'),
(37, 'Cambodia', 'Phnom Penh', './flags/Cambodia.png'),
(38, 'Cameroon', 'Yaoundé', './flags/Cameroon.png'),
(39, 'Canada', 'Ottawa', './flags/Canada.png'),
(40, 'Cape Verde', 'Praia', './flags/Cape_Verde.png'),
(41, 'Caribbean Netherlands', 'Kralendijk', './flags/Caribbean_Netherlands.png'),
(42, 'Cayman Islands', 'George Town', './flags/Cayman_Islands.png'),
(43, 'Central African Republic', 'Bangui', './flags/Central_African_Republic.png'),
(44, 'Chad', 'N\'Djamena', './flags/Chad.png'),
(45, 'Chile', 'Santiago', './flags/Chile.png'),
(46, 'China', 'Beijing', './flags/China.png'),
(47, 'Christmas Island', 'Flying Fish Cove', './flags/Christmas_Island.png'),
(48, 'Cocos (Keeling) Islands', 'West Island', './flags/Cocos_(Keeling)_Islands.png'),
(49, 'Colombia', 'Bogotá', './flags/Colombia.png'),
(50, 'Comoros', 'Moroni', './flags/Comoros.png'),
(51, 'Cook Islands', 'Avarua', './flags/Cook_Islands.png'),
(52, 'Costa Rica', 'San José', './flags/Costa_Rica.png'),
(53, 'Croatia', 'Zagreb', './flags/Croatia.png'),
(54, 'Cuba', 'Havana', './flags/Cuba.png'),
(55, 'Curaçao', 'Willemstad', './flags/Curaçao.png'),
(56, 'Cyprus', 'Nicosia', './flags/Cyprus.png'),
(57, 'Czechia', 'Prague', './flags/Czechia.png'),
(58, 'DR Congo', 'Kinshasa', './flags/DR_Congo.png'),
(59, 'Denmark', 'Copenhagen', './flags/Denmark.png'),
(60, 'Djibouti', 'Djibouti', './flags/Djibouti.png'),
(61, 'Dominica', 'Roseau', './flags/Dominica.png'),
(62, 'Dominican Republic', 'Santo Domingo', './flags/Dominican_Republic.png'),
(63, 'Ecuador', 'Quito', './flags/Ecuador.png'),
(64, 'Egypt', 'Cairo', './flags/Egypt.png'),
(65, 'El Salvador', 'San Salvador', './flags/El_Salvador.png'),
(66, 'Equatorial Guinea', 'Malabo', './flags/Equatorial_Guinea.png'),
(67, 'Eritrea', 'Asmara', './flags/Eritrea.png'),
(68, 'Estonia', 'Tallinn', './flags/Estonia.png'),
(69, 'Eswatini', 'Mbabane', './flags/Eswatini.png'),
(70, 'Ethiopia', 'Addis Ababa', './flags/Ethiopia.png'),
(71, 'Falkland Islands', 'Stanley', './flags/Falkland_Islands.png'),
(72, 'Faroe Islands', 'Tórshavn', './flags/Faroe_Islands.png'),
(73, 'Fiji', 'Suva', './flags/Fiji.png'),
(74, 'Finland', 'Helsinki', './flags/Finland.png'),
(75, 'France', 'Paris', './flags/France.png'),
(76, 'French Guiana', 'Cayenne', './flags/French_Guiana.png'),
(77, 'French Polynesia', 'Papeetē', './flags/French_Polynesia.png'),
(78, 'French Southern and Antarctic Lands', 'Port-aux-Français', './flags/French_Southern_and_Antarctic_Lands.png'),
(79, 'Gabon', 'Libreville', './flags/Gabon.png'),
(80, 'Gambia', 'Banjul', './flags/Gambia.png'),
(81, 'Georgia', 'Tbilisi', './flags/Georgia.png'),
(82, 'Germany', 'Berlin', './flags/Germany.png'),
(83, 'Ghana', 'Accra', './flags/Ghana.png'),
(84, 'Gibraltar', 'Gibraltar', './flags/Gibraltar.png'),
(85, 'Greece', 'Athens', './flags/Greece.png'),
(86, 'Greenland', 'Nuuk', './flags/Greenland.png'),
(87, 'Grenada', 'St. George\'s', './flags/Grenada.png'),
(88, 'Guadeloupe', 'Basse-Terre', './flags/Guadeloupe.png'),
(89, 'Guam', 'Hagåtña', './flags/Guam.png'),
(90, 'Guatemala', 'Guatemala City', './flags/Guatemala.png'),
(91, 'Guernsey', 'St. Peter Port', './flags/Guernsey.png'),
(92, 'Guinea', 'Conakry', './flags/Guinea.png'),
(93, 'Guinea-Bissau', 'Bissau', './flags/Guinea-Bissau.png'),
(94, 'Guyana', 'Georgetown', './flags/Guyana.png'),
(95, 'Haiti', 'Port-au-Prince', './flags/Haiti.png'),
(96, 'Heard Island and McDonald Islands', '', './flags/Heard_Island_and_McDonald_Islands.png'),
(97, 'Honduras', 'Tegucigalpa', './flags/Honduras.png'),
(98, 'Hong Kong', 'City of Victoria', './flags/Hong_Kong.png'),
(99, 'Hungary', 'Budapest', './flags/Hungary.png'),
(100, 'Iceland', 'Reykjavik', './flags/Iceland.png'),
(101, 'India', 'New Delhi', './flags/India.png'),
(102, 'Indonesia', 'Jakarta', './flags/Indonesia.png'),
(103, 'Iran', 'Tehran', './flags/Iran.png'),
(104, 'Iraq', 'Baghdad', './flags/Iraq.png'),
(105, 'Ireland', 'Dublin', './flags/Ireland.png'),
(106, 'Isle of Man', 'Douglas', './flags/Isle_of_Man.png'),
(107, 'Israel', 'Jerusalem', './flags/Israel.png'),
(108, 'Italy', 'Rome', './flags/Italy.png'),
(109, 'Ivory Coast', 'Yamoussoukro', './flags/Ivory_Coast.png'),
(110, 'Jamaica', 'Kingston', './flags/Jamaica.png'),
(111, 'Japan', 'Tokyo', './flags/Japan.png'),
(112, 'Jersey', 'Saint Helier', './flags/Jersey.png'),
(113, 'Jordan', 'Amman', './flags/Jordan.png'),
(114, 'Kazakhstan', 'Astana', './flags/Kazakhstan.png'),
(115, 'Kenya', 'Nairobi', './flags/Kenya.png'),
(116, 'Kiribati', 'South Tarawa', './flags/Kiribati.png'),
(117, 'Kosovo', 'Pristina', './flags/Kosovo.png'),
(118, 'Kuwait', 'Kuwait City', './flags/Kuwait.png'),
(119, 'Kyrgyzstan', 'Bishkek', './flags/Kyrgyzstan.png'),
(120, 'Laos', 'Vientiane', './flags/Laos.png'),
(121, 'Latvia', 'Riga', './flags/Latvia.png'),
(122, 'Lebanon', 'Beirut', './flags/Lebanon.png'),
(123, 'Lesotho', 'Maseru', './flags/Lesotho.png'),
(124, 'Liberia', 'Monrovia', './flags/Liberia.png'),
(125, 'Libya', 'Tripoli', './flags/Libya.png'),
(126, 'Liechtenstein', 'Vaduz', './flags/Liechtenstein.png'),
(127, 'Lithuania', 'Vilnius', './flags/Lithuania.png'),
(128, 'Luxembourg', 'Luxembourg', './flags/Luxembourg.png'),
(129, 'Macau', '', './flags/Macau.png'),
(130, 'Madagascar', 'Antananarivo', './flags/Madagascar.png'),
(131, 'Malawi', 'Lilongwe', './flags/Malawi.png'),
(132, 'Malaysia', 'Kuala Lumpur', './flags/Malaysia.png'),
(133, 'Maldives', 'Malé', './flags/Maldives.png'),
(134, 'Mali', 'Bamako', './flags/Mali.png'),
(135, 'Malta', 'Valletta', './flags/Malta.png'),
(136, 'Marshall Islands', 'Majuro', './flags/Marshall_Islands.png'),
(137, 'Martinique', 'Fort-de-France', './flags/Martinique.png'),
(138, 'Mauritania', 'Nouakchott', './flags/Mauritania.png'),
(139, 'Mauritius', 'Port Louis', './flags/Mauritius.png'),
(140, 'Mayotte', 'Mamoudzou', './flags/Mayotte.png'),
(141, 'Mexico', 'Mexico City', './flags/Mexico.png'),
(142, 'Micronesia', 'Palikir', './flags/Micronesia.png'),
(143, 'Moldova', 'Chișinău', './flags/Moldova.png'),
(144, 'Monaco', 'Monaco', './flags/Monaco.png'),
(145, 'Mongolia', 'Ulan Bator', './flags/Mongolia.png'),
(146, 'Montenegro', 'Podgorica', './flags/Montenegro.png'),
(147, 'Montserrat', 'Plymouth', './flags/Montserrat.png'),
(148, 'Morocco', 'Rabat', './flags/Morocco.png'),
(149, 'Mozambique', 'Maputo', './flags/Mozambique.png'),
(150, 'Myanmar', 'Naypyidaw', './flags/Myanmar.png'),
(151, 'Namibia', 'Windhoek', './flags/Namibia.png'),
(152, 'Nauru', 'Yaren', './flags/Nauru.png'),
(153, 'Nepal', 'Kathmandu', './flags/Nepal.png'),
(154, 'Netherlands', 'Amsterdam', './flags/Netherlands.png'),
(155, 'New Caledonia', 'Nouméa', './flags/New_Caledonia.png'),
(156, 'New Zealand', 'Wellington', './flags/New_Zealand.png'),
(157, 'Nicaragua', 'Managua', './flags/Nicaragua.png'),
(158, 'Niger', 'Niamey', './flags/Niger.png'),
(159, 'Nigeria', 'Abuja', './flags/Nigeria.png'),
(160, 'Niue', 'Alofi', './flags/Niue.png'),
(161, 'Norfolk Island', 'Kingston', './flags/Norfolk_Island.png'),
(162, 'North Korea', 'Pyongyang', './flags/North_Korea.png'),
(163, 'North Macedonia', 'Skopje', './flags/North_Macedonia.png'),
(164, 'Northern Mariana Islands', 'Saipan', './flags/Northern_Mariana_Islands.png'),
(165, 'Norway', 'Oslo', './flags/Norway.png'),
(166, 'Oman', 'Muscat', './flags/Oman.png'),
(167, 'Pakistan', 'Islamabad', './flags/Pakistan.png'),
(168, 'Palau', 'Ngerulmud', './flags/Palau.png'),
(169, 'Palestine', 'Ramallah', './flags/Palestine.png'),
(170, 'Panama', 'Panama City', './flags/Panama.png'),
(171, 'Papua New Guinea', 'Port Moresby', './flags/Papua_New_Guinea.png'),
(172, 'Paraguay', 'Asunción', './flags/Paraguay.png'),
(173, 'Peru', 'Lima', './flags/Peru.png'),
(174, 'Philippines', 'Manila', './flags/Philippines.png'),
(175, 'Pitcairn Islands', 'Adamstown', './flags/Pitcairn_Islands.png'),
(176, 'Poland', 'Warsaw', './flags/Poland.png'),
(177, 'Portugal', 'Lisbon', './flags/Portugal.png'),
(178, 'Puerto Rico', 'San Juan', './flags/Puerto_Rico.png'),
(179, 'Qatar', 'Doha', './flags/Qatar.png'),
(180, 'Republic of the Congo', 'Brazzaville', './flags/Republic_of_the_Congo.png'),
(181, 'Romania', 'Bucharest', './flags/Romania.png'),
(182, 'Russia', 'Moscow', './flags/Russia.png'),
(183, 'Rwanda', 'Kigali', './flags/Rwanda.png'),
(184, 'Réunion', 'Saint-Denis', './flags/Réunion.png'),
(185, 'Saint Barthélemy', 'Gustavia', './flags/Saint_Barthélemy.png'),
(186, 'Saint Helena, Ascension and Tristan da Cunha', 'Jamestown', './flags/Saint_Helena,_Ascension_and_Tristan_da_Cunha.png'),
(187, 'Saint Kitts and Nevis', 'Basseterre', './flags/Saint_Kitts_and_Nevis.png'),
(188, 'Saint Lucia', 'Castries', './flags/Saint_Lucia.png'),
(189, 'Saint Martin', 'Marigot', './flags/Saint_Martin.png'),
(190, 'Saint Pierre and Miquelon', 'Saint-Pierre', './flags/Saint_Pierre_and_Miquelon.png'),
(191, 'Saint Vincent and the Grenadines', 'Kingstown', './flags/Saint_Vincent_and_the_Grenadines.png'),
(192, 'Samoa', 'Apia', './flags/Samoa.png'),
(193, 'San Marino', 'City of San Marino', './flags/San_Marino.png'),
(194, 'Saudi Arabia', 'Riyadh', './flags/Saudi_Arabia.png'),
(195, 'Senegal', 'Dakar', './flags/Senegal.png'),
(196, 'Serbia', 'Belgrade', './flags/Serbia.png'),
(197, 'Seychelles', 'Victoria', './flags/Seychelles.png'),
(198, 'Sierra Leone', 'Freetown', './flags/Sierra_Leone.png'),
(199, 'Singapore', 'Singapore', './flags/Singapore.png'),
(200, 'Sint Maarten', 'Philipsburg', './flags/Sint_Maarten.png'),
(201, 'Slovakia', 'Bratislava', './flags/Slovakia.png'),
(202, 'Slovenia', 'Ljubljana', './flags/Slovenia.png'),
(203, 'Solomon Islands', 'Honiara', './flags/Solomon_Islands.png'),
(204, 'Somalia', 'Mogadishu', './flags/Somalia.png'),
(205, 'South Africa', 'Pretoria', './flags/South_Africa.png'),
(206, 'South Georgia', 'King Edward Point', './flags/South_Georgia.png'),
(207, 'South Korea', 'Seoul', './flags/South_Korea.png'),
(208, 'South Sudan', 'Juba', './flags/South_Sudan.png'),
(209, 'Spain', 'Madrid', './flags/Spain.png'),
(210, 'Sri Lanka', 'Sri Jayawardenepura Kotte', './flags/Sri_Lanka.png'),
(211, 'Sudan', 'Khartoum', './flags/Sudan.png'),
(212, 'Suriname', 'Paramaribo', './flags/Suriname.png'),
(213, 'Svalbard and Jan Mayen', 'Longyearbyen', './flags/Svalbard_and_Jan_Mayen.png'),
(214, 'Sweden', 'Stockholm', './flags/Sweden.png'),
(215, 'Switzerland', 'Bern', './flags/Switzerland.png'),
(216, 'Syria', 'Damascus', './flags/Syria.png'),
(217, 'São Tomé and Príncipe', 'São Tomé', './flags/São_Tomé_and_Príncipe.png'),
(218, 'Taiwan', 'Taipei', './flags/Taiwan.png'),
(219, 'Tajikistan', 'Dushanbe', './flags/Tajikistan.png'),
(220, 'Tanzania', 'Dodoma', './flags/Tanzania.png'),
(221, 'Thailand', 'Bangkok', './flags/Thailand.png'),
(222, 'Timor-Leste', 'Dili', './flags/Timor-Leste.png'),
(223, 'Togo', 'Lomé', './flags/Togo.png'),
(224, 'Tokelau', 'Fakaofo', './flags/Tokelau.png'),
(225, 'Tonga', 'Nuku\'alofa', './flags/Tonga.png'),
(226, 'Trinidad and Tobago', 'Port of Spain', './flags/Trinidad_and_Tobago.png'),
(227, 'Tunisia', 'Tunis', './flags/Tunisia.png'),
(228, 'Turkey', 'Ankara', './flags/Turkey.png'),
(229, 'Turkmenistan', 'Ashgabat', './flags/Turkmenistan.png'),
(230, 'Turks and Caicos Islands', 'Cockburn Town', './flags/Turks_and_Caicos_Islands.png'),
(231, 'Tuvalu', 'Funafuti', './flags/Tuvalu.png'),
(232, 'Uganda', 'Kampala', './flags/Uganda.png'),
(233, 'Ukraine', 'Kyiv', './flags/Ukraine.png'),
(234, 'United Arab Emirates', 'Abu Dhabi', './flags/United_Arab_Emirates.png'),
(235, 'United Kingdom', 'London', './flags/United_Kingdom.png'),
(236, 'United States', 'Washington, D.C.', './flags/United_States.png'),
(237, 'United States Minor Outlying Islands', 'Washington DC', './flags/United_States_Minor_Outlying_Islands.png'),
(238, 'United States Virgin Islands', 'Charlotte Amalie', './flags/United_States_Virgin_Islands.png'),
(239, 'Uruguay', 'Montevideo', './flags/Uruguay.png'),
(240, 'Uzbekistan', 'Tashkent', './flags/Uzbekistan.png'),
(241, 'Vanuatu', 'Port Vila', './flags/Vanuatu.png'),
(242, 'Vatican City', 'Vatican City', './flags/Vatican_City.png'),
(243, 'Venezuela', 'Caracas', './flags/Venezuela.png'),
(244, 'Vietnam', 'Hanoi', './flags/Vietnam.png'),
(245, 'Wallis and Futuna', 'Mata-Utu', './flags/Wallis_and_Futuna.png'),
(246, 'Western Sahara', 'El Aaiún', './flags/Western_Sahara.png'),
(247, 'Yemen', 'Sana\'a', './flags/Yemen.png'),
(248, 'Zambia', 'Lusaka', './flags/Zambia.png'),
(249, 'Zimbabwe', 'Harare', './flags/Zimbabwe.png'),
(250, 'Åland Islands', 'Mariehamn', './flags/Åland_Islands.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
