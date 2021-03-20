-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2021 at 02:02 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pathology`
--

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) NOT NULL,
  `menu_name` varchar(50) DEFAULT NULL,
  `menu_order` int(2) DEFAULT NULL,
  `menu_url` varchar(200) DEFAULT NULL,
  `menu_icon` varchar(100) DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `is_active` smallint(10) NOT NULL DEFAULT 0 COMMENT '0=>Active, 1=> Inactive',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_name`, `menu_order`, `menu_url`, `menu_icon`, `controller`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 1, '/dashboard/dashboard', 'fa fa-dashboard', 'DashboardController', 0, '2015-06-27 01:05:36', '2015-11-29 23:37:47'),
(2, 'Admin Master', 2, '', 'fa fa-cubes', 'MasterController', 0, '2015-06-27 01:06:01', '2018-08-21 23:32:21'),
(4, 'User Management', 13, '', 'fa fa-user', 'UserController', 0, '2015-06-30 22:42:44', '2018-10-13 05:28:54'),
(5, 'Master Setup', 3, NULL, 'fa fa-cogs', 'SettingController', 0, '2019-06-18 01:36:17', '2019-06-18 01:36:17'),
(6, 'Staff Master', 4, NULL, 'fa fa-users', 'EmployeeController', 0, '2019-07-01 05:24:16', '2021-02-10 05:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) NOT NULL,
  `role_name` varchar(75) NOT NULL,
  `is_active` smallint(4) NOT NULL DEFAULT 0 COMMENT '0=>Active, 1=> Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Developer', 0, '2018-09-09 12:27:11', '0000-00-00 00:00:00'),
(2, 'Admin ', 0, '2018-09-11 18:12:15', '2018-09-11 00:42:15'),
(6, 'Laboratorian', 0, '2021-02-10 06:31:45', '2021-02-21 19:41:08'),
(7, 'Receptionists', 0, '2021-02-10 06:31:39', '2021-02-21 19:40:27'),
(27, 'Super Admin', 0, '2019-06-08 09:43:24', '2021-02-24 01:31:36');

-- --------------------------------------------------------

--
-- Table structure for table `role_menus`
--

CREATE TABLE `role_menus` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `sub_menu_id` bigint(20) DEFAULT NULL,
  `is_active` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_menus`
--

INSERT INTO `role_menus` (`id`, `role_id`, `menu_id`, `sub_menu_id`, `is_active`, `created_at`, `updated_at`) VALUES
(4186, 27, 1, NULL, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4187, 27, 2, 6, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4188, 27, 2, 9, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4191, 27, 5, 82, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4192, 27, 5, 83, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4195, 27, 6, 80, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4196, 27, 6, 87, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4197, 27, 6, 81, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4199, 27, 4, 14, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4200, 27, 4, 15, '0', '2021-02-11 00:06:17', '2021-02-11 00:06:17'),
(4201, 2, 1, NULL, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4202, 2, 2, 6, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4203, 2, 2, 9, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4206, 2, 5, 82, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4207, 2, 5, 83, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4210, 2, 6, 80, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4211, 2, 6, 87, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4212, 2, 6, 81, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4214, 2, 4, 14, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4215, 2, 4, 15, '0', '2021-02-11 00:06:33', '2021-02-11 00:06:33'),
(4235, 1, 1, NULL, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4236, 1, 2, 6, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4237, 1, 2, 7, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4238, 1, 2, 8, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4239, 1, 2, 9, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4240, 1, 5, 95, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4241, 1, 5, 82, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4242, 1, 5, 83, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4243, 1, 6, 80, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4244, 1, 6, 87, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4245, 1, 6, 81, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4246, 1, 4, 14, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4247, 1, 4, 15, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02'),
(4248, 1, 4, 69, '0', '2021-02-24 00:41:02', '2021-02-24 00:41:02');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

CREATE TABLE `sub_menus` (
  `id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `sub_menu_name` varchar(70) NOT NULL,
  `sub_menu_url` varchar(200) DEFAULT NULL,
  `sub_menu_order` int(2) DEFAULT NULL,
  `sub_menu_icon` varchar(100) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `is_active` varchar(1) NOT NULL DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`id`, `menu_id`, `sub_menu_name`, `sub_menu_url`, `sub_menu_order`, `sub_menu_icon`, `action`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 2, 'Role Management', '/master/add_role', 1, 'fa fa-circle-o text-red', 'addRole', 'Y', '2015-06-27 04:01:16', '2018-08-21 23:33:12'),
