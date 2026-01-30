-- Cities table for Country Intel
-- Run this in phpMyAdmin after importing country_db.sql

USE country_db;

CREATE TABLE IF NOT EXISTS cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL,
    city_name VARCHAR(100) NOT NULL,
    population VARCHAR(20),
    is_capital BOOLEAN DEFAULT FALSE,
    INDEX (country_name)
);

-- Insert major cities (3-5 per country)
INSERT INTO cities (country_name, city_name, population, is_capital) VALUES
-- Afghanistan
('Afghanistan', 'Kabul', '4.6M', TRUE),
('Afghanistan', 'Kandahar', '614K', FALSE),
('Afghanistan', 'Herat', '556K', FALSE),
('Afghanistan', 'Mazar-i-Sharif', '469K', FALSE),

-- Albania
('Albania', 'Tirana', '520K', TRUE),
('Albania', 'Durrës', '175K', FALSE),
('Albania', 'Vlorë', '130K', FALSE),

-- Algeria
('Algeria', 'Algiers', '3.4M', TRUE),
('Algeria', 'Oran', '1.5M', FALSE),
('Algeria', 'Constantine', '448K', FALSE),
('Algeria', 'Annaba', '342K', FALSE),

-- Argentina
('Argentina', 'Buenos Aires', '15.4M', TRUE),
('Argentina', 'Córdoba', '1.5M', FALSE),
('Argentina', 'Rosario', '1.3M', FALSE),
('Argentina', 'Mendoza', '1.1M', FALSE),

-- Australia
('Australia', 'Canberra', '457K', TRUE),
('Australia', 'Sydney', '5.4M', FALSE),
('Australia', 'Melbourne', '5.1M', FALSE),
('Australia', 'Brisbane', '2.6M', FALSE),
('Australia', 'Perth', '2.1M', FALSE),

-- Austria
('Austria', 'Vienna', '1.9M', TRUE),
('Austria', 'Graz', '292K', FALSE),
('Austria', 'Linz', '208K', FALSE),
('Austria', 'Salzburg', '155K', FALSE),

-- Bangladesh
('Bangladesh', 'Dhaka', '22.5M', TRUE),
('Bangladesh', 'Chittagong', '5.2M', FALSE),
('Bangladesh', 'Khulna', '1.0M', FALSE),
('Bangladesh', 'Rajshahi', '908K', FALSE),

-- Belgium
('Belgium', 'Brussels', '1.2M', TRUE),
('Belgium', 'Antwerp', '530K', FALSE),
('Belgium', 'Ghent', '265K', FALSE),
('Belgium', 'Charleroi', '202K', FALSE),

-- Brazil (Expanded)
('Brazil', 'Brasília', '4.8M', TRUE),
('Brazil', 'São Paulo', '22.4M', FALSE),
('Brazil', 'Rio de Janeiro', '13.6M', FALSE),
('Brazil', 'Salvador', '4.2M', FALSE),
('Brazil', 'Fortaleza', '4.1M', FALSE),
('Brazil', 'Belo Horizonte', '5.8M', FALSE),
('Brazil', 'Manaus', '2.3M', FALSE),
('Brazil', 'Curitiba', '3.5M', FALSE),
('Brazil', 'Recife', '4.1M', FALSE),
('Brazil', 'Porto Alegre', '4.3M', FALSE),
('Brazil', 'Goiânia', '2.5M', FALSE),
('Brazil', 'Belém', '2.5M', FALSE),
('Brazil', 'Guarulhos', '1.4M', FALSE),
('Brazil', 'Campinas', '1.2M', FALSE),
('Brazil', 'São Luís', '1.1M', FALSE),
('Brazil', 'Maceió', '1.0M', FALSE),
('Brazil', 'Campo Grande', '906K', FALSE),
('Brazil', 'Natal', '890K', FALSE),
('Brazil', 'João Pessoa', '817K', FALSE),
('Brazil', 'Teresina', '868K', FALSE),
('Brazil', 'Florianópolis', '508K', FALSE),
('Brazil', 'Vitória', '365K', FALSE),
('Brazil', 'Cuiabá', '618K', FALSE),
('Brazil', 'Aracaju', '664K', FALSE),
('Brazil', 'Santos', '433K', FALSE),

-- Canada
('Canada', 'Ottawa', '1.4M', TRUE),
('Canada', 'Toronto', '6.3M', FALSE),
('Canada', 'Montreal', '4.3M', FALSE),
('Canada', 'Vancouver', '2.6M', FALSE),
('Canada', 'Calgary', '1.6M', FALSE),

