-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Feb 2020 pada 17.47
-- Versi server: 10.1.30-MariaDB
-- Versi PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clasinv`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `clients`
--

CREATE TABLE `clients` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `client_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `increment_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `currencies`
--

CREATE TABLE `currencies` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `format` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `exchange_rate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `default_currency` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `currencies`
--

INSERT INTO `currencies` (`uuid`, `name`, `code`, `symbol`, `format`, `exchange_rate`, `active`, `default_currency`, `created_at`, `updated_at`) VALUES
('0016694e-470e-411e-a483-0dcb094ef5c3', 'Moroccan Dirham', 'MAD', 'د.م.‏', 'د.م.‏ 1,0.00', '9.362', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:27'),
('0055b964-9cf8-4ad3-b9ec-d34779cc96bf', 'Mongolia, Tugrik', 'MNT', '₮', '₮1 0,00', '2433', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:27'),
('0281d199-5767-4edb-be9f-4b9619ef2eff', 'Ukraine, Hryvnia', 'UAH', '₴', '1 0,00₴', '25.99', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:27'),
('029f63cc-83bb-41cb-94c9-c16c1e490aa0', 'Cape Verde Escudo', 'CVE', '$', '$1,0.00', '92.46', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:27'),
('02fc042a-c411-43d9-99eb-9720eb6bd5d6', 'Somali Shilling', 'SOS', 'S', 'S1,0.00', '557', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:27'),
('05cf8d58-ea3c-42e5-8eb9-fe4609979e94', 'CFP Franc', 'XPF', 'F', '1,0.00F', '99.47', 0, 0, '2017-08-03 12:56:27', '2017-09-06 09:35:27'),
('06f27962-b10a-4686-8c72-79d36683261b', 'Afghanistan, Afghani', 'AFN', '؋', '؋1,0.00', '68.31', 1, 0, '2017-08-03 12:56:21', '2017-09-06 09:35:27'),
('079cbc9c-0313-4f35-839d-10633b512521', 'Georgia, Lari', 'GEL', 'Lari', '1 0,00 Lari', '2.4826', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:27'),
('0bc45a8a-919d-47f6-a242-c17e43e6f295', 'Cayman Islands Dollar', 'KYD', '$', '$1,0.00', '0.82', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:27'),
('0bfb3531-2793-487f-9369-76c1b52607fc', 'Sudanese Dinar', 'SDD', 'LSd', '1,0.00LSd', '0', 0, 0, '2017-08-03 12:56:26', '2017-08-03 12:56:26'),
('0c868ef3-53aa-48b5-a7f8-46833813f9c4', 'Angola, Kwanza', 'AOA', 'Kz', 'Kz1,0.00', '165.09', 1, 0, '2017-08-03 12:56:21', '2017-09-06 09:35:27'),
('0d5c6e29-8d14-4084-8bc7-e92e5ea7680e', 'Samoa, Tala', 'WST', 'WS$', 'WS$1,0.00', '2.5126', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:27'),
('13b6db34-4f74-4cdc-a506-87d6b7d03866', 'Uganda Shilling', 'UGX', 'USh', 'USh1,0.00', '3592', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:27'),
('167659ae-4223-4614-9d50-1afcd64ff5d8', 'Hungary, Forint', 'HUF', 'Ft', '1 0,00 Ft', '256.74', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:27'),
('18bb4cd4-03b2-48d7-abea-c80d792f6237', 'Bolivia, Boliviano', 'BOB', 'Bs', 'Bs 1,0.00', '6.9', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:27'),
('19783b58-0d28-448f-bb00-a87cb71dbf85', 'Macao, Pataca', 'MOP', 'MOP$', 'MOP$1,0.00', '8.0602', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:27'),
('199469a3-f3f4-44b1-9c4f-766792f0bd05', 'Bermudian Dollar', 'BMD', '$', '$1,0.00', '1', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:27'),
('1c967173-8443-408e-b797-801f8fd1bddf', 'Lebanese Pound', 'LBP', 'ل.ل.‏', 'ل.ل.‏ 1,0.00', '1505.7', 1, 0, '2017-08-03 12:56:24', '2017-09-07 13:12:11'),
('20cd4fda-a0f3-46c2-8de8-5f3f4365d9e6', 'Malaysian Ringgit', 'MYR', 'RM', 'RM1,0.00', '4.237', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:28'),
('274d029f-8870-47e6-867a-e069561a124b', 'Saudi Riyal', 'SAR', '﷼', '﷼ 1,0.00', '3.75', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:28'),
('285066d9-0441-4c7a-aad8-fb730646cf7c', 'Serbian Dinar', 'RSD', 'Дин.', '1,0.00 Дин.', '100.05', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:28'),
('299e95b2-b24a-4b9b-8f43-683c7fbca3ed', 'Tanzanian Shilling', 'TZS', 'TSh', 'TSh1,0.00', '2232', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('2c2532fe-75ad-4141-b685-837262d43d4c', 'Nigeria, Naira', 'NGN', '₦', '₦1,0.00', '360', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:28'),
('2c44f84b-6a2e-439e-a9de-6d1d2a577344', 'Swedish Krona', 'SEK', 'kr', '1 0,00 kr', '7.9608', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('2d260c38-4243-4553-a51e-abb1d74d328d', 'Cuban Convertible Peso', 'CUC', 'CUC', 'CUC1,0.00', '0.995', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:28'),
('30b58ee9-cdd7-45b4-90ad-218d7160d226', 'Gambia, Dalasi', 'GMD', 'D', '1,0.00D', '44.95', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:28'),
('3223e7c4-f0ed-4e7f-b207-5a91dc735947', 'Algerian Dinar', 'DZD', 'د.ج‏', 'د.ج‏ 1,0.00', '110.76', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:28'),
('33bdac52-0adf-40b8-a3ac-031e1effa286', 'Namibian Dollar', 'NAD', '$', '$1,0.00', '12.88', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:28'),
('3589703f-144c-44ca-9c0c-2c5834777630', 'Thailand, Baht', 'THB', '฿', '฿1,0.00', '33.14', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('3c7b5e78-7547-4c7c-8889-d3496208baee', 'Czech Koruna', 'CZK', 'Kč', '1 0,00 Kč', '21.886', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:28'),
('3ca2d9cc-8022-478a-b4d0-7b69acb4ef5c', 'Bhutan, Ngultrum', 'BTN', 'Nu.', 'Nu. 1,0.0', '64.1', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:28'),
('3ca50d0b-b982-4bdf-b9b3-758774119ec8', 'Euro', 'EUR', '€', '1.0,00 €', '0.8382', 1, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:28'),
('3edd7c0a-fde7-423f-8ee6-27150c4c6997', 'US Dollar', 'USD', '$', '$1,0.00', '1', 1, 1, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('3f877e28-6c58-48f1-97aa-b8fb2e2bed65', 'Azerbaijanian Manat', 'AZN', '₼', '1 0,00 ₼', '1.7004', 1, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:28'),
('40395926-1fe6-4735-a5fa-fc04bbd1ce09', 'Macedonia, Denar', 'MKD', 'ден.', '1,0.00 ден.', '51.33', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:28'),
('43b567d8-fb17-4dc5-a2b7-0692802f4dd0', 'Kyrgyzstan, Som', 'KGS', 'сом', '1 0-00 сом', '68.454', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:28'),
('4940b89f-85b3-4cf9-a29d-8166322b9881', 'Moldovan Leu', 'MDL', 'lei', '1,0.00 lei', '17.625', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:28'),
('4ac72ae3-38ac-45fd-9a3a-dc5cb35b1831', 'Bangladesh, Taka', 'BDT', '৳', '৳ 1,0.', '81.18', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:28'),
('4ba6862d-ae64-4083-8b11-8db9371c36bd', 'Iceland Krona', 'ISK', 'kr.', '1,0. kr.', '105.9', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:28'),
('4c20cf5a-c368-4ba5-8e4b-ab2ac89704c0', 'Paraguay, Guarani', 'PYG', '₲', '₲ 1,0.00', '5654', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:28'),
('4caa827a-8f35-47a1-814e-21cc01ec6c79', 'Solomon Islands Dollar', 'SBD', '$', '$1,0.00', '7.7195', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('4cc01049-b9c1-4fde-b01c-0c0c994be04d', 'Tonga, Paanga', 'TOP', 'T$', 'T$1,0.00', '2.2109', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('4fc0495f-4364-45af-a6b7-7124c0a6806c', 'Swaziland, Lilangeni', 'SZL', 'E', 'E1,0.00', '12.89', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('505c76cb-c35e-4ea8-9079-284b27fbcddd', 'Pound Sterling', 'GBP', '£', '£1,0.00', '0.7659', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:28'),
('51ac791c-e11c-4ce1-a530-550e9fb8ba13', 'Singapore Dollar', 'SGD', '$', '$1,0.00', '1.3488', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('52d1f616-9f5c-4341-bb6a-fa3774fd808c', 'Falkland Islands Pound', 'FKP', '£', '£1,0.00', '0.7662', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:28'),
('53d114e7-0ac7-4c79-b63a-ae800244d3ba', 'Papua New Guinea, Kina', 'PGK', 'K', 'K1,0.00', '3.1898', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:28'),
('5646c53f-f41b-432c-9690-0231722baaa4', 'Sao Tome and Principe, Dobra', 'STD', 'Db', 'Db1,0.00', '20545', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:28'),
('56c93bc9-d4bb-4e19-ac55-aa00a01d33c5', 'Kazakhstan, Tenge', 'KZT', '₸', '₸1 0-00', '341.37', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:29'),
('58094e72-86c5-4750-b09b-cbd25127909f', 'Vanuatu, Vatu', 'VUV', 'VT', '1,0.VT', '103.06', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:29'),
('5b353005-0cb3-42f7-9474-92ee722bb51c', 'New Taiwan Dollar', 'TWD', 'NT$', 'NT$1,0.00', '30.07', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:29'),
('5ce14d40-1fd6-48a3-a61d-c442ed355c47', 'Indonesia, Rupiah', 'IDR', 'Rp', 'Rp1,0.', '13336', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:29'),
('62fb5ce3-8c05-4024-a8a3-6cd8a4de41c4', 'Rial Omani', 'OMR', '﷼', '﷼ 1,0.000', '0.3845', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:29'),
('636cc1ec-e033-40a5-9f0d-6997812c8777', 'Brunei Dollar', 'BND', '$', '$1,0.', '1.348', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:29'),
('63ae22cf-8833-4554-aadf-ff43b3ccd4b7', 'New Turkish Lira', 'TRY', 'TL', '1,0.00 TL', '3.4269', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:29'),
('64a716f6-b5bf-460b-9bab-58ea8fe8595d', 'Bahamian Dollar', 'BSD', '$', '$1,0.00', '1', 1, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:29'),
('64d09c26-234f-4701-b11e-8513eddf62e1', 'El Salvador Colon', 'SVC', '₡', '₡1,0.00', '8.75', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:29'),
('64e7ee72-66f5-40bc-ad3a-216dd0029af9', 'Australian Dollar', 'AUD', '$', '$1,0.00', '1.2488', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:29'),
('655e53c2-e221-495d-945b-22cc120eba68', 'Peru, Nuevo Sol', 'PEN', 'S/.', 'S/. 1,0.00', '3.2337', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:29'),
('6a171f5d-094e-4f0c-a90c-066bf4d345b4', 'Croatian Kuna', 'HRK', 'kn', '1,0.00 kn', '6.225', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:29'),
('6c4cc5ca-455a-4726-8822-7e934d7df6bb', 'Brazilian Real', 'BRL', 'R$', 'R$ 1,0.00', '3.1082', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:29'),
('7005da6b-3740-4ce4-a643-ae7a492550d2', 'Myanmar, Kyat', 'MMK', 'K', 'K1,0.00', '1354', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:29'),
('70701ac9-87c0-4111-94b2-99dbfd970b52', 'Swiss Franc', 'CHF', 'CHF', '1\'0.00 CHF', '0.9556', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:29'),
('72014f68-e6d4-48b3-b7fb-ce7e9bec8be4', 'South Africa, Rand', 'ZAR', 'R', 'R 1,0.00', '12.758', 0, 0, '2017-08-03 12:56:27', '2017-09-06 09:35:29'),
('726e2dd2-905c-4bfd-a2a6-ef8fc6c56e2f', 'Philippine Peso', 'PHP', '₱', '₱1,0.00', '50.95', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:29'),
('739d40a1-5e21-4dc0-8181-b57ab4a20874', 'Tunisian Dinar', 'TND', 'د.ت.‏', 'د.ت.‏ 1,0.000', '2.4204', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:29'),
('74477665-2b73-4fb4-abce-aab0ca2705dd', 'Fiji Dollar', 'FJD', '$', '$1,0.00', '2.025', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:29'),
('74a8e2c6-1f41-4e7c-bb27-24567f099b8e', 'Honduras, Lempira', 'HNL', 'L.', 'L. 1,0.00', '23.33', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:29'),
('76813286-bacf-4db7-b684-2501ddf67cc6', 'Bulgarian Lev', 'BGN', 'лв.', '1 0,00 лв.', '1.6449', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('772d4c38-40a1-4d0b-8a6a-d3098f0ec33b', 'Venezuela Bolivares Fuertes', 'VEF', 'Bs. F.', 'Bs. F. 1,0.00', '9.975', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:30'),
('79a30a99-ee35-4eaf-b509-38668380a064', 'Belize Dollar', 'BZD', 'BZ$', 'BZ$1,0.00', '1.9977', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('79bc1aaf-2bf0-49a7-8157-ba86f1ee004c', 'Colombian Peso', 'COP', '$', '$ 1,0.00', '2917', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('7a2abef6-194a-42b8-b3ed-f1fc7f0a410e', 'Yemeni Rial', 'YER', '﷼', '﷼ 1,0.00', '249.95', 0, 0, '2017-08-03 12:56:27', '2017-09-06 09:35:30'),
('7c7fdd8a-3f31-4da4-b33e-09fbdca5cdc2', 'Burundi Franc', 'BIF', 'FBu', '1,0.FBu', '1730.8', 1, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('7cfe9256-806f-4024-b42d-5923165edf99', 'Sierra Leone, Leone', 'SLL', 'Le', 'Le1,0.00', '7500', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:30'),
('7e760bb7-b8b1-4717-b6ae-58f25e0b326a', 'Poland, Zloty', 'PLN', 'zł', '1 0,00 zł', '3.5642', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:30'),
('7fe99e35-91b7-48ac-99e7-245436abdfd2', 'Liberian Dollar', 'LRD', '$', '$1,0.00', '116.5', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:30'),
('8029c92c-dc88-4d05-b44e-47f67235f856', 'Bosnia and Herzegovina, Convertible Marks', 'BAM', 'КМ', '1,0.00 КМ', '1.6421', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('83507379-320a-4b3d-a570-f9f59c821cc7', 'Mauritius Rupee', 'MUR', '₨', '₨1,0.00', '32.73', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:30'),
('87802173-67f7-4599-8620-a020a7550821', 'Mexican Peso', 'MXN', '$', '$1,0.00', '17.781', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:30'),
('87875446-b8c6-4b13-9b6c-cfa88170aed5', 'Cambodia, Riel', 'KHR', '៛', '1,0.៛', '4030', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:30'),
('878db3d7-4a7a-4cb7-9345-a56f7f133434', 'Canadian Dollar', 'CAD', '$', '$1,0.00', '1.2223', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('88b067f3-c413-4ff7-ba81-a2fe0dbabb51', 'Maltese Lira', 'MTL', '₤', '₤1,0.00', '0', 0, 0, '2017-08-03 12:56:24', '2017-08-03 12:56:24'),
('8908fc95-4b2d-4b87-bb65-da652694af62', 'Russian Ruble', 'RUB', '₽', '1 0,00 ₽', '57.315', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:30'),
('8b1681eb-8887-41f2-ae9a-59eb7c25fe49', 'Malagasy Ariary', 'MGA', 'Ar', 'Ar1,0.', '3185', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:30'),
('8f9028d5-aedc-4322-b5c4-76b9f961b91b', 'Argentine Peso', 'ARS', '$', '$ 1,0.00', '17.229', 1, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:30'),
('8fe451ae-2c17-47cd-ad40-7e8523db137d', 'Surinam Dollar', 'SRD', '$', '$1,0.00', '7.37', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:30'),
('922e646b-c5e6-4501-8e57-410418c51c0f', 'Netherlands Antillian Guilder', 'ANG', 'ƒ', 'ƒ1,0.00', '1.77', 0, 0, '2017-08-03 12:56:21', '2017-09-06 09:35:30'),
('93c0881c-351c-407c-b086-455b43850d5f', 'Trinidad and Tobago Dollar', 'TTD', 'TT$', 'TT$1,0.00', '6.7095', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:30'),
('94c616c7-ab8b-41a3-953f-dce7933d0e0d', 'Qatari Rial', 'QAR', '﷼', '﷼ 1,0.00', '3.6413', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:30'),
('9511dc1e-4ab8-4f41-bf96-6b722aed313c', 'Kuwaiti Dinar', 'KWD', 'دينار‎‎‏', 'دينار‎‎‏ 1,0.000', '0.3014', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:30'),
('956f6c62-d4d9-45a3-8a15-93414e362ba2', 'Saint Helena Pound', 'SHP', '£', '£1,0.00', '0.7664', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:30'),
('95cce63b-e10a-4b9e-a911-f3bae37dea96', 'Panama, Balboa', 'PAB', 'B/.', 'B/. 1,0.00', '1', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:30'),
('970ef7c7-6e12-4f2b-a40b-b224b36fc1be', 'Mauritania, Ouguiya', 'MRO', 'UM', '1,0.00UM', '361', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:31'),
('9b22a971-8864-422a-828b-fc8141aa22d3', 'Laos, Kip', 'LAK', '₭', '1,0.₭', '8301', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:31'),
('9df9f9d9-cf79-4454-bb79-c16aa13457be', 'Peso Uruguayo', 'UYU', '$U', '$U 1,0.00', '28.71', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:31'),
('a081b98a-46e5-46c5-b4bc-be5d57876789', 'Japan, Yen', 'JPY', '¥', '¥1,0.', '108.94', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:31'),
('a0db47df-85ff-4db8-8db2-494c66557413', 'Armenian Dram', 'AMD', '&#1423;', '1,0.00 &#1423;', '477.76', 0, 0, '2017-08-03 12:56:21', '2017-09-06 09:35:31'),
('a1f9bba2-c1fc-4eeb-bd37-439af64f6089', 'Ethiopian Birr', 'ETB', 'ETB', 'ETB1,0.00', '23.31', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:31'),
('a3585979-2bb1-4b44-acd5-aac1beb127b3', 'North Korean Won', 'KPW', '₩', '₩1,0.', '900', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:31'),
('a3dc5c3c-6da0-4e3d-9935-c91249083ccf', 'Mozambique Metical', 'MZN', 'MT', 'MT1,0.', '60.8', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:31'),
('a47dd8ab-4ef3-45af-8311-debd14816b78', 'Kenyan Shilling', 'KES', 'S', 'S1,0.00', '103.15', 1, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:31'),
('a5e44a0f-01ab-450a-aab4-3d5f5a205801', 'Barbados Dollar', 'BBD', '$', '$1,0.00', '2', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('aba53944-5ea3-4177-a8c8-6666c0be174e', 'Maldives, Rufiyaa', 'MVR', 'MVR', '1,0.0 MVR', '15.35', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:32'),
('ac64809e-8714-4bcf-abb4-a3b6e6933ce4', 'Hong Kong Dollar', 'HKD', 'HK$', 'HK$1,0.00', '7.8257', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('adb5f9f2-4d9d-4d0e-bd7e-dfcaf73f527e', 'Iranian Rial', 'IRR', '﷼', '﷼ 1,0/00', '33291', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('ae412e99-15dd-47fb-a273-aaaf9717cad4', 'Danish Krone', 'DKK', 'kr.', '1 0,00 kr.', '6.2372', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('ae841e40-c2d3-4922-bdd8-9914ae837b8b', 'Seychelles Rupee', 'SCR', '₨', '₨1,0.00', '13.414', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:32'),
('af2b792d-1008-40bf-9438-22269f09d667', 'New Israeli Shekel', 'ILS', '₪', '₪ 1,0.00', '3.5461', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('af88085f-0f7c-4162-8852-113be5d4379b', 'Haiti, Gourde', 'HTG', 'G', 'G1,0.00', '61.55', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('af8df31d-4470-4d52-bbf9-d64bac1f279c', 'Franc Congolais', 'CDF', 'FC', '1,0.00FC', '1552.8', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('b3626554-f799-4a36-9c01-475a054ba831', 'Lesotho, Loti', 'LSL', 'M', '1,0.00M', '12.87', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:32'),
('b403a059-bbd2-4461-9eae-89e380f19837', 'Albania, Lek', 'ALL', 'Lek', '1,0.00Lek', '111.44', 1, 0, '2017-08-03 12:56:21', '2017-09-06 09:35:32'),
('b59ea484-3513-454c-83e3-e67e94295c08', 'Pakistan Rupee', 'PKR', '₨', '₨1,0.00', '105', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:32'),
('b5a5af20-b381-4268-ba25-c66620caa4fa', 'Belarussian Ruble', 'BYR', 'р.', '1 0,00 р.', '20020', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('b6e3d0b8-075d-4b60-ba75-60597b5c9ea4', 'Franc CFA (XAF)', 'XAF', 'F.CFA', '1,0.00 F.CFA', '549.48', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:32'),
('b8e4d8f1-f0b5-4a21-bd40-7a0d49031251', 'Libyan Dinar', 'LYD', 'د.ل.‏', 'د.ل.‏1,0.000', '1.3567', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:32'),
('b92dbd8d-165b-4c0c-8d0f-9a8380ed8cf6', 'China Yuan Renminbi', 'CNY', '¥', '¥1,0.00', '6.522', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('b95a9587-80b1-42d0-a28e-869198e41536', 'Zambia Kwacha', 'ZMW', 'ZK', 'ZK1,0.00', '9.08', 0, 0, '2017-08-03 12:56:27', '2017-09-06 09:35:32'),
('b9dc71db-b8c7-4343-9a98-8d812ae31460', 'New Zealand Dollar', 'NZD', '$', '$1,0.00', '1.3857', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:32'),
('baf2d3eb-4b75-49fa-ad6a-3716acea5bc4', 'Dominican Peso', 'DOP', 'RD$', 'RD$1,0.00', '47.1', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('bc5a7439-31c4-4f22-9c14-b1672c453520', 'Bahraini Dinar', 'BHD', '.د.', '.د. 1,0.000', '0.377', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('bde9ea03-10f6-4744-b069-f8d3fd84daa0', 'Jamaican Dollar', 'JMD', 'J$', 'J$1,0.00', '128.29', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('c41fad13-7447-4db9-b8a7-0e99fc7ebb96', 'Jordanian Dinar', 'JOD', 'د.ا.‏', 'د.ا.‏ 1,0.000', '0.707', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('c4787a70-884a-4023-b5e3-f7ad567aa4d8', 'Romania, New Leu', 'RON', 'lei', '1,0.00 lei', '3.8494', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:32'),
('c4ec4a29-0bb3-448f-a098-0a3f967fd101', 'Guatemala, Quetzal', 'GTQ', 'Q', 'Q1,0.00', '7.292', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:32'),
('c636f0e3-10dd-437d-ad65-0e362814a8f6', 'Egyptian Pound', 'EGP', 'ج.م', 'ج.م 1,0.00', '17.63', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:32'),
('c9698589-1935-48f4-81c2-569b52c091b6', 'Syrian Pound', 'SYP', '£', '£ 1,0.00', '514.98', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:32'),
('cabeae3e-a485-444f-93a6-43f441be5ceb', 'Djibouti Franc', 'DJF', 'Fdj', '1,0.Fdj', '177.6', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:33'),
('cbd4fba6-70a2-4995-bc46-59d01f5e34d0', 'Sri Lanka Rupee', 'LKR', '₨', '₨ 1,0.', '152.59', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:33'),
('cde09421-4718-4741-af63-aa32b1aec351', 'Aruban Guilder', 'AWG', 'ƒ', 'ƒ1,0.00', '1.78', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:33'),
('d0a4a689-6a08-4edd-bd01-077c0ef48c0a', 'UAE Dirham', 'AED', 'دإ‏', 'دإ‏ 1,0.00', '3.6727', 0, 0, '2017-08-03 12:56:21', '2017-09-06 09:35:33'),
('d276a095-b87e-4947-a54e-84ea8a68694b', 'Eritrea, Nakfa', 'ERN', 'Nfk', '1,0.00Nfk', '15.29', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('d31e4251-afe2-4853-9db8-2dcaa18c9213', 'Nepalese Rupee', 'NPR', '₨', '₨1,0.00', '102.5', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:33'),
('d452f1eb-5a64-42dc-adcf-9074b47b69ba', 'Tajikistan, Somoni', 'TJS', 'TJS', '1 0;00 TJS', '8.8045', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:33'),
('db62b296-5c8d-4125-88cd-356a54c6ed8d', 'Iraqi Dinar', 'IQD', 'د.ع.‏', 'د.ع.‏ 1,0.00', '1167', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('dd059769-ed63-4257-b6d8-e97fdbafbb18', 'Gibraltar Pound', 'GIP', '£', '£1,0.00', '0.7664', 1, 0, '2017-08-03 12:56:23', '2017-09-07 13:11:13'),
('dd9b9e92-ffef-4941-b356-92092ee2ca46', 'Ghana Cedi', 'GHS', '₵', '₵1,0.00', '4.3985', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('de4fc0b5-dadb-4c8f-9eb7-f701ed0703dc', 'Botswana, Pula', 'BWP', 'P', 'P1,0.00', '10.065', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:33'),
('e2702321-6434-4264-8b9b-3acbd7369d2d', 'Chilean Peso', 'CLP', '$', '$ 1,0.00', '618.3', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:33'),
('e57c1204-61c3-4812-aad9-121faee0b936', 'Indian Rupee', 'INR', '₹', '1,0.00₹', '64.054', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('e57e8b51-4533-4e0e-b620-7055378a6514', 'Malawi, Kwacha', 'MWK', 'MK', 'MK1,0.00', '716.19', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:33'),
('e616dc76-6ece-4fbf-ab11-6c6bb28818fa', 'East Caribbean Dollar', 'XCD', '$', '$1,0.00', '2.7', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:33'),
('eaed88c6-4686-4906-830d-1e78f5161cc7', 'Uzbekistan Sum', 'UZS', 'сўм', '1 0,00 сўм', '8070', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:33'),
('eb8e2b8e-6b32-4237-9673-b4bf918d0018', 'Comoro Franc', 'KMF', 'CF', '1,0.00CF', '412.3', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('eb9272bc-fba5-4461-a9fd-c1169f1241cd', 'Norwegian Krone', 'NOK', 'kr', '1.0,00 kr', '7.7875', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:33'),
('ed7894ca-b528-4929-8991-fdb4a9714dda', 'Cuban Peso', 'CUP', '$MN', '$MN1,0.00', '1', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:33'),
('f3d19903-d9fb-47f5-a61d-c442a9978b9a', 'Franc CFA (XOF)', 'XOF', 'F.CFA', '1,0.00 F.CFA', '549', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:33'),
('f5161c74-9bcd-41ec-839c-5a2bcdd18d56', 'Rwanda Franc', 'RWF', 'RWF', 'RWF 1 0,00', '826.84', 0, 0, '2017-08-03 12:56:25', '2017-09-06 09:35:33'),
('f7d78d38-b870-4c9f-943e-282a4f4eaaa3', 'Turkmenistani New Manat', 'TMT', 'm', '1 0,m', '3.4', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:33'),
('f9ca0ec8-b6d4-4ad7-b104-1284d6e4045b', 'Nicaragua, Cordoba Oro', 'NIO', 'C$', 'C$ 1,0.00', '29.88', 0, 0, '2017-08-03 12:56:24', '2017-09-06 09:35:33'),
('fa20d89c-7aa7-445c-a43f-9d2eeddb0abf', 'Guyana Dollar', 'GYD', '$', '$1,0.00', '202.71', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('fa76a3c1-1a14-4a61-a03a-1b5155ce38cf', 'South Korea, Won', 'KRW', '₩', '₩1,0.', '1131', 0, 0, '2017-08-03 12:56:23', '2017-09-06 09:35:33'),
('fce99486-8ea1-4b50-a762-9053bf201f9c', 'Costa Rican Colon', 'CRC', '₡', '₡1,0.00', '573.35', 0, 0, '2017-08-03 12:56:22', '2017-09-06 09:35:33'),
('fdb37e21-c35d-4bef-9574-80bea6f7751b', 'Viet Nam, Dong', 'VND', '₫', '1,0.0 ₫', '22726', 0, 0, '2017-08-03 12:56:26', '2017-09-06 09:35:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_settings`
--

CREATE TABLE `email_settings` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailgun_domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mailgun_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mandrill_secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `estimates`
--

CREATE TABLE `estimates` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `estimate_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estimate_date` date NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `increment_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `estimate_items`
--

CREATE TABLE `estimate_items` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `estimate_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `price` double(15,2) NOT NULL,
  `tax_id` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `estimate_settings`
--

CREATE TABLE `estimate_settings` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `start_number` int(11) NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `expenses`
--

CREATE TABLE `expenses` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expense_date` date NOT NULL,
  `amount` double(15,2) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `expense_categories`
--

CREATE TABLE `expense_categories` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoices`
--

CREATE TABLE `invoices` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `discount_mode` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recurring` tinyint(1) NOT NULL,
  `recurring_cycle` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `increment_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_items`
--

CREATE TABLE `invoice_items` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_description` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `price` double(15,2) NOT NULL,
  `tax_id` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `item_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `start_number` int(11) NOT NULL,
  `terms` text COLLATE utf8_unicode_ci NOT NULL,
  `due_days` int(11) NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `show_status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `locales`
--

CREATE TABLE `locales` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `locale_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `locales`
--

INSERT INTO `locales` (`uuid`, `locale_name`, `short_name`, `flag`, `default`, `status`, `created_at`, `updated_at`) VALUES
('c38a0754-7d6a-407b-bc5b-4f10dad0e9b9', 'english', 'en', '1zkkvvsktknz2epc116hexm8cmflqsrcxg6rtecyohml1isx7q.png', '1', 1, '2015-09-28 22:19:27', '2017-09-06 00:28:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `ltm_translations`
--

INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(2, 0, 'en', 'application', 'edit_client', 'Edit Client', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(3, 0, 'en', 'application', 'clients', 'Clients', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(4, 0, 'en', 'application', 'new_client', 'New Client', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(5, 0, 'en', 'application', 'reference', 'Reference', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(6, 0, 'en', 'application', 'name', 'Name', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(7, 0, 'en', 'application', 'email', 'Email', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(8, 0, 'en', 'application', 'phone', 'Phone', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(9, 0, 'en', 'application', 'country', 'Country', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(11, 0, 'en', 'application', 'client_details', 'Client Details', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(12, 0, 'en', 'application', 'client_number', 'Client Number', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(13, 0, 'en', 'application', 'mobile', 'Mobile', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(14, 0, 'en', 'application', 'address_1', 'Address 1', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(15, 0, 'en', 'application', 'address_2', 'Address 2', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(16, 0, 'en', 'application', 'city', 'City', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(17, 0, 'en', 'application', 'state_province', 'State / Province', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(18, 0, 'en', 'application', 'postal_zip', 'Postal / Zip Code', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(19, 0, 'en', 'application', 'website', 'Website', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(20, 0, 'en', 'application', 'notes', 'Notes', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(21, 0, 'en', 'application', 'invoices', 'Invoices', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(22, 0, 'en', 'application', 'invoice_number', 'Invoice Number', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(23, 0, 'en', 'application', 'status', 'Status', '2015-08-23 02:06:03', '2017-11-06 02:46:25'),
(24, 0, 'en', 'application', 'date', 'Date', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(25, 0, 'en', 'application', 'due_date', 'Due Date', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(26, 0, 'en', 'application', 'amount', 'Amount', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(27, 0, 'en', 'application', 'view', 'View', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(28, 0, 'en', 'application', 'estimates', 'Estimates', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(29, 0, 'en', 'application', 'estimate_number', 'Estimate Number', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(30, 0, 'en', 'application', 'login', 'Login', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(31, 0, 'en', 'application', 'back', 'Back', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(32, 0, 'en', 'application', 'estimate', 'Estimate', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(33, 0, 'en', 'application', 'client', 'Client', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(34, 0, 'en', 'application', 'currency', 'Currency', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(35, 0, 'en', 'application', 'estimate_date', 'Estimate Date', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(36, 0, 'en', 'application', 'product', 'Product', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(37, 0, 'en', 'application', 'description', 'Description', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(38, 0, 'en', 'application', 'quantity', 'Quantity', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(39, 0, 'en', 'application', 'price', 'Price', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(40, 0, 'en', 'application', 'tax', 'Tax', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(41, 0, 'en', 'application', 'add_row', 'Add Row', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(42, 0, 'en', 'application', 'add_from_products', 'Add From Products', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(43, 0, 'en', 'application', 'subtotal', 'Sub Total', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(44, 0, 'en', 'application', 'total', 'Total', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(45, 0, 'en', 'application', 'terms', 'Terms', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(46, 0, 'en', 'application', 'save', 'Save', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(47, 0, 'en', 'application', 'preview', 'Preview', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(48, 0, 'en', 'application', 'new_estimate', 'New Estimate', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(49, 0, 'en', 'application', 'download', 'Download', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(50, 0, 'en', 'application', 'edit', 'Edit', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(51, 0, 'en', 'application', 'our_information', 'Our Information', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(52, 0, 'en', 'application', 'estimate_to', 'Estimate To', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(53, 0, 'en', 'application', 'send', 'Send', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(54, 0, 'en', 'application', 'billing_to', 'Billing To', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(55, 0, 'en', 'application', 'add_expense', 'Add Expense', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(56, 0, 'en', 'application', 'edit_expense', 'Edit Expense', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(57, 0, 'en', 'application', 'expenses', 'Expenses', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(58, 0, 'en', 'application', 'category', 'Category', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(59, 0, 'en', 'application', 'expense_name', 'Expense Name', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(60, 0, 'en', 'application', 'vendor', 'Vendor', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(61, 0, 'en', 'application', 'expense_date', 'Expense Date', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(62, 0, 'en', 'application', 'dashboard', 'Dashboard', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(63, 0, 'en', 'application', 'products', 'Products', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(64, 0, 'en', 'application', 'invoices_partially_paid', 'Partially Paid', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(65, 0, 'en', 'application', 'unpaid_invoices', 'Unpaid Invoices', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(66, 0, 'en', 'application', 'invoices_overdue', 'Overdue Invoices', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(67, 0, 'en', 'application', 'paid_invoices', 'Paid  Invoices', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(68, 0, 'en', 'application', 'invoices_generated', 'Invoices Generated', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(69, 0, 'en', 'application', 'days', 'Days', '2015-08-23 02:06:04', '2017-11-06 02:46:25'),
(70, 0, 'en', 'application', 'recent_invoices', 'Recent Invoices', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(71, 0, 'en', 'application', 'invoice_status', 'Invoice Status', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(72, 0, 'en', 'application', 'recent_estimates', 'Recent Estimates', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(73, 0, 'en', 'application', 'invoice', 'Invoice', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(74, 0, 'en', 'application', 'discount', 'Discount', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(75, 0, 'en', 'application', 'save_invoice', 'Save Invoice', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(76, 0, 'en', 'application', 'paid', 'Paid', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(77, 0, 'en', 'application', 'amount_due', 'Amount Due', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(78, 0, 'en', 'application', 'new_invoice', 'New Invoice', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(79, 0, 'en', 'application', 'vat_number', 'VAT Number', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(80, 0, 'en', 'application', 'online', 'Online', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(82, 0, 'en', 'application', 'edit_payment', 'Edit Payment', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(83, 0, 'en', 'application', 'payments', 'Payments', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(84, 0, 'en', 'application', 'record_payment', 'Record Payment', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(85, 0, 'en', 'application', 'received_on', 'Received On', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(86, 0, 'en', 'application', 'payment_method', 'Payment Method', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(87, 0, 'en', 'application', 'add_product', 'Add Product', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(88, 0, 'en', 'application', 'edit_product', 'Add Product', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(89, 0, 'en', 'application', 'new_product', 'New Product', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(90, 0, 'en', 'application', 'code', 'Code', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(91, 0, 'en', 'application', 'unit_price', 'Unit Price', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(92, 0, 'en', 'application', 'product_description', 'Product Description', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(93, 0, 'en', 'application', 'select_product', 'Select Product', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(94, 0, 'en', 'application', 'reports', 'Reports', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(95, 0, 'en', 'application', 'payments_received', 'Payments Received', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(96, 0, 'en', 'application', 'estimates_generated', 'Estimate has been generated', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(97, 0, 'en', 'application', 'expenses_incurred', 'Expenses Incurred', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(98, 0, 'en', 'application', 'browse', 'Browse', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(99, 0, 'en', 'application', 'add_user', 'Add User', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(100, 0, 'en', 'application', 'edit_user', 'Edit User', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(101, 0, 'en', 'application', 'system_users', 'System Users', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(102, 0, 'en', 'application', 'new_user', 'New User', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(103, 0, 'en', 'application', 'photo', 'Photo', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(104, 0, 'en', 'application', 'username', 'Username', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(105, 0, 'en', 'application', 'password', 'Password', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(106, 0, 'en', 'application', 'confirm_password', 'Confirm Password', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(107, 0, 'en', 'application', 'edit_profile', 'Edit Profile', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(108, 0, 'en', 'application', 'email_address', 'Email Address', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(109, 0, 'en', 'application', 'password_leave_blank_notification', ' (Leave blank if not changing)', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(110, 0, 'en', 'application', 'update_profile', 'Update Profile', '2015-08-23 02:06:05', '2017-11-06 02:46:25'),
(111, 1, 'en', 'pagination', 'previous', '&laquo; Previous', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(112, 1, 'en', 'pagination', 'next', 'Next &raquo;', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(113, 1, 'en', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(114, 1, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(115, 1, 'en', 'passwords', 'token', 'This password reset token is invalid.', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(116, 1, 'en', 'passwords', 'sent', 'We have e-mailed your password reset link!', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(117, 1, 'en', 'passwords', 'reset', 'Your password has been reset!', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(118, 1, 'en', 'validation', 'accepted', 'The :attribute must be accepted.', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(119, 1, 'en', 'validation', 'active_url', 'The :attribute is not a valid URL.', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(120, 1, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2015-08-23 02:06:19', '2015-11-02 08:25:13'),
(121, 1, 'en', 'validation', 'alpha', 'The :attribute may only contain letters.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(122, 1, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(123, 1, 'en', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(124, 1, 'en', 'validation', 'array', 'The :attribute must be an array.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(125, 1, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(126, 1, 'en', 'validation', 'between.numeric', 'The :attribute must be between :min and :max.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(127, 1, 'en', 'validation', 'between.file', 'The :attribute must be between :min and :max kilobytes.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(128, 1, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(129, 1, 'en', 'validation', 'between.array', 'The :attribute must have between :min and :max items.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(130, 1, 'en', 'validation', 'boolean', 'The :attribute field must be true or false.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(131, 1, 'en', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(132, 1, 'en', 'validation', 'date', 'The :attribute is not a valid date.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(133, 1, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(134, 1, 'en', 'validation', 'different', 'The :attribute and :other must be different.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(135, 1, 'en', 'validation', 'digits', 'The :attribute must be :digits digits.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(136, 1, 'en', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(137, 1, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(138, 1, 'en', 'validation', 'filled', 'The :attribute field is required.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(139, 1, 'en', 'validation', 'exists', 'The selected :attribute is invalid.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(140, 1, 'en', 'validation', 'image', 'The :attribute must be an image.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(141, 1, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(142, 1, 'en', 'validation', 'integer', 'The :attribute must be an integer.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(143, 1, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2015-08-23 02:06:19', '2015-11-02 08:25:14'),
(144, 1, 'en', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(145, 1, 'en', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(146, 1, 'en', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(147, 1, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(148, 1, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(149, 1, 'en', 'validation', 'min.numeric', 'The :attribute must be at least :min.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(150, 1, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(151, 1, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(152, 1, 'en', 'validation', 'min.array', 'The :attribute must have at least :min items.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(153, 1, 'en', 'validation', 'not_in', 'The selected :attribute is invalid.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(154, 1, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(155, 1, 'en', 'validation', 'regex', 'The :attribute format is invalid.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(156, 1, 'en', 'validation', 'required', 'The :attribute field is required.', '2015-08-23 02:06:20', '2015-11-02 08:25:14'),
(157, 1, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(158, 1, 'en', 'validation', 'required_with', 'The :attribute field is required when :values is present.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(159, 1, 'en', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(160, 1, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(161, 1, 'en', 'validation', 'required_without_all', 'The :attribute field is required when none of :values are present.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(162, 1, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(163, 1, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(164, 1, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(165, 1, 'en', 'validation', 'size.string', 'The :attribute must be :size characters.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(166, 1, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(167, 1, 'en', 'validation', 'unique', 'The :attribute has already been taken.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(168, 1, 'en', 'validation', 'url', 'The :attribute format is invalid.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(169, 1, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(170, 1, 'en', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(171, 1, 'en', 'validation', 'string', 'The :attribute must be a string.', '2015-08-23 02:06:20', '2015-11-02 08:25:15'),
(241, 0, 'en', 'application', 'add_client', 'Add Client', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(242, 0, 'en', 'application', 'action', 'Action', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(243, 0, 'en', 'application', 'yearly_overview', 'Yearly Overview', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(244, 0, 'en', 'application', 'payment_overview', 'Payment Overview', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(245, 0, 'en', 'application', 'income', 'Income', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(246, 0, 'en', 'application', 'expenditure', 'Expenditure', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(247, 0, 'en', 'application', 'amount_received', 'Amount Received', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(248, 0, 'en', 'application', 'outstanding_amount', 'Outstanding Amount', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(249, 0, 'en', 'application', 'add_payment', 'Add Payment', '2015-10-01 01:03:41', '2017-11-06 02:46:25'),
(250, 0, 'en', 'application', 'generate_statement', 'Generate Statement', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(251, 0, 'en', 'application', 'client_pending_balance', 'Client Pending Balance', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(252, 0, 'en', 'application', 'client_statistics', 'Client Statistics', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(253, 0, 'en', 'application', 'total_invoiced_amount', 'Total Invoiced Amount', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(254, 0, 'en', 'application', 'total_amount_paid', 'Total Amount Paid', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(255, 0, 'en', 'application', 'activity', 'Activity', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(256, 0, 'en', 'application', 'balance', 'Balance', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(257, 0, 'en', 'application', 'from', 'From', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(258, 0, 'en', 'application', 'to', 'To', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(259, 0, 'en', 'application', 'generate_report', 'Generate Report', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(260, 0, 'en', 'application', 'general_summary', 'General Summary', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(261, 0, 'en', 'application', 'payments_summary', 'Payments Summary', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(262, 0, 'en', 'application', 'client_statement', 'Client Statement', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(263, 0, 'en', 'application', 'invoice_report', 'Invoice Report', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(264, 0, 'en', 'application', 'expense_report', 'Expense Report', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(265, 0, 'en', 'application', 'system_settings', 'System Settings', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(266, 0, 'en', 'application', 'contact_person', 'Contact Person', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(267, 0, 'en', 'application', 'zip_postal_code', 'Zip/Postal Code', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(268, 0, 'en', 'application', 'logo', 'Logo', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(269, 0, 'en', 'application', 'width', 'Width', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(270, 0, 'en', 'application', 'date_format', 'Date Format', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(271, 0, 'en', 'application', 'save_settings', 'Save Settings', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(272, 0, 'en', 'application', 'invoice_settings', 'Invoice Settings', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(273, 0, 'en', 'application', 'number_invoice_starting', 'Number Invoice Starting', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(274, 0, 'en', 'application', 'invoice_term', 'Invoice Term', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(275, 0, 'en', 'application', 'company', 'Company', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(276, 0, 'en', 'application', 'templates', 'Templates', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(277, 0, 'en', 'application', 'numbering', 'Numbering', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(278, 0, 'en', 'application', 'payment_methods', 'Payment Methods', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(279, 0, 'en', 'application', 'language_manager', 'Language Manager', '2015-10-01 01:03:42', '2017-11-06 02:46:25'),
(280, 0, 'en', 'application', 'email_templates', 'Email Templates', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(281, 0, 'en', 'application', 'add_locale', 'Add Locale', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(282, 0, 'en', 'application', 'translations', 'Translations', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(283, 0, 'en', 'application', 'create_locale', 'Create Locale', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(284, 0, 'en', 'application', 'flag', 'Flag', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(285, 0, 'en', 'application', 'locale_name', 'Locale Name', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(286, 0, 'en', 'application', 'short_name', 'Short Name', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(287, 0, 'en', 'application', 'enabled', 'Enabled', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(288, 0, 'en', 'application', 'disabled', 'Disabled', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(289, 0, 'en', 'application', 'view_translations', 'View Translations', '2015-10-01 01:03:43', '2017-11-06 02:46:25'),
(470, 0, 'en', 'application', 'record_created', 'Record has been created.', '2015-11-05 02:21:24', '2017-11-06 02:46:25'),
(471, 0, 'en', 'application', 'record_creation_failed', 'Sorry record not created, please try again.', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(472, 0, 'en', 'application', 'record_updated', 'Record has been updated', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(473, 0, 'en', 'application', 'update_failed', 'Sorry record update failed. Please try again', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(474, 0, 'en', 'application', 'record_deleted', 'Record has been deleted', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(475, 0, 'en', 'application', 'create_failed', 'Sorry record not created, try again', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(476, 0, 'en', 'application', 'record_failed', 'Record Failed', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(477, 0, 'en', 'application', 'delete_failed', 'Sorry record not deleted. Try again.', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(478, 0, 'en', 'application', 'record_update_failed', 'Sorry record was not updated, please try again\n', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(479, 0, 'en', 'application', 'record_deletion_failed', 'Sorry record has not been deleted, please try again.', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(480, 0, 'en', 'application', 'email_sent', 'Email has been sent', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(481, 0, 'en', 'application', 'email_settings_error', 'Please set the mail server details first in setting > Email', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(482, 0, 'en', 'application', 'settings_updated', 'Settings have been updated', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(483, 0, 'en', 'application', 'client_no', 'Client Number', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(484, 0, 'en', 'application', 'state', 'State', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(485, 0, 'en', 'application', 'postal_code', 'Postal Code', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(486, 0, 'en', 'application', 'deleting_record', 'Deleting a Record', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(487, 0, 'en', 'application', 'delete_confirmation_msg', 'Are you sure you want to delete this record. This action cannot be undone.', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(488, 0, 'en', 'application', 'change', 'Change', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(489, 0, 'en', 'application', 'edit_currency', 'Edit Currency', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(490, 0, 'en', 'application', 'currency_name', 'Currency Name', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(491, 0, 'en', 'application', 'symbol', 'Symbol', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(492, 0, 'en', 'application', 'default', 'Default', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(493, 0, 'en', 'application', 'yes', 'Yes', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(494, 0, 'en', 'application', 'no', 'No', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(495, 0, 'en', 'application', 'protocol', 'Protocol', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(496, 0, 'en', 'application', 'smtp_host', 'SMTP Host', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(497, 0, 'en', 'application', 'smtp_username', 'SMTP Username', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(498, 0, 'en', 'application', 'smtp_password', 'SMTP Password', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(499, 0, 'en', 'application', 'smtp_port', 'SMTP Port', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(500, 0, 'en', 'application', 'estimate_settings', 'Estimate Settings', '2015-11-05 02:21:25', '2017-11-06 02:46:25'),
(501, 0, 'en', 'application', 'number_estimate_starting', 'Number Estimate Starting', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(502, 0, 'en', 'application', 'estimate_terms', 'Estimate Terms', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(503, 0, 'en', 'application', 'invoice_terms', 'Invoice Terms', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(504, 0, 'en', 'application', 'due_after', 'Due Date', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(505, 0, 'en', 'application', 'number_prefix', 'Number Prefix', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(506, 0, 'en', 'application', 'client_number_prefix', 'Client Number Prefix', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(507, 0, 'en', 'application', 'invoice_number_prefix', 'Invoice Number Prefix', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(508, 0, 'en', 'application', 'estimate_number_prefix', 'Estimate Number Prefix', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(509, 0, 'en', 'application', 'edit_payment_method', 'Edit Payment Method', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(510, 0, 'en', 'application', 'edit_tax', 'Edit Tax', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(511, 0, 'en', 'application', 'tax_name', 'Tax Name', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(512, 0, 'en', 'application', 'tax_value', 'Tax Value', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(513, 0, 'en', 'application', 'tax_settings', 'Tax Settings', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(514, 0, 'en', 'application', 'value', 'Value', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(515, 0, 'en', 'application', 'template', 'Template', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(516, 0, 'en', 'application', 'subject', 'Subject', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(517, 0, 'en', 'application', 'email_body', 'Email Body', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(518, 0, 'en', 'application', 'invoice_tags', 'Invoice Tags', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(519, 0, 'en', 'application', 'client_tags', 'Client Tags', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(520, 0, 'en', 'application', 'company_tags', 'Company Tags', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(521, 0, 'en', 'application', 'users_tags', 'Users Tags', '2015-11-05 02:21:26', '2017-11-06 02:46:25'),
(522, 0, 'en', 'application', 'roles', 'Roles', '2016-09-07 04:56:06', '2017-11-06 02:46:25'),
(523, 0, 'en', 'application', 'permissions', 'Permissions', '2016-09-07 04:56:06', '2017-11-06 02:46:25'),
(524, 0, 'en', 'application', 'password_reminder', 'Password Reminder', '2016-09-07 04:58:59', '2017-11-06 02:46:25'),
(525, 0, 'en', 'application', 'unpaid', 'Unpaid', '2016-09-07 05:29:18', '2017-11-06 02:46:25'),
(526, 0, 'en', 'application', 'close', 'Close', '2016-09-08 02:19:46', '2017-11-06 02:46:25'),
(527, 0, 'en', 'application', 'view_estimate', 'View Estimate', '2016-09-08 02:26:35', '2017-11-06 02:46:25'),
(528, 0, 'en', 'application', 'download_estimate', 'Download Estimate', '2016-09-08 02:26:35', '2017-11-06 02:46:25'),
(529, 0, 'en', 'application', 'edit_estimate', 'Edit Estimate', '2016-09-08 02:26:35', '2017-11-06 02:46:25'),
(530, 0, 'en', 'application', 'delete', 'Delete', '2016-09-08 02:26:35', '2017-11-06 02:46:25'),
(531, 0, 'en', 'application', 'download_invoice', 'Download Invoice', '2016-09-08 02:26:35', '2017-11-06 02:46:25'),
(532, 0, 'en', 'application', 'edit_invoice', 'Edit Invoice', '2016-09-08 02:26:35', '2017-11-06 02:46:25'),
(533, 0, 'en', 'application', 'favicon', 'Favicon', '2016-09-12 04:14:51', '2017-11-06 02:46:25'),
(534, 0, 'en', 'application', 'edit_permission', 'Edit Permission', '2016-09-12 04:32:02', '2017-11-06 02:46:25'),
(535, 0, 'en', 'application', 'edit_role', 'Edit Role', '2016-09-12 04:41:39', '2017-11-06 02:46:25'),
(536, 0, 'en', 'application', 'assign_permissions', 'Assign Permissions', '2016-09-12 04:41:39', '2017-11-06 02:46:25'),
(537, 0, 'en', 'application', 'assign', 'Assign', '2016-09-12 04:41:39', '2017-11-06 02:46:25'),
(538, 0, 'en', 'application', 'role', 'Role', '2016-09-12 04:41:39', '2017-11-06 02:46:25'),
(539, 0, 'en', 'application', 'email_or_username', 'Email or Username', '2016-09-12 05:58:54', '2017-11-06 02:46:25'),
(540, 0, 'en', 'application', 'account_menu', 'Account Menu', '2016-10-05 04:01:20', '2017-11-06 02:46:25'),
(541, 0, 'en', 'application', 'main_menu', 'Main Menu', '2016-10-05 04:01:28', '2017-11-06 02:46:25'),
(542, 0, 'en', 'application', 'users', 'Users', '2016-10-05 04:58:50', '2017-11-06 02:46:25'),
(543, 0, 'en', 'application', 'settings', 'Settings', '2016-10-05 04:58:50', '2017-11-06 02:46:25'),
(544, 0, 'en', 'application', 'profile', 'Profile', '2016-10-05 04:58:50', '2017-11-06 02:46:25'),
(545, 0, 'en', 'application', 'logout', 'Logout', '2016-10-05 04:58:50', '2017-11-06 02:46:25'),
(546, 0, 'en', 'application', 'go_to_login', 'Go to login', '2016-10-05 04:58:50', '2017-11-06 02:46:25'),
(547, 0, 'en', 'application', 'reset_password', 'Reset Password', '2016-10-05 04:58:50', '2017-11-06 02:46:25'),
(548, 0, 'en', 'application', 'invoice_generated', 'Invoice generated', '2016-10-05 05:00:59', '2017-11-06 02:46:25'),
(549, 0, 'en', 'application', 'estimate_generated', 'Estimate Generated', '2016-10-05 05:01:00', '2017-11-06 02:46:25'),
(550, 0, 'en', 'application', 'partially_paid', 'Partially Paid', '2016-10-10 01:05:52', '2017-11-06 02:46:25'),
(551, 0, 'en', 'application', 'payment_successful', 'Payment Successful', '2017-08-31 01:50:34', '2017-11-06 02:46:25'),
(552, 0, 'en', 'application', 'payment_failed', 'Payment Failed', '2017-08-31 01:50:34', '2017-11-06 02:46:25'),
(553, 0, 'en', 'application', 'payment_cancelled', 'Payment Cancelled', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(554, 0, 'en', 'application', 'overdue', 'Overdue', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(555, 0, 'en', 'application', 'dont_have_permission', 'Don\'t have permission', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(556, 0, 'en', 'application', 'processing', 'Processing', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(557, 0, 'en', 'application', 'gst_number', 'GST Number', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(558, 0, 'en', 'application', 'pay_invoice', 'Pay Invoice', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(559, 0, 'en', 'application', 'complete_payment', 'Complete Payment', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(560, 0, 'en', 'application', 'add_category', 'Add Category', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(561, 0, 'en', 'application', 'edit_category', 'Add Category', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(562, 0, 'en', 'application', 'categories', 'Categories', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(563, 0, 'en', 'application', 'new_category', 'New Category', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(564, 0, 'en', 'application', 'new_expense', 'New Expense', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(565, 0, 'en', 'application', 'amount_thousand_separator', 'Amount thousand separator', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(566, 0, 'en', 'application', 'amount_decimal_separator', 'Amount decimal separator', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(567, 0, 'en', 'application', 'amount_decimals', 'Amount decimals', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(568, 0, 'en', 'application', 'exchange_rate', 'Exchange Rate', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(569, 0, 'en', 'application', 'active', 'Active', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(570, 0, 'en', 'application', 'default_currency', 'Default Currency', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(571, 0, 'en', 'application', 'update_exchange_rates', 'Update Exchange Rates', '2017-08-31 01:50:35', '2017-11-06 02:46:25'),
(572, 0, 'en', 'application', 'mailgun_domain', 'Mailgun Domain', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(573, 0, 'en', 'application', 'mailgun_secret', 'Mailgun Secret', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(574, 0, 'en', 'application', 'mandrill_secret', 'Mandrill Secret', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(575, 0, 'en', 'application', 'from_name', 'From Name', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(576, 0, 'en', 'application', 'from_email', 'From Email', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(577, 0, 'en', 'application', 'show_status', 'Show Status', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(578, 0, 'en', 'application', 'paypal_status', 'Paypal Status', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(579, 0, 'en', 'application', 'mode', 'Mode', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(580, 0, 'en', 'application', 'account', 'Account', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(581, 0, 'en', 'application', 'client_id', 'Client Id', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(582, 0, 'en', 'application', 'secret_key', 'Secret Key', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(583, 0, 'en', 'application', 'ipn_url', 'IPN Url', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(584, 0, 'en', 'application', 'stripe_status', 'Stripe Status', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(585, 0, 'en', 'application', 'stripe_key', 'Stripe Key', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(586, 0, 'en', 'application', 'stripe_secret', 'Stripe Secret', '2017-08-31 01:50:36', '2017-11-06 02:46:25'),
(587, 1, 'en', 'auth', 'failed', NULL, '2017-08-31 01:50:36', '2017-08-31 01:50:36'),
(588, 1, 'en', 'auth', 'throttle', NULL, '2017-08-31 01:50:36', '2017-08-31 01:50:36'),
(589, 0, 'en', 'application', 'make_invoice', 'Make Invoice', '2017-11-06 01:34:03', '2017-11-06 02:46:25'),
(590, 0, 'en', 'application', 'convert_estimate_to_invoice_msg', 'This action will create a new invoice from this estimate, are you sure?', '2017-11-06 01:34:03', '2017-11-06 02:46:25'),
(591, 0, 'en', 'application', 'recurring', 'Recurring', '2017-11-06 01:34:03', '2017-11-06 02:46:25'),
(592, 0, 'en', 'application', 'recurring_cycle', 'Recurring Cycle', '2017-11-06 01:34:03', '2017-11-06 02:46:25'),
(593, 0, 'en', 'application', 'monthly', 'Monthly', '2017-11-06 02:45:27', '2017-11-06 02:46:25'),
(594, 0, 'en', 'application', 'quarterly', 'Quarterly', '2017-11-06 02:45:27', '2017-11-06 02:46:25'),
(595, 0, 'en', 'application', 'semi_annually', 'Semi Annually', '2017-11-06 02:45:27', '2017-11-06 02:46:25'),
(596, 0, 'en', 'application', 'annually', 'Annually', '2017-11-06 02:45:27', '2017-11-06 02:46:25'),
(597, 0, 'en', 'application', 'no_gateway_available', 'Sorry, No payment gateway has been setup at the moment.', '2017-11-06 02:45:27', '2017-11-06 02:46:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_04_10_174623_create_clients_table', 1),
(2, '2018_04_10_174623_create_currencies_table', 1),
(3, '2018_04_10_174623_create_email_settings_table', 1),
(4, '2018_04_10_174623_create_estimate_items_table', 1),
(5, '2018_04_10_174623_create_estimate_settings_table', 1),
(6, '2018_04_10_174623_create_estimates_table', 1),
(7, '2018_04_10_174623_create_expense_categories_table', 1),
(8, '2018_04_10_174623_create_expenses_table', 1),
(9, '2018_04_10_174623_create_invoice_items_table', 1),
(10, '2018_04_10_174623_create_invoice_settings_table', 1),
(11, '2018_04_10_174623_create_invoices_table', 1),
(12, '2018_04_10_174623_create_locales_table', 1),
(13, '2018_04_10_174623_create_ltm_translations_table', 1),
(14, '2018_04_10_174623_create_number_settings_table', 1),
(15, '2018_04_10_174623_create_password_resets_table', 1),
(16, '2018_04_10_174623_create_payment_methods_table', 1),
(17, '2018_04_10_174623_create_payments_table', 1),
(18, '2018_04_10_174623_create_permission_role_table', 1),
(19, '2018_04_10_174623_create_permissions_table', 1),
(20, '2018_04_10_174623_create_product_categories_table', 1),
(21, '2018_04_10_174623_create_products_table', 1),
(22, '2018_04_10_174623_create_role_user_table', 1),
(23, '2018_04_10_174623_create_roles_table', 1),
(24, '2018_04_10_174623_create_settings_table', 1),
(25, '2018_04_10_174623_create_subscriptions_table', 1),
(26, '2018_04_10_174623_create_tax_settings_table', 1),
(27, '2018_04_10_174623_create_templates_table', 1),
(28, '2018_04_10_174623_create_users_table', 1),
(29, '2018_04_10_174627_add_foreign_keys_to_estimate_items_table', 1),
(30, '2018_04_10_174627_add_foreign_keys_to_estimates_table', 1),
(31, '2018_04_10_174627_add_foreign_keys_to_invoice_items_table', 1),
(32, '2018_04_10_174627_add_foreign_keys_to_invoices_table', 1),
(33, '2018_04_10_174627_add_foreign_keys_to_payments_table', 1),
(34, '2018_04_10_174627_add_foreign_keys_to_permission_role_table', 1),
(35, '2018_04_10_174627_add_foreign_keys_to_role_user_table', 1),
(36, '2018_04_10_174627_add_foreign_keys_to_subscriptions_table', 1),
(37, '2018_04_10_174627_add_foreign_keys_to_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `number_settings`
--

CREATE TABLE `number_settings` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estimate_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `amount` double(15,2) NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_methods`
--

CREATE TABLE `payment_methods` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `selected` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `payment_methods`
--

INSERT INTO `payment_methods` (`uuid`, `name`, `selected`, `created_at`, `updated_at`) VALUES
('0c8acc22-2b39-47f8-8042-2c2f0539b5bd', 'Offline', 1, '2020-02-11 03:46:28', '2020-02-11 03:46:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`uuid`, `name`, `description`, `created_at`, `updated_at`) VALUES
('10eceb0f-1139-4e4d-ba0c-f7a5dbd428d1', 'add_estimate', 'Allow user to add estimates', '2016-08-08 07:18:48', '2016-09-12 04:26:07'),
('17164617-61e4-4e4c-beac-bc7cfb7cf1cb', 'add_product', 'Allow user to add products', '2016-08-08 07:22:20', '2016-09-12 04:21:59'),
('1cd20ed3-3606-49d9-8dad-848a94aeeb72', 'delete_user', 'Allow user to delete user', '2016-08-08 07:53:59', '2016-08-23 06:24:03'),
('2037231a-ef3a-40dc-921c-3aea2d4172c6', 'add_expense', 'Allow user to add expenses', '2016-08-08 07:19:52', '2016-09-12 04:23:48'),
('3e5a71a6-b4ea-489b-b330-bed0da6a9322', 'send_estimate', 'Allow user send estimates', '2016-10-05 04:53:43', '2016-10-05 04:53:43'),
('42693e14-ba6e-465f-9de8-3ff74da853a8', 'delete_invoice', 'Allow users to delete invoices', '2016-08-08 06:34:01', '2016-09-12 04:29:56'),
('4d8e4c00-f889-4abf-9748-9bbc4d8f9caa', 'delete_estimate', 'Allow user to delete estimates\n', '2016-08-08 07:19:12', '2016-09-12 04:25:07'),
('547492d8-70ae-4c17-a1df-866e9470f6c1', 'edit_estimate', 'Allow user to edit estimates', '2016-08-08 07:19:03', '2016-09-12 04:25:43'),
('5abcf69a-4efd-46d0-bcef-0f040e407bc4', 'delete_client', 'Allow user access to delete a client', '2016-08-08 08:43:37', '2016-08-09 03:32:58'),
('63b1e5b9-974c-4870-8215-011fc320bef1', 'delete_expense', 'Allow user to delete expense', '2016-08-08 07:20:13', '2016-09-12 04:23:12'),
('646b3394-92c9-4972-8430-fe4c6dabcc6a', 'edit_user', 'Allow user to edit system users', '2016-08-08 07:53:52', '2016-09-12 04:20:23'),
('6c23de41-01df-4e42-a787-6fc364c7ba57', 'add_user', 'Allow user to add other users', '2016-08-08 07:53:45', '2016-09-12 04:20:39'),
('77e7613a-be8b-4ef9-9fa3-915eea1fa4a2', 'edit_setting', 'Allow user to edit system settings', '2016-08-08 07:19:38', '2016-09-12 04:24:12'),
('7c2ac4c7-2b18-48e9-b33b-ff19734fa041', 'edit_expense', 'Allow user to edit payment', '2016-08-08 07:20:02', '2016-09-12 04:23:29'),
('829f7418-9b4f-4a65-842a-82fc2dd98168', 'send_invoice', 'Allow user to send invoices', '2016-08-08 06:36:41', '2016-09-12 04:29:40'),
('851edead-32bf-4c90-8f7c-911c619c507c', 'view_invoice', 'Allow user to view invoices', '2016-08-08 06:05:46', '2016-09-12 04:31:36'),
('939325ff-7469-4360-84e5-fe585e7f1dbb', 'add_payment', 'Allow user to add payment', '2016-08-08 07:21:49', '2016-09-12 04:22:55'),
('9d71bed3-e914-40b8-a579-c603095a239b', 'add_invoice', 'Allow users to add invoices', '2016-08-08 06:06:21', '2016-09-12 04:30:13'),
('c4ec0b11-3ecf-434c-8366-43423695fa81', 'delete_product', 'Allow user to delete products', '2016-08-08 07:22:33', '2016-09-12 04:21:38'),
('c9dc7c2b-7753-4dce-af40-4adf8aace186', 'add_client', 'Allow user to add clients', '2016-08-08 08:43:19', '2016-09-12 04:20:07'),
('cc21e591-f09e-4225-9725-06d2abb84860', 'edit_product', 'Allow user to edit products', '2016-08-08 07:22:41', '2016-09-12 04:21:22'),
('cc9fa2fa-1427-4cbb-9b9f-2cb9d5078add', 'view_estimate', 'Allow user to view estimates', '2016-08-08 07:19:20', '2016-09-12 04:24:28'),
('d118ad4b-17c4-4798-be1a-4d113860e299', 'edit_client', 'Allow user to edit clients', '2016-08-08 08:43:27', '2016-09-12 04:19:51'),
('db8066d7-f495-4886-9a99-1f28144232ed', 'edit_payment', 'Allow user to edit payments', '2016-08-08 07:22:11', '2016-09-12 04:22:18'),
('eb556f1c-6a2c-42d6-b020-f5e7b6434c7e', 'delete_payment', 'Allow user to delete payment', '2016-08-08 07:21:58', '2016-09-12 04:22:38'),
('f0286cc0-0178-49d9-a3c5-f2783171725d', 'edit_invoice', 'Allow user to edit invoices', '2016-08-08 06:06:09', '2016-09-12 04:30:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permission_role`
--

CREATE TABLE `permission_role` (
  `role_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `permission_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `price` double(15,2) NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_categories`
--

CREATE TABLE `product_categories` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`uuid`, `name`, `description`, `created_at`, `updated_at`) VALUES
('27f41653-a968-4885-8000-7aaf4efc385d', 'staff ', 'staff member with limited privileges', '2016-07-25 08:14:06', '2016-08-02 07:38:36'),
('5c7f11d2-7091-4d10-aaeb-a9b4e3b76a76', 'admin', 'This is the system admin who has all the administrative privileges. ', '2016-07-25 07:57:45', '2016-07-25 08:11:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_user`
--

CREATE TABLE `role_user` (
  `user_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `favicon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_format` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thousand_separator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `decimal_separator` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `decimals` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`uuid`, `name`, `email`, `phone`, `address1`, `address2`, `city`, `state`, `postal_code`, `country`, `contact`, `vat`, `website`, `logo`, `favicon`, `date_format`, `thousand_separator`, `decimal_separator`, `decimals`, `purchase_code`, `created_at`, `updated_at`) VALUES
('4f0bea5f-903e-40fe-b42f-490bb92557b9', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'ad28a58c-9809-4139-9218-6837bf46c549', '2020-02-11 03:45:00', '2020-02-11 03:45:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscriptions`
--

CREATE TABLE `subscriptions` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `billingcycle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nextduedate` date NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '0:cancelled,1:active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tax_settings`
--

CREATE TABLE `tax_settings` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `selected` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `templates`
--

CREATE TABLE `templates` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`uuid`, `name`, `email`, `phone`, `username`, `password`, `photo`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
('05f8691e-6b07-4d72-b4b7-c0fe451a84db', 'admin', 'admin@inv.com', NULL, 'admin', '$2y$10$no.kvYtESBHNf44P.NC.6ez6YaEyrudDv6FjLJX06sIUfA3WZMa2q', NULL, '5c7f11d2-7091-4d10-aaeb-a9b4e3b76a76', 'ssLmrJfRbpl2jsYDPqFaEE7owwQdYja5BOayCIovvV5H7ONDsX2fmbduYwjQ', '2020-02-11 03:43:13', '2020-02-11 03:47:09');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `increment_num` (`increment_num`);

--
-- Indeks untuk tabel `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `currencies_code_index` (`code`);

--
-- Indeks untuk tabel `email_settings`
--
ALTER TABLE `email_settings`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `estimates`
--
ALTER TABLE `estimates`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `estimates_estimate_no_unique` (`estimate_no`),
  ADD UNIQUE KEY `increment_num` (`increment_num`),
  ADD KEY `estimates_client_id_foreign` (`client_id`);

--
-- Indeks untuk tabel `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `estimate_items_estimate_id_foreign` (`estimate_id`),
  ADD KEY `estimate_items_tax_id_foreign` (`tax_id`);

--
-- Indeks untuk tabel `estimate_settings`
--
ALTER TABLE `estimate_settings`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `invoices_number_unique` (`number`),
  ADD UNIQUE KEY `increment_num` (`increment_num`),
  ADD KEY `invoices_client_id_foreign` (`client_id`);

--
-- Indeks untuk tabel `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_tax_id_foreign` (`tax_id`);

--
-- Indeks untuk tabel `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `number_settings`
--
ALTER TABLE `number_settings`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `payments_method_foreign` (`method`);

--
-- Indeks untuk tabel `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `products_name_unique` (`name`),
  ADD UNIQUE KEY `products_code_unique` (`code`);

--
-- Indeks untuk tabel `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `role_user_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `subscriptions_invoice_id_foreign` (`invoice_id`);

--
-- Indeks untuk tabel `tax_settings`
--
ALTER TABLE `tax_settings`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`uuid`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `clients`
--
ALTER TABLE `clients`
  MODIFY `increment_num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `estimates`
--
ALTER TABLE `estimates`
  MODIFY `increment_num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `invoices`
--
ALTER TABLE `invoices`
  MODIFY `increment_num` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=598;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `estimates`
--
ALTER TABLE `estimates`
  ADD CONSTRAINT `estimates_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `estimate_items`
--
ALTER TABLE `estimate_items`
  ADD CONSTRAINT `estimate_items_estimate_id_foreign` FOREIGN KEY (`estimate_id`) REFERENCES `estimates` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estimate_items_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `tax_settings` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_items_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `tax_settings` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_method_foreign` FOREIGN KEY (`method`) REFERENCES `payment_methods` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`uuid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