(7, 2, 'Menu', '/master/add_menu', 2, 'fa fa-circle-o text-red', 'addMenu', 'Y', '2015-06-27 04:01:37', '2021-02-24 19:31:32'),
(8, 2, 'Sub Menu', '/master/add_sub_menu', 3, 'fa fa-circle-o text-red', 'addSubMenu', 'Y', '2015-06-27 04:02:01', '2015-06-27 04:02:01'),
(9, 2, 'Role Assign To User', '/master/add_role_menu', 4, 'fa fa-circle-o text-red', 'addRoleMenu', 'Y', '2015-06-27 04:03:57', '2018-08-21 23:33:32'),
(14, 4, 'Profile', '/user/profile', 1, 'fa fa-circle-o text-red', 'Profile', 'Y', '2015-06-30 22:46:02', '2015-06-30 22:46:02'),
(15, 4, 'Change password', '/user/changepassword', 2, 'fa fa-circle-o text-red', 'getChangepassword', 'Y', '2015-06-30 22:46:56', '2015-06-30 22:46:56'),
(69, 4, 'Create User ', '/user/add_user', 3, 'fa fa-circle-o text-red', 'addUser', 'Y', '2018-01-29 19:20:39', '2018-01-29 19:20:39'),
(80, 6, 'Add Staff Data', '/employee/add_employee_data', 1, 'fa fa-circle-o text-red', 'addEmployeeData', 'Y', '2019-07-01 05:25:03', '2021-02-10 05:36:35'),
(81, 6, 'Assign Role To Staff', '/employee/assign_employee_role', 3, 'fa fa-circle-o text-red', 'assignEmployeeRole', 'Y', '2019-07-01 05:25:46', '2021-02-10 05:36:17'),
(82, 5, 'Add Department', '/setting/add_department', 3, 'fa fa-circle-o text-red', 'addDepartment', 'Y', '2019-07-03 03:46:36', '2019-07-03 03:46:36'),
(83, 5, 'Add Designation', '/setting/add_designation', 4, 'fa fa-circle-o text-red', 'addDesignation', 'Y', '2019-07-03 03:47:27', '2019-07-03 03:47:27'),
(87, 6, 'Staff List', '/employee/employee_list', 2, 'fa fa-circle-o text-red', 'employeeList', 'Y', '2019-07-18 04:33:48', '2021-02-10 05:36:07'),
(95, 5, 'Pathology Details', '/setting/add_pathology_details', 1, 'fa fa-circle-o text-red', NULL, 'Y', '2021-02-24 00:32:03', '2021-02-24 00:32:03');

-- --------------------------------------------------------

--
-- Table structure for table `t_department`
--