-- Chile
('Chile', 'Santiago', '6.8M', TRUE),
('Chile', 'Valparaíso', '1.0M', FALSE),
('Chile', 'Concepción', '780K', FALSE),

-- China (Expanded)
('China', 'Beijing', '21.5M', TRUE),
('China', 'Shanghai', '28.5M', FALSE),
('China', 'Guangzhou', '14.9M', FALSE),
('China', 'Shenzhen', '13.4M', FALSE),
('China', 'Chengdu', '11.3M', FALSE),
('China', 'Chongqing', '16.9M', FALSE),
('China', 'Tianjin', '13.9M', FALSE),
('China', 'Wuhan', '11.1M', FALSE),
('China', 'Dongguan', '10.5M', FALSE),
('China', 'Hangzhou', '10.3M', FALSE),
('China', 'Foshan', '9.5M', FALSE),
('China', 'Nanjing', '9.3M', FALSE),
('China', 'Shenyang', '9.1M', FALSE),
('China', 'Xi\'an', '8.7M', FALSE),
('China', 'Harbin', '6.0M', FALSE),
('China', 'Suzhou', '6.8M', FALSE),
('China', 'Qingdao', '6.0M', FALSE),
('China', 'Dalian', '5.9M', FALSE),
('China', 'Zhengzhou', '5.7M', FALSE),
('China', 'Jinan', '5.3M', FALSE),
('China', 'Changsha', '5.0M', FALSE),
('China', 'Kunming', '4.5M', FALSE),
('China', 'Changchun', '4.3M', FALSE),
('China', 'Shantou', '4.2M', FALSE),
('China', 'Xiamen', '4.0M', FALSE),
('China', 'Hefei', '3.9M', FALSE),
('China', 'Ningbo', '3.8M', FALSE),
('China', 'Fuzhou', '3.7M', FALSE),
('China', 'Nanchang', '3.5M', FALSE),
('China', 'Guiyang', '3.2M', FALSE),
('China', 'Urumqi', '2.9M', FALSE),
('China', 'Lanzhou', '2.8M', FALSE),
('China', 'Lhasa', '560K', FALSE),
('China', 'Hong Kong', '7.5M', FALSE),
('China', 'Macau', '680K', FALSE),

-- Colombia
('Colombia', 'Bogotá', '11.3M', TRUE),
('Colombia', 'Medellín', '4.1M', FALSE),
('Colombia', 'Cali', '2.9M', FALSE),
('Colombia', 'Barranquilla', '2.3M', FALSE),

-- Croatia
('Croatia', 'Zagreb', '807K', TRUE),
('Croatia', 'Split', '178K', FALSE),
('Croatia', 'Rijeka', '128K', FALSE),

-- Cuba
('Cuba', 'Havana', '2.1M', TRUE),
('Cuba', 'Santiago de Cuba', '510K', FALSE),
('Cuba', 'Camagüey', '321K', FALSE),

-- Czech Republic
('Czech Republic', 'Prague', '1.3M', TRUE),
('Czech Republic', 'Brno', '382K', FALSE),
('Czech Republic', 'Ostrava', '287K', FALSE),

-- Denmark
('Denmark', 'Copenhagen', '1.4M', TRUE),
('Denmark', 'Aarhus', '285K', FALSE),
('Denmark', 'Odense', '180K', FALSE),

-- Egypt
('Egypt', 'Cairo', '21.8M', TRUE),
('Egypt', 'Alexandria', '5.4M', FALSE),
('Egypt', 'Giza', '4.2M', FALSE),
('Egypt', 'Shubra El Kheima', '1.2M', FALSE),

-- Ethiopia
('Ethiopia', 'Addis Ababa', '5.2M', TRUE),
('Ethiopia', 'Dire Dawa', '493K', FALSE),
('Ethiopia', 'Mekelle', '358K', FALSE),

-- Finland
('Finland', 'Helsinki', '1.3M', TRUE),
('Finland', 'Espoo', '300K', FALSE),
('Finland', 'Tampere', '244K', FALSE),

-- France
('France', 'Paris', '11.1M', TRUE),
('France', 'Marseille', '1.8M', FALSE),
('France', 'Lyon', '1.7M', FALSE),
('France', 'Toulouse', '1.4M', FALSE),
('France', 'Nice', '1.0M', FALSE),

-- Germany
('Germany', 'Berlin', '3.7M', TRUE),
('Germany', 'Hamburg', '1.9M', FALSE),
('Germany', 'Munich', '1.5M', FALSE),
('Germany', 'Cologne', '1.1M', FALSE),
('Germany', 'Frankfurt', '764K', FALSE),

