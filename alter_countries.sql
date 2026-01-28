-- Run this SQL in phpMyAdmin to add new columns to the countries table

ALTER TABLE `countries`
ADD COLUMN `population` BIGINT NULL AFTER `flag`,
ADD COLUMN `area_km2` INT NULL AFTER `population`,
ADD COLUMN `continent` VARCHAR(50) NULL AFTER `area_km2`,
ADD COLUMN `currency` VARCHAR(100) NULL AFTER `continent`,
ADD COLUMN `language` VARCHAR(100) NULL AFTER `currency`,
ADD COLUMN `timezone` VARCHAR(50) NULL AFTER `language`;

-- Sample data updates (run these to add data for some countries)
UPDATE `countries` SET 
    population = 331002651, 
    area_km2 = 9833520, 
    continent = 'North America', 
    currency = 'US Dollar (USD)', 
    language = 'English', 
    timezone = 'UTC-5 to UTC-10'
WHERE country_name = 'United States';

UPDATE `countries` SET 
    population = 125800000, 
    area_km2 = 377975, 
    continent = 'Asia', 
    currency = 'Japanese Yen (JPY)', 
    language = 'Japanese', 
    timezone = 'UTC+9'
WHERE country_name = 'Japan';

UPDATE `countries` SET 
    population = 67390000, 
    area_km2 = 643801, 
    continent = 'Europe', 
    currency = 'Euro (EUR)', 
    language = 'French', 
    timezone = 'UTC+1'
WHERE country_name = 'France';

UPDATE `countries` SET 
    population = 83240000, 
    area_km2 = 357114, 
    continent = 'Europe', 
    currency = 'Euro (EUR)', 
    language = 'German', 
    timezone = 'UTC+1'
WHERE country_name = 'Germany';

UPDATE `countries` SET 
    population = 1380004385, 
    area_km2 = 3287263, 
    continent = 'Asia', 
    currency = 'Indian Rupee (INR)', 
    language = 'Hindi, English', 
    timezone = 'UTC+5:30'
WHERE country_name = 'India';

UPDATE `countries` SET 
    population = 1439323776, 
    area_km2 = 9596961, 
    continent = 'Asia', 
    currency = 'Chinese Yuan (CNY)', 
    language = 'Mandarin Chinese', 
    timezone = 'UTC+8'
WHERE country_name = 'China';

UPDATE `countries` SET 
    population = 212559417, 
    area_km2 = 8515767, 
    continent = 'South America', 
    currency = 'Brazilian Real (BRL)', 
    language = 'Portuguese', 
    timezone = 'UTC-3 to UTC-5'
WHERE country_name = 'Brazil';

UPDATE `countries` SET 
    population = 67886011, 
    area_km2 = 242495, 
    continent = 'Europe', 
    currency = 'British Pound (GBP)', 
    language = 'English', 
    timezone = 'UTC+0'
WHERE country_name = 'United Kingdom';

UPDATE `countries` SET 
    population = 25499884, 
    area_km2 = 7692024, 
    continent = 'Oceania', 
    currency = 'Australian Dollar (AUD)', 
    language = 'English', 
    timezone = 'UTC+8 to UTC+11'
WHERE country_name = 'Australia';

UPDATE `countries` SET 
    population = 38005238, 
    area_km2 = 9984670, 
    continent = 'North America', 
    currency = 'Canadian Dollar (CAD)', 
    language = 'English, French', 
    timezone = 'UTC-3.5 to UTC-8'
WHERE country_name = 'Canada';

UPDATE `countries` SET 
    population = 109581078, 
    area_km2 = 300000, 
    continent = 'Asia', 
    currency = 'Philippine Peso (PHP)', 
    language = 'Filipino, English', 
    timezone = 'UTC+8'
WHERE country_name = 'Philippines';

UPDATE `countries` SET 
    population = 51269185, 
    area_km2 = 100210, 
    continent = 'Asia', 
    currency = 'South Korean Won (KRW)', 
    language = 'Korean', 
    timezone = 'UTC+9'
WHERE country_name = 'South Korea';

UPDATE `countries` SET 
    population = 60461826, 
    area_km2 = 301340, 
    continent = 'Europe', 
    currency = 'Euro (EUR)', 
    language = 'Italian', 
    timezone = 'UTC+1'
WHERE country_name = 'Italy';

UPDATE `countries` SET 
    population = 47351567, 
    area_km2 = 505990, 
    continent = 'Europe', 
    currency = 'Euro (EUR)', 
    language = 'Spanish', 
    timezone = 'UTC+1'
WHERE country_name = 'Spain';

UPDATE `countries` SET 
    population = 128932753, 
    area_km2 = 1964375, 
    continent = 'North America', 
    currency = 'Mexican Peso (MXN)', 
    language = 'Spanish', 
    timezone = 'UTC-6 to UTC-8'
WHERE country_name = 'Mexico';