CREATE TABLE `t_department` (
  `id` bigint(20) NOT NULL,
  `department_name` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_department`
--

INSERT INTO `t_department` (`id`, `department_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'MANAGERIAL STAFF', 'Y', 1, '2021-02-10 10:28:10', '2021-02-10 04:58:10'),
(2, 'KITCHEN STAFF', 'Y', 1, '2021-02-10 10:27:52', '2021-02-10 04:57:52'),
(3, 'FLOOR STAFF', 'Y', 1, '2021-02-10 04:58:20', '2021-02-10 04:58:20'),
(4, 'BAR TENDERS', 'Y', 1, '2021-02-10 04:58:29', '2021-02-10 04:58:29'),
(5, 'DELIVERY STAFF', 'Y', 1, '2021-02-10 04:58:37', '2021-02-10 04:58:37'),
(6, 'ADMINISTRATION', 'Y', 1, '2021-02-10 05:02:52', '2021-02-10 05:02:52'),
(7, 'MARKETING & SALES', 'Y', 1, '2021-02-10 05:03:03', '2021-02-10 05:03:03'),
(8, 'SERVICE', 'Y', 1, '2021-02-10 05:03:30', '2021-02-10 05:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `t_designation`
--

CREATE TABLE `t_designation` (
  `id` bigint(20) NOT NULL,
  `designation_name` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_designation`
--

INSERT INTO `t_designation` (`id`, `designation_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'GENERAL MANAGER', 'Y', 1, '2021-02-10 10:29:31', '2021-02-10 04:59:31'),
(2, 'ASSISTANT MANAGER', 'Y', 1, '2021-02-10 04:59:39', '2021-02-10 04:59:39'),
(3, 'CASHIER', 'Y', 1, '2021-02-10 04:59:57', '2021-02-10 04:59:57'),
(4, 'KITCHEN MANAGER', 'Y', 1, '2021-02-10 05:00:08', '2021-02-10 05:00:08'),
(5, 'BARTENDER', 'Y', 1, '2021-02-10 05:00:32', '2021-02-10 05:00:32'),
(6, 'EXECUTIVE CHEF', 'Y', 1, '2021-02-10 05:00:47', '2021-02-10 05:00:47'),
(7, 'SOUS CHEF', 'Y', 1, '2021-02-10 05:00:52', '2021-02-10 05:00:52'),
(8, 'PASTRY CHEF', 'Y', 1, '2021-02-10 05:01:00', '2021-02-10 05:01:00'),
(9, 'CHEF GARDE MANAGER', 'Y', 1, '2021-02-10 05:01:06', '2021-02-10 05:01:06'),
(10, 'PREP COOK', 'Y', 1, '2021-02-10 05:01:19', '2021-02-10 05:01:19'),
(11, 'SHORT ORDER COOK', 'Y', 1, '2021-02-10 05:01:35', '2021-02-10 05:01:35'),
(12, 'FAST FOOD COOK', 'Y', 1, '2021-02-10 05:01:43', '2021-02-10 05:01:43'),
(13, 'SERVANT', 'Y', 1, '2021-02-10 23:53:46', '2021-02-10 23:53:46');

-- --------------------------------------------------------

--
-- Table structure for table `t_employee`
--

CREATE TABLE `t_employee` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `employee_official_id` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(75) NOT NULL,
  `emp_type` varchar(75) NOT NULL,
  `t_designation_id` bigint(20) NOT NULL,
  `t_department_id` bigint(20) NOT NULL,
  `blood_group` varchar(75) NOT NULL,
  `dob` date NOT NULL,
  `joining_date` date NOT NULL,
  `voter_card_number` varchar(75) NOT NULL,
  `employee_photo` varchar(100) NOT NULL,
  `adhar_card_number` varchar(75) NOT NULL,
  `pan_card_number` varchar(75) DEFAULT NULL,
  `uan_number` varchar(75) DEFAULT NULL,
  `esi_number` varchar(75) DEFAULT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_employee`
--

INSERT INTO `t_employee` (`id`, `user_id`, `employee_name`, `employee_official_id`, `mobile`, `email`, `gender`, `emp_type`, `t_designation_id`, `t_department_id`, `blood_group`, `dob`, `joining_date`, `voter_card_number`, `employee_photo`, `adhar_card_number`, `pan_card_number`, `uan_number`, `esi_number`, `present_address`, `permanent_address`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 13, 'AMITAV CHOUDHURY', 'EMP/RES/1', '8917406257', 'amitavc65@gmail.com', 'Male', 'Permanent', 1, 1, 'A+VE', '2021-02-10', '2021-02-10', '4123123123123', '1_6030d1cfb5504.png', '4234234', '234234', '234234', '', 'AT- SIVAJI NAGAR\r\nPO-TULASIPUR\r\nODISHA ,CUTTACK\r\n753008', 'AT- SIVAJI NAGAR\r\nPO-TULASIPUR\r\nODISHA ,CUTTACK\r\n753008', 'Y', 1, '2021-02-10 12:57:17', '2021-02-20 03:39:35'),
(5, 19, 'BASUDEV', 'EMP/RES/2', '9999999999', 'basu@gmail.com', 'Male', 'Permanent', 13, 8, 'A+VE', '2021-02-11', '2021-02-11', '123121312332323', '', '121212121212', NULL, NULL, NULL, 'BBSR', 'BBSR', 'Y', 1, '2021-02-11 00:03:39', '2021-02-11 01:31:24'),
(6, 20, 'SUNIL', 'EMP/RES/3', '9999999999', 's@gmail.com', 'Male', 'Permanent', 13, 8, 'A+VE', '2013-06-18', '2021-02-20', '121212121212112', '', '12121212121212', NULL, NULL, NULL, 'BBSR', 'BBSR', 'Y', 1, '2021-02-20 00:15:37', '2021-02-20 00:15:37'),
(7, 21, 'ABHISHEK', 'EMP/RES/4', '8888888888', 'ab@gmail.com', 'Male', 'Temporary', 2, 1, 'A+VE', '2009-02-17', '2021-02-20', '789789789789789789789', '', '78978978978789', NULL, NULL, NULL, 'CTC', 'CTC', 'Y', 1, '2021-02-20 00:16:51', '2021-02-20 00:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `re_password` varchar(75) NOT NULL,
  `ogr_password` varchar(100) NOT NULL,
  `user_photo` varchar(75) NOT NULL,
  `mobile_number` varchar(75) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0 COMMENT '0-> active, 1->Inactive,2->Pending',
  `is_reset_req` smallint(6) NOT NULL DEFAULT 0 COMMENT '0->No, 1 -> Yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `fullname`, `email`, `password`, `re_password`, `ogr_password`, `user_photo`, `mobile_number`, `remember_token`, `gender`, `address`, `status`, `is_reset_req`, `created_at`, `updated_at`) VALUES
(1, 1, 'Developer Panel', 'amitavc65@gmail.com', '$2y$10$pvRRbnX3MvQ9kZ8HMgqO5ehoLveZkFLjiHRnVl8WTwwccfsmIMKje', '$2y$10$vyXJa4Xaer/10czcuTEiieXi.omDdMEcdZZbGE/XeHhmtJf.dsB6m', 'password123', '1_5d023d15e52f3.jpg', '9658778395', 'wjmEvHyY2xj9hqNZ27223nfxUPTkDkcCMLyJU3U5bn7mA80pchKlyFdNZUrp', '', '', 0, 0, '2021-02-20 10:13:48', '2021-02-20 04:43:15'),
(2, 2, 'Admin', 'admin@gmail.com', '$2y$10$2VxlZn6f36CyFYyHl2H9VOPoyE2K49DtyvGXHGznudSMDbt3N63JC', '$2y$10$2VxlZn6f36CyFYyHl2H9VOPoyE2K49DtyvGXHGznudSMDbt3N63JC', 'password', '', '8917406257', '3vwMioYjYOISNMt4pr3qZiWvQu0cSqOahsH5Z4GjEKUmXZKAntiJSgMhp5dG', '', '', 0, 0, '2021-02-11 07:03:29', '2018-05-05 23:41:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `sub_menu_id` (`sub_menu_id`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `t_department`
--
ALTER TABLE `t_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_designation`
--
ALTER TABLE `t_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_employee`
--
ALTER TABLE `t_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_department_id` (`t_department_id`),
  ADD KEY `t_designation_id` (`t_designation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_deg_designation_id` (`role_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `role_id_2` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4249;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `t_department`
--
ALTER TABLE `t_department`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_designation`
--
ALTER TABLE `t_designation`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `t_employee`
--
ALTER TABLE `t_employee`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD CONSTRAINT `role_menus_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_menus_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  ADD CONSTRAINT `role_menus_ibfk_3` FOREIGN KEY (`sub_menu_id`) REFERENCES `sub_menus` (`id`);

--
-- Constraints for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD CONSTRAINT `sub_menus_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);

--
-- Constraints for table `t_employee`
--
ALTER TABLE `t_employee`
  ADD CONSTRAINT `t_employee_ibfk_1` FOREIGN KEY (`t_department_id`) REFERENCES `t_department` (`id`),
  ADD CONSTRAINT `t_employee_ibfk_2` FOREIGN KEY (`t_designation_id`) REFERENCES `t_designation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