-- Greece
('Greece', 'Athens', '3.2M', TRUE),
('Greece', 'Thessaloniki', '1.1M', FALSE),
('Greece', 'Patras', '214K', FALSE),

-- Hungary
('Hungary', 'Budapest', '1.8M', TRUE),
('Hungary', 'Debrecen', '201K', FALSE),
('Hungary', 'Szeged', '160K', FALSE),

-- India (Expanded)
('India', 'New Delhi', '32.9M', TRUE),
('India', 'Mumbai', '21.7M', FALSE),
('India', 'Bangalore', '13.2M', FALSE),
('India', 'Hyderabad', '10.5M', FALSE),
('India', 'Chennai', '11.5M', FALSE),
('India', 'Kolkata', '15.1M', FALSE),
('India', 'Ahmedabad', '8.4M', FALSE),
('India', 'Pune', '6.8M', FALSE),
('India', 'Surat', '7.5M', FALSE),
('India', 'Jaipur', '4.1M', FALSE),
('India', 'Lucknow', '3.7M', FALSE),
('India', 'Kanpur', '3.1M', FALSE),
('India', 'Nagpur', '2.9M', FALSE),
('India', 'Indore', '2.5M', FALSE),
('India', 'Thane', '2.4M', FALSE),
('India', 'Bhopal', '2.3M', FALSE),
('India', 'Visakhapatnam', '2.3M', FALSE),
('India', 'Patna', '2.5M', FALSE),
('India', 'Vadodara', '2.2M', FALSE),
('India', 'Ghaziabad', '2.4M', FALSE),
('India', 'Ludhiana', '1.9M', FALSE),
('India', 'Agra', '1.9M', FALSE),
('India', 'Nashik', '1.8M', FALSE),
('India', 'Faridabad', '1.6M', FALSE),
('India', 'Meerut', '1.5M', FALSE),
('India', 'Rajkot', '1.6M', FALSE),
('India', 'Varanasi', '1.4M', FALSE),
('India', 'Srinagar', '1.3M', FALSE),
('India', 'Amritsar', '1.2M', FALSE),
('India', 'Coimbatore', '1.1M', FALSE),
('India', 'Jodhpur', '1.1M', FALSE),
('India', 'Madurai', '1.1M', FALSE),
('India', 'Guwahati', '1.1M', FALSE),
('India', 'Chandigarh', '1.2M', FALSE),
('India', 'Kochi', '700K', FALSE),

-- Indonesia (Expanded)
('Indonesia', 'Jakarta', '11.0M', TRUE),
('Indonesia', 'Surabaya', '2.9M', FALSE),
('Indonesia', 'Bandung', '2.6M', FALSE),
('Indonesia', 'Medan', '2.5M', FALSE),
('Indonesia', 'Semarang', '1.8M', FALSE),
('Indonesia', 'Makassar', '1.5M', FALSE),
('Indonesia', 'Palembang', '1.7M', FALSE),
('Indonesia', 'Tangerang', '2.1M', FALSE),
('Indonesia', 'Depok', '2.5M', FALSE),
('Indonesia', 'South Tangerang', '1.7M', FALSE),
('Indonesia', 'Bekasi', '2.5M', FALSE),
('Indonesia', 'Bogor', '1.1M', FALSE),
('Indonesia', 'Malang', '895K', FALSE),
('Indonesia', 'Batam', '1.2M', FALSE),
('Indonesia', 'Pekanbaru', '1.1M', FALSE),
('Indonesia', 'Bandar Lampung', '1.0M', FALSE),
('Indonesia', 'Padang', '939K', FALSE),
('Indonesia', 'Denpasar', '947K', FALSE),
('Indonesia', 'Samarinda', '843K', FALSE),
('Indonesia', 'Balikpapan', '700K', FALSE),
('Indonesia', 'Manado', '451K', FALSE),
('Indonesia', 'Pontianak', '658K', FALSE),
('Indonesia', 'Yogyakarta', '422K', FALSE),
('Indonesia', 'Banjarmasin', '657K', FALSE),
('Indonesia', 'Surakarta', '522K', FALSE),

-- Iran
('Iran', 'Tehran', '9.4M', TRUE),
('Iran', 'Mashhad', '3.3M', FALSE),
('Iran', 'Isfahan', '2.2M', FALSE),
('Iran', 'Shiraz', '1.9M', FALSE),

-- Iraq
('Iraq', 'Baghdad', '8.1M', TRUE),
('Iraq', 'Basra', '2.9M', FALSE),
('Iraq', 'Mosul', '1.8M', FALSE),
('Iraq', 'Erbil', '1.5M', FALSE),

-- Ireland
('Ireland', 'Dublin', '1.4M', TRUE),
('Ireland', 'Cork', '210K', FALSE),
('Ireland', 'Limerick', '102K', FALSE),

-- Israel
('Israel', 'Jerusalem', '982K', TRUE),
('Israel', 'Tel Aviv', '460K', FALSE),
('Israel', 'Haifa', '285K', FALSE),

-- Italy
('Italy', 'Rome', '4.3M', TRUE),
('Italy', 'Milan', '3.1M', FALSE),
('Italy', 'Naples', '3.0M', FALSE),
('Italy', 'Turin', '1.8M', FALSE),

-- Japan (Expanded)
('Japan', 'Tokyo', '37.4M', TRUE),
('Japan', 'Osaka', '19.1M', FALSE),
('Japan', 'Nagoya', '9.5M', FALSE),
('Japan', 'Fukuoka', '5.5M', FALSE),
('Japan', 'Sapporo', '2.7M', FALSE),
('Japan', 'Kobe', '1.5M', FALSE),
('Japan', 'Kyoto', '1.5M', FALSE),
('Japan', 'Kawasaki', '1.5M', FALSE),
('Japan', 'Saitama', '1.3M', FALSE),
('Japan', 'Hiroshima', '1.2M', FALSE),
('Japan', 'Sendai', '1.1M', FALSE),
('Japan', 'Chiba', '980K', FALSE),
('Japan', 'Kitakyushu', '940K', FALSE),
('Japan', 'Sakai', '826K', FALSE),
('Japan', 'Niigata', '789K', FALSE),
('Japan', 'Hamamatsu', '791K', FALSE),
('Japan', 'Shizuoka', '693K', FALSE),
('Japan', 'Okayama', '725K', FALSE),
('Japan', 'Kumamoto', '738K', FALSE),
('Japan', 'Sagamihara', '725K', FALSE),
('Japan', 'Yokohama', '3.7M', FALSE),
('Japan', 'Kanazawa', '465K', FALSE),
('Japan', 'Nagasaki', '409K', FALSE),
('Japan', 'Okinawa', '143K', FALSE),
('Japan', 'Nara', '354K', FALSE),

-- Kenya
('Kenya', 'Nairobi', '5.1M', TRUE),
('Kenya', 'Mombasa', '1.4M', FALSE),
('Kenya', 'Kisumu', '610K', FALSE),

-- Malaysia (Expanded)
('Malaysia', 'Kuala Lumpur', '8.4M', TRUE),
('Malaysia', 'George Town', '790K', FALSE),
('Malaysia', 'Johor Bahru', '1.1M', FALSE),
('Malaysia', 'Ipoh', '820K', FALSE),
('Malaysia', 'Shah Alam', '650K', FALSE),
('Malaysia', 'Petaling Jaya', '638K', FALSE),
('Malaysia', 'Subang Jaya', '708K', FALSE),
('Malaysia', 'Kota Kinabalu', '500K', FALSE),
('Malaysia', 'Kuching', '570K', FALSE),
('Malaysia', 'Melaka', '503K', FALSE),
('Malaysia', 'Seremban', '573K', FALSE),
('Malaysia', 'Kuantan', '427K', FALSE),
('Malaysia', 'Kota Bharu', '491K', FALSE),
('Malaysia', 'Alor Setar', '405K', FALSE),
('Malaysia', 'Kuala Terengganu', '343K', FALSE),
('Malaysia', 'Miri', '300K', FALSE),
('Malaysia', 'Sandakan', '396K', FALSE),
('Malaysia', 'Tawau', '412K', FALSE),

-- Mexico
('Mexico', 'Mexico City', '21.9M', TRUE),
('Mexico', 'Guadalajara', '5.3M', FALSE),
('Mexico', 'Monterrey', '5.1M', FALSE),
('Mexico', 'Puebla', '3.2M', FALSE),

-- Morocco
('Morocco', 'Rabat', '1.9M', TRUE),
('Morocco', 'Casablanca', '3.8M', FALSE),
('Morocco', 'Fez', '1.2M', FALSE),
('Morocco', 'Marrakech', '1.0M', FALSE),

-- Netherlands
('Netherlands', 'Amsterdam', '1.2M', TRUE),
('Netherlands', 'Rotterdam', '655K', FALSE),
('Netherlands', 'The Hague', '548K', FALSE),
('Netherlands', 'Utrecht', '361K', FALSE),

-- New Zealand
('New Zealand', 'Wellington', '215K', TRUE),
('New Zealand', 'Auckland', '1.7M', FALSE),
('New Zealand', 'Christchurch', '389K', FALSE),

-- Nigeria
('Nigeria', 'Abuja', '3.6M', TRUE),
('Nigeria', 'Lagos', '15.4M', FALSE),
('Nigeria', 'Kano', '4.1M', FALSE),
('Nigeria', 'Ibadan', '3.6M', FALSE),

-- North Korea
('North Korea', 'Pyongyang', '3.1M', TRUE),
('North Korea', 'Hamhung', '769K', FALSE),
('North Korea', 'Chongjin', '667K', FALSE),

-- Norway
('Norway', 'Oslo', '1.1M', TRUE),
('Norway', 'Bergen', '285K', FALSE),
('Norway', 'Trondheim', '212K', FALSE),

-- Pakistan
('Pakistan', 'Islamabad', '1.2M', TRUE),
('Pakistan', 'Karachi', '16.8M', FALSE),
('Pakistan', 'Lahore', '13.5M', FALSE),
('Pakistan', 'Faisalabad', '3.7M', FALSE),

-- Peru
('Peru', 'Lima', '11.2M', TRUE),
('Peru', 'Arequipa', '1.1M', FALSE),
('Peru', 'Trujillo', '935K', FALSE),

-- Philippines (Expanded - All Regions)
('Philippines', 'Manila', '14.4M', TRUE),
-- NCR / Metro Manila
('Philippines', 'Quezon City', '3.0M', FALSE),
('Philippines', 'Caloocan', '1.7M', FALSE),
('Philippines', 'Makati', '630K', FALSE),
('Philippines', 'Taguig', '886K', FALSE),
('Philippines', 'Pasig', '803K', FALSE),
('Philippines', 'Parañaque', '689K', FALSE),
('Philippines', 'Las Piñas', '606K', FALSE),
('Philippines', 'Mandaluyong', '425K', FALSE),
('Philippines', 'Marikina', '456K', FALSE),
('Philippines', 'Muntinlupa', '543K', FALSE),
('Philippines', 'Pasay', '440K', FALSE),
('Philippines', 'Valenzuela', '714K', FALSE),
('Philippines', 'Malabon', '380K', FALSE),
('Philippines', 'Navotas', '250K', FALSE),
('Philippines', 'San Juan', '126K', FALSE),
('Philippines', 'Pateros', '65K', FALSE),
-- Luzon - North
('Philippines', 'Baguio', '366K', FALSE),
('Philippines', 'Dagupan', '174K', FALSE),
('Philippines', 'San Fernando (La Union)', '133K', FALSE),
('Philippines', 'Laoag', '112K', FALSE),
('Philippines', 'Vigan', '53K', FALSE),
('Philippines', 'Tuguegarao', '166K', FALSE),
('Philippines', 'Santiago', '134K', FALSE),
('Philippines', 'Cauayan', '140K', FALSE),
('Philippines', 'Ilagan', '158K', FALSE),
-- Luzon - Central
('Philippines', 'Angeles', '462K', FALSE),
('Philippines', 'San Fernando (Pampanga)', '340K', FALSE),
('Philippines', 'Olongapo', '260K', FALSE),
('Philippines', 'Tarlac City', '359K', FALSE),
('Philippines', 'Cabanatuan', '302K', FALSE),
('Philippines', 'Malolos', '281K', FALSE),
('Philippines', 'Meycauayan', '260K', FALSE),
('Philippines', 'San Jose del Monte', '651K', FALSE),
-- Luzon - South (CALABARZON)
('Philippines', 'Antipolo', '887K', FALSE),
('Philippines', 'Bacoor', '664K', FALSE),
('Philippines', 'Imus', '496K', FALSE),
('Philippines', 'Dasmariñas', '703K', FALSE),
('Philippines', 'General Trias', '450K', FALSE),
('Philippines', 'Cavite City', '102K', FALSE),
('Philippines', 'Calamba', '539K', FALSE),
('Philippines', 'San Pablo', '285K', FALSE),
('Philippines', 'Santa Rosa', '393K', FALSE),
('Philippines', 'Biñan', '407K', FALSE),
('Philippines', 'Cabuyao', '355K', FALSE),
('Philippines', 'San Pedro', '326K', FALSE),
('Philippines', 'Batangas City', '351K', FALSE),
('Philippines', 'Lipa', '372K', FALSE),
('Philippines', 'Lucena', '275K', FALSE),
('Philippines', 'Tayabas', '107K', FALSE),
-- Luzon - Bicol
('Philippines', 'Naga (Camarines Sur)', '215K', FALSE),
('Philippines', 'Legazpi', '210K', FALSE),
('Philippines', 'Sorsogon City', '180K', FALSE),
('Philippines', 'Tabaco', '138K', FALSE),
('Philippines', 'Iriga', '117K', FALSE),
('Philippines', 'Ligao', '117K', FALSE),
-- Visayas
('Philippines', 'Cebu City', '1.0M', FALSE),
('Philippines', 'Lapu-Lapu', '497K', FALSE),
('Philippines', 'Mandaue', '364K', FALSE),
('Philippines', 'Talisay (Cebu)', '227K', FALSE),
('Philippines', 'Danao', '142K', FALSE),
('Philippines', 'Toledo', '180K', FALSE),
('Philippines', 'Carcar', '128K', FALSE),
('Philippines', 'Bogo', '84K', FALSE),
('Philippines', 'Iloilo City', '457K', FALSE),
('Philippines', 'Bacolod', '600K', FALSE),
('Philippines', 'Dumaguete', '134K', FALSE),
('Philippines', 'Tagbilaran', '105K', FALSE),
('Philippines', 'Tacloban', '251K', FALSE),
('Philippines', 'Ormoc', '215K', FALSE),
('Philippines', 'Roxas City', '180K', FALSE),
('Philippines', 'Kalibo', '81K', FALSE),
-- Mindanao
('Philippines', 'Davao City', '1.8M', FALSE),
('Philippines', 'Cagayan de Oro', '728K', FALSE),
('Philippines', 'General Santos', '697K', FALSE),
('Philippines', 'Zamboanga City', '977K', FALSE),
('Philippines', 'Butuan', '372K', FALSE),
('Philippines', 'Iligan', '363K', FALSE),
('Philippines', 'Cotabato City', '325K', FALSE),
('Philippines', 'Koronadal', '198K', FALSE),
('Philippines', 'Tagum', '296K', FALSE),
('Philippines', 'Panabo', '184K', FALSE),
('Philippines', 'Digos', '196K', FALSE),
('Philippines', 'Dipolog', '130K', FALSE),
('Philippines', 'Pagadian', '214K', FALSE),
('Philippines', 'Surigao City', '166K', FALSE),
('Philippines', 'Bislig', '101K', FALSE),
('Philippines', 'Malaybalay', '184K', FALSE),
('Philippines', 'Valencia (Bukidnon)', '192K', FALSE),
('Philippines', 'Marawi', '201K', FALSE),
('Philippines', 'Ozamiz', '141K', FALSE),
('Philippines', 'Tandag', '56K', FALSE),

-- Poland
('Poland', 'Warsaw', '1.8M', TRUE),
('Poland', 'Kraków', '780K', FALSE),
('Poland', 'Łódź', '672K', FALSE),
('Poland', 'Wrocław', '643K', FALSE),

-- Portugal
('Portugal', 'Lisbon', '2.9M', TRUE),
('Portugal', 'Porto', '1.3M', FALSE),
('Portugal', 'Braga', '193K', FALSE),

-- Romania
('Romania', 'Bucharest', '1.8M', TRUE),
('Romania', 'Cluj-Napoca', '324K', FALSE),
('Romania', 'Timișoara', '319K', FALSE),

-- Russia
('Russia', 'Moscow', '12.6M', TRUE),
('Russia', 'Saint Petersburg', '5.6M', FALSE),
('Russia', 'Novosibirsk', '1.6M', FALSE),
('Russia', 'Yekaterinburg', '1.5M', FALSE),

-- Saudi Arabia
('Saudi Arabia', 'Riyadh', '7.7M', TRUE),
('Saudi Arabia', 'Jeddah', '4.7M', FALSE),
('Saudi Arabia', 'Mecca', '2.0M', FALSE),
('Saudi Arabia', 'Medina', '1.5M', FALSE),

-- Singapore
('Singapore', 'Singapore', '5.9M', TRUE),

-- South Africa
('South Africa', 'Pretoria', '2.6M', TRUE),
('South Africa', 'Johannesburg', '5.9M', FALSE),
('South Africa', 'Cape Town', '4.8M', FALSE),
('South Africa', 'Durban', '3.9M', FALSE),

-- South Korea (Expanded)
('South Korea', 'Seoul', '9.9M', TRUE),
('South Korea', 'Busan', '3.4M', FALSE),
('South Korea', 'Incheon', '3.0M', FALSE),
('South Korea', 'Daegu', '2.4M', FALSE),
('South Korea', 'Daejeon', '1.5M', FALSE),
('South Korea', 'Gwangju', '1.5M', FALSE),
('South Korea', 'Suwon', '1.2M', FALSE),
('South Korea', 'Ulsan', '1.1M', FALSE),
('South Korea', 'Goyang', '1.1M', FALSE),
('South Korea', 'Changwon', '1.0M', FALSE),
('South Korea', 'Seongnam', '948K', FALSE),
('South Korea', 'Yongin', '1.1M', FALSE),
('South Korea', 'Hwaseong', '930K', FALSE),
('South Korea', 'Cheongju', '846K', FALSE),
('South Korea', 'Jeonju', '654K', FALSE),
('South Korea', 'Ansan', '657K', FALSE),
('South Korea', 'Bucheon', '818K', FALSE),
('South Korea', 'Anyang', '554K', FALSE),
('South Korea', 'Gimhae', '540K', FALSE),
('South Korea', 'Pohang', '506K', FALSE),
('South Korea', 'Jeju', '492K', FALSE),
('South Korea', 'Pyeongtaek', '578K', FALSE),

-- Spain
('Spain', 'Madrid', '6.8M', TRUE),
('Spain', 'Barcelona', '5.6M', FALSE),
('Spain', 'Valencia', '1.6M', FALSE),
('Spain', 'Seville', '1.3M', FALSE),

-- Sweden
('Sweden', 'Stockholm', '1.6M', TRUE),
('Sweden', 'Gothenburg', '600K', FALSE),
('Sweden', 'Malmö', '350K', FALSE),

-- Switzerland
('Switzerland', 'Bern', '134K', TRUE),
('Switzerland', 'Zürich', '435K', FALSE),
('Switzerland', 'Geneva', '203K', FALSE),
('Switzerland', 'Basel', '178K', FALSE),

-- Taiwan
('Taiwan', 'Taipei', '2.6M', TRUE),
('Taiwan', 'Kaohsiung', '2.7M', FALSE),
('Taiwan', 'Taichung', '2.8M', FALSE),

-- Thailand (Expanded)
('Thailand', 'Bangkok', '11.1M', TRUE),
('Thailand', 'Chiang Mai', '131K', FALSE),
('Thailand', 'Pattaya', '120K', FALSE),
('Thailand', 'Nakhon Ratchasima', '174K', FALSE),
('Thailand', 'Udon Thani', '131K', FALSE),
('Thailand', 'Hat Yai', '159K', FALSE),
('Thailand', 'Khon Kaen', '114K', FALSE),
('Thailand', 'Chiang Rai', '73K', FALSE),
('Thailand', 'Nonthaburi', '270K', FALSE),
('Thailand', 'Pak Kret', '190K', FALSE),
('Thailand', 'Phuket', '83K', FALSE),
('Thailand', 'Surat Thani', '130K', FALSE),
('Thailand', 'Nakhon Si Thammarat', '106K', FALSE),
('Thailand', 'Ubon Ratchathani', '83K', FALSE),
('Thailand', 'Songkhla', '78K', FALSE),
('Thailand', 'Rayong', '70K', FALSE),
('Thailand', 'Krabi', '35K', FALSE),
('Thailand', 'Ayutthaya', '54K', FALSE),
('Thailand', 'Hua Hin', '63K', FALSE),
('Thailand', 'Samut Prakan', '388K', FALSE),

-- Turkey
('Turkey', 'Ankara', '5.7M', TRUE),
('Turkey', 'Istanbul', '15.6M', FALSE),
('Turkey', 'Izmir', '4.4M', FALSE),
('Turkey', 'Bursa', '3.1M', FALSE),

-- Ukraine
('Ukraine', 'Kyiv', '3.0M', TRUE),
('Ukraine', 'Kharkiv', '1.4M', FALSE),
('Ukraine', 'Odesa', '1.0M', FALSE),
('Ukraine', 'Dnipro', '980K', FALSE),

-- United Arab Emirates
('United Arab Emirates', 'Abu Dhabi', '1.5M', TRUE),
('United Arab Emirates', 'Dubai', '3.5M', FALSE),
('United Arab Emirates', 'Sharjah', '1.4M', FALSE),

-- United Kingdom (Expanded)
('United Kingdom', 'London', '9.5M', TRUE),
('United Kingdom', 'Birmingham', '1.1M', FALSE),
('United Kingdom', 'Manchester', '553K', FALSE),
('United Kingdom', 'Glasgow', '635K', FALSE),
('United Kingdom', 'Liverpool', '498K', FALSE),
('United Kingdom', 'Leeds', '793K', FALSE),
('United Kingdom', 'Sheffield', '584K', FALSE),
('United Kingdom', 'Edinburgh', '527K', FALSE),
('United Kingdom', 'Bristol', '467K', FALSE),
('United Kingdom', 'Leicester', '368K', FALSE),
('United Kingdom', 'Coventry', '371K', FALSE),
('United Kingdom', 'Bradford', '349K', FALSE),
('United Kingdom', 'Cardiff', '364K', FALSE),
('United Kingdom', 'Belfast', '345K', FALSE),
('United Kingdom', 'Nottingham', '331K', FALSE),
('United Kingdom', 'Newcastle', '302K', FALSE),
('United Kingdom', 'Stoke-on-Trent', '256K', FALSE),
('United Kingdom', 'Southampton', '269K', FALSE),
('United Kingdom', 'Plymouth', '264K', FALSE),
('United Kingdom', 'Reading', '232K', FALSE),
('United Kingdom', 'Derby', '257K', FALSE),
('United Kingdom', 'Wolverhampton', '254K', FALSE),
('United Kingdom', 'Aberdeen', '229K', FALSE),
('United Kingdom', 'Cambridge', '145K', FALSE),
('United Kingdom', 'Oxford', '152K', FALSE),

-- United States (Expanded)
('United States', 'Washington D.C.', '690K', TRUE),
('United States', 'New York', '8.3M', FALSE),
('United States', 'Los Angeles', '3.9M', FALSE),
('United States', 'Chicago', '2.7M', FALSE),
('United States', 'Houston', '2.3M', FALSE),
('United States', 'Phoenix', '1.6M', FALSE),
('United States', 'Philadelphia', '1.6M', FALSE),
('United States', 'San Antonio', '1.5M', FALSE),
('United States', 'San Diego', '1.4M', FALSE),
('United States', 'Dallas', '1.3M', FALSE),
('United States', 'San Jose', '1.0M', FALSE),
('United States', 'Austin', '978K', FALSE),
('United States', 'Jacksonville', '950K', FALSE),
('United States', 'Fort Worth', '936K', FALSE),
('United States', 'Columbus', '906K', FALSE),
('United States', 'Charlotte', '874K', FALSE),
('United States', 'San Francisco', '874K', FALSE),
('United States', 'Indianapolis', '867K', FALSE),
('United States', 'Seattle', '749K', FALSE),
('United States', 'Denver', '716K', FALSE),
('United States', 'Boston', '675K', FALSE),
('United States', 'Nashville', '689K', FALSE),
('United States', 'Detroit', '639K', FALSE),
('United States', 'Portland', '652K', FALSE),
('United States', 'Las Vegas', '641K', FALSE),
('United States', 'Memphis', '633K', FALSE),
('United States', 'Louisville', '617K', FALSE),
('United States', 'Baltimore', '576K', FALSE),
('United States', 'Milwaukee', '577K', FALSE),
('United States', 'Albuquerque', '564K', FALSE),
('United States', 'Tucson', '542K', FALSE),
('United States', 'Fresno', '542K', FALSE),
('United States', 'Sacramento', '524K', FALSE),
('United States', 'Atlanta', '499K', FALSE),
('United States', 'Miami', '442K', FALSE),
('United States', 'New Orleans', '383K', FALSE),
('United States', 'Honolulu', '350K', FALSE),
('United States', 'Anchorage', '288K', FALSE),

-- Venezuela
('Venezuela', 'Caracas', '2.9M', TRUE),
('Venezuela', 'Maracaibo', '2.0M', FALSE),
('Venezuela', 'Valencia', '1.6M', FALSE),

-- Vietnam (Expanded)
('Vietnam', 'Hanoi', '8.4M', TRUE),
('Vietnam', 'Ho Chi Minh City', '9.3M', FALSE),
('Vietnam', 'Da Nang', '1.2M', FALSE),
('Vietnam', 'Hai Phong', '2.1M', FALSE),
('Vietnam', 'Can Tho', '1.2M', FALSE),
('Vietnam', 'Bien Hoa', '1.1M', FALSE),
('Vietnam', 'Hue', '455K', FALSE),
('Vietnam', 'Nha Trang', '535K', FALSE),
('Vietnam', 'Vung Tau', '527K', FALSE),
('Vietnam', 'Buon Ma Thuot', '340K', FALSE),
('Vietnam', 'Quy Nhon', '311K', FALSE),
('Vietnam', 'Thai Nguyen', '330K', FALSE),
('Vietnam', 'Long Xuyen', '280K', FALSE),
('Vietnam', 'Rach Gia', '228K', FALSE),
('Vietnam', 'Vinh', '491K', FALSE),
('Vietnam', 'Da Lat', '227K', FALSE),
('Vietnam', 'My Tho', '226K', FALSE),
('Vietnam', 'Thanh Hoa', '400K', FALSE),
('Vietnam', 'Ha Long', '300K', FALSE),
('Vietnam', 'Phan Thiet', '255K', FALSE);

SELECT 'Cities table created successfully!' AS Status;
