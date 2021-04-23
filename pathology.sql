-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2021 at 12:37 PM
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
(2, 'Super Admin', 2, '', 'fa fa-cubes', 'MasterController', 0, '2015-06-27 01:06:01', '2021-03-12 03:52:23'),
(4, 'Branch Admin', 4, '', 'fa fa-user', 'UserController', 0, '2015-06-30 22:42:44', '2021-04-16 00:32:00'),
(5, 'Setting', 6, NULL, 'fa fa-cogs', 'SettingController', 0, '2019-06-18 01:36:17', '2021-03-12 04:01:55'),
(6, 'Staff Master', 5, NULL, 'fa fa-users', 'EmployeeController', 0, '2019-07-01 05:24:16', '2021-02-10 05:35:52'),
(8, 'Master Admin', 3, NULL, 'fa fa-cubes', 'BranchController', 0, '2021-03-12 04:27:29', '2021-03-30 01:01:45');

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
(1, 'Super Admin\r\n', 0, '2021-02-27 10:10:24', '2021-02-27 10:10:24'),
(2, 'Master Admin\r\n', 0, '2021-02-27 10:10:24', '2021-02-27 10:10:24'),
(3, 'Branch Admin', 0, '2021-02-27 05:35:52', '2021-04-16 01:22:53'),
(4, 'Admin', 0, '2021-02-27 05:36:01', '2021-03-16 23:27:43'),
(5, 'Receptionist', 0, '2021-02-27 05:36:39', '2021-03-16 23:28:52');

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
(376, 4, 1, NULL, '0', '2021-03-12 04:44:00', '2021-03-12 04:44:00'),
(377, 4, 4, 6, '0', '2021-03-12 04:44:00', '2021-03-12 04:44:00'),
(378, 4, 4, 21, '0', '2021-03-12 04:44:00', '2021-03-12 04:44:00'),
(379, 4, 4, 7, '0', '2021-03-12 04:44:00', '2021-03-12 04:44:00'),
(515, 1, 1, NULL, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(516, 1, 2, 1, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(517, 1, 2, 2, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(518, 1, 2, 3, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(519, 1, 2, 22, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(520, 1, 2, 4, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(521, 1, 2, 5, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(522, 1, 2, 11, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(523, 1, 5, 7, '0', '2021-04-16 04:08:45', '2021-04-16 04:08:45'),
(535, 3, 1, NULL, '0', '2021-04-16 04:09:41', '2021-04-16 04:09:41'),
(536, 3, 4, 18, '0', '2021-04-16 04:09:41', '2021-04-16 04:09:41'),
(537, 3, 4, 21, '0', '2021-04-16 04:09:41', '2021-04-16 04:09:41'),
(538, 3, 5, 6, '0', '2021-04-16 04:09:41', '2021-04-16 04:09:41'),
(539, 3, 5, 7, '0', '2021-04-16 04:09:41', '2021-04-16 04:09:41'),
(540, 2, 1, NULL, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(541, 2, 8, 23, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(542, 2, 8, 14, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(543, 2, 8, 20, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(544, 2, 8, 19, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(545, 2, 8, 24, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(546, 2, 5, 25, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(547, 2, 5, 12, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(548, 2, 5, 13, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(549, 2, 5, 16, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(550, 2, 5, 17, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(551, 2, 5, 6, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12'),
(552, 2, 5, 7, '0', '2021-04-19 04:11:12', '2021-04-19 04:11:12');

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
(1, 2, 'Role', '/master/add_role', 1, 'fa fa-circle-o text-red', 'addRole', 'Y', '2021-02-27 10:24:33', '2021-02-27 10:24:33'),
(2, 2, 'Menu', '/master/add_menu', 2, 'fa fa-circle-o text-red', 'addMenu', 'Y', '2021-02-27 10:24:33', '2021-02-27 10:24:33'),
(3, 2, 'Sub Menu', '/master/add_sub_menu', 3, 'fa fa-circle-o text-red', 'addSubMenu', 'Y', '2021-02-27 10:27:37', '2021-02-27 10:27:37'),
(4, 2, 'Role Permission', '/master/add_role_menu', 6, 'fa fa-circle-o text-red', 'addRoleMenu', 'Y', '2021-02-27 10:27:37', '2021-03-19 00:52:14'),
(5, 2, 'Create Master Admin', '/master/add_master_user', 7, 'fa fa-circle-o text-red', 'addMasterUser', 'Y', '2021-02-27 10:29:41', '2021-04-16 01:18:13'),
(6, 5, 'Profile', '/setting/userprofile', 12, 'fa fa-circle-o text-red', 'userProfile', 'Y', '2021-02-27 10:29:41', '2021-04-16 04:10:06'),
(7, 5, 'Change Password', '/setting/changepassword', 13, 'fa fa-circle-o text-red', 'changepassword', 'Y', '2021-02-27 10:31:26', '2021-04-16 04:10:19'),
(8, 6, 'Add Staff Data', '/employee/add_employee_data', 1, 'fa fa-circle-o text-red', 'addEmployeeData', 'Y', '2021-02-27 10:31:26', '2021-02-27 10:31:26'),
(9, 6, 'Assign Role To Staff', '/employee/assign_employee_role', 3, 'fa fa-circle-o text-red', 'assignEmployeeRole', 'Y', '2021-02-27 10:34:02', '2021-02-27 10:34:02'),
(10, 6, 'Staff List', '/employee/employee_list', 2, 'fa fa-circle-o text-red', 'employeeList', 'Y', '2021-02-27 10:34:02', '2021-02-27 10:34:02'),
(11, 2, 'Organization Details', '/master/add_organization_details', 7, 'fa fa-circle-o text-red', 'addOrganizationDetails', 'Y', '2021-02-27 10:35:33', '2021-04-20 00:51:31'),
(12, 5, 'Add Department', '/setting/add_department', 4, 'fa fa-circle-o text-red', 'addDepartment', 'Y', '2021-02-27 10:35:33', '2021-02-28 01:33:31'),
(13, 5, 'Add Designation', '/setting/add_designation', 5, 'fa fa-circle-o text-red', 'addDesignation', 'Y', '2021-02-27 10:39:10', '2021-02-28 01:33:49'),
(14, 8, 'Add Branch Details', '/branch/add_regional_branch', 2, 'fa fa-circle-o text-red', 'addRegionalBranch', 'Y', '2021-02-28 01:35:53', '2021-04-16 01:01:19'),
(15, 5, 'Add Buniess Logistic', '/setting/add_business_logistics', 3, 'fa fa-circle-o text-red', 'addBusinessLogistics', 'Y', '2021-02-28 01:36:48', '2021-03-12 01:15:54'),
(16, 5, 'Add State', '/setting/add_state', 6, ' 	fa fa-circle-o text-red', 'addState', 'Y', '2021-02-28 01:37:36', '2021-02-28 01:37:36'),
(17, 5, 'Add City', '/setting/add_city', 7, 'fa fa-circle-o text-red', 'addCity', 'Y', '2021-02-28 01:38:21', '2021-02-28 01:38:21'),
(18, 4, 'Create Lab/Coll.  Admin', '/branch/add_lab_collection_center_user', 2, 'fa fa-circle-o text-red', 'addLabCollectionCenterUser', 'Y', '2021-03-01 06:53:52', '2021-04-22 07:03:49'),
(19, 8, 'Create Lab/Coll. Center', '/branch/add_lab_collection_center', 4, 'fa fa-circle-o text-red', 'addLabCollectionCenter', 'Y', '2021-03-12 04:34:18', '2021-04-16 01:02:04'),
(20, 8, 'Create Branch Admin', '/branch/create_branch_user', 3, 'fa fa-circle-o text-red', 'createBranchUser', 'Y', '2021-03-12 04:35:42', '2021-04-16 01:18:31'),
(21, 4, 'Create Lab/Coll. Center', '/branch/add_lab_collection_center', 1, 'fa fa-circle-o text-red', 'addLabCollectionCenter', 'Y', '2021-03-12 04:40:16', '2021-04-19 04:09:03'),
(22, 2, 'Add Features', 'master/add_features', 4, 'fa fa-circle-o text-red', 'addFeatures', 'Y', '2021-03-19 00:25:10', '2021-03-30 00:56:20'),
(23, 8, 'Create Org. User', '/branch/create_organization_user', 1, 'fa fa-circle-o text-red', 'createOrganizationUser', 'Y', '2021-04-16 01:01:09', '2021-04-16 05:32:09'),
(24, 8, 'Create Lab/Coll. Admin', '/branch/add_lab_collection_center_user', 5, 'fa fa-circle-o text-red', 'addLabCollectionCenterUser', 'Y', '2021-04-19 04:05:40', '2021-04-19 05:15:08'),
(25, 5, 'Add Fee Type', '/setting/add_fee_type', 1, 'fa fa-circle-o text-red', 'addFeeType', 'Y', '2021-04-19 04:11:00', '2021-04-19 04:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_branch_details`
--

CREATE TABLE `t_branch_details` (
  `id` bigint(20) NOT NULL,
  `t_organizations_id` bigint(20) NOT NULL,
  `t_states_id` bigint(20) NOT NULL,
  `t_cities_id` bigint(20) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_code` varchar(75) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `other_mobile_number` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `logo` varchar(50) NOT NULL,
  `pin_code` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_branch_details`
--

INSERT INTO `t_branch_details` (`id`, `t_organizations_id`, `t_states_id`, `t_cities_id`, `branch_name`, `branch_code`, `mobile_number`, `other_mobile_number`, `email_id`, `address`, `logo`, `pin_code`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'GENIX PATHOLAB BBSR BRANCH', 'GEN/BHU/1', '9658778395', '', 'info@genix.com', 'BBSR', '', '754009', 'Y', 1, '2021-03-01 01:59:35', '2021-04-16 04:11:02'),
(2, 1, 1, 1, 'GENIX PATHOLAB CUTTACK BRANCH', 'GEN/CUT/2', '9658778395', '', 'info@genix.com', 'Cuttack', '1_603c9bd185543.png', '753008', 'Y', 1, '2021-03-01 02:01:52', '2021-04-16 04:05:46');

-- --------------------------------------------------------

--
-- Table structure for table `t_business_logistic_dtls`
--

CREATE TABLE `t_business_logistic_dtls` (
  `id` bigint(20) NOT NULL,
  `t_organizations_id` bigint(20) NOT NULL DEFAULT 0,
  `t_branch_details_id` bigint(20) NOT NULL DEFAULT 0,
  `business_logistic_name` varchar(100) NOT NULL,
  `business_logistic_code` varchar(75) NOT NULL,
  `email_id` varchar(75) NOT NULL,
  `mobile_number` varchar(75) NOT NULL,
  `other_mobile_number` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `logo` varchar(75) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_business_logistic_dtls`
--

INSERT INTO `t_business_logistic_dtls` (`id`, `t_organizations_id`, `t_branch_details_id`, `business_logistic_name`, `business_logistic_code`, `email_id`, `mobile_number`, `other_mobile_number`, `address`, `logo`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'BHUASUNI LAB', 'BHU/GEN/1', 'bhuasuni@gmail.com', '8917406257', '9090909090', 'Sivaji Nagar\r\nCuttack\r\n753008', '', 'Y', 24, '2021-04-19 06:21:25', '2021-04-22 04:54:06'),
(2, 1, 1, 'APPLO LAB', 'APP/GEN/2', 'applo@gmail.com', '9999888890', '', 'BBSR\r\n785932', '', 'Y', 26, '2021-04-22 06:42:14', '2021-04-22 06:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `t_cities`
--

CREATE TABLE `t_cities` (
  `id` bigint(20) NOT NULL,
  `t_states_id` bigint(20) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_cities`
--

INSERT INTO `t_cities` (`id`, `t_states_id`, `city_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bhubaneswar', 'Y', 24, '2021-02-28 02:23:56', '2021-04-16 04:49:13'),
(2, 2, 'KOLKATTA', 'Y', 1, '2021-02-28 02:24:20', '2021-03-01 01:47:06'),
(3, 1, 'Cuttack', 'Y', 24, '2021-03-01 02:00:58', '2021-04-16 04:48:57'),
(4, 1, 'Jajpur', 'Y', 24, '2021-04-16 04:47:11', '2021-04-16 04:47:11'),
(5, 1, 'Puri', 'Y', 24, '2021-04-16 04:48:45', '2021-04-16 04:48:45');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_department`
--

INSERT INTO `t_department` (`id`, `department_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Nephropathology and Haematopathology', 'Y', 1, '2021-02-28 06:56:30', '2021-02-10 04:58:10'),
(2, 'General Biopsy', 'Y', 1, '2021-02-28 06:56:00', '2021-02-28 01:26:00'),
(3, 'Surgical Pathology', 'Y', 1, '2021-02-28 06:55:45', '2021-02-28 01:25:45'),
(4, 'Hepatopathology', 'Y', 1, '2021-02-28 06:55:31', '2021-02-28 01:25:31'),
(5, 'Dermatopathology', 'Y', 1, '2021-02-28 06:54:49', '2021-02-28 01:24:49'),
(6, 'Ophthalmic Pathology', 'Y', 1, '2021-02-28 06:54:34', '2021-02-28 01:24:34'),
(7, 'Cytology and Gastrointest', 'Y', 1, '2021-02-28 06:53:42', '2021-02-28 01:23:42'),
(8, 'Haematopathology', 'Y', 1, '2021-02-28 06:53:52', '2021-02-28 01:23:52'),
(9, 'Nephropathology', 'Y', 1, '2021-03-12 09:52:22', '2021-03-12 04:22:22'),
(10, 'Cardiac Pathology', 'Y', 1, '2021-03-12 09:53:22', '2021-03-12 04:23:22'),
(11, 'Gastrointestinal Pathology', 'Y', 1, '2021-03-12 09:53:00', '2021-03-12 04:23:00'),
(12, 'X', 'N', 24, '2021-04-16 10:50:35', '2021-04-16 05:20:35');

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_designation`
--

INSERT INTO `t_designation` (`id`, `designation_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'Sweepers', 'Y', 1, '2021-02-28 07:02:01', '2021-02-10 05:00:32'),
(6, 'Record Clerk', 'Y', 1, '2021-02-28 07:01:51', '2021-02-10 05:00:47'),
(7, 'Store Incharge', 'Y', 1, '2021-02-28 07:01:44', '2021-02-10 05:00:52'),
(8, 'Clerk', 'Y', 1, '2021-02-28 07:01:32', '2021-02-10 05:01:00'),
(9, 'Steno-typist', 'Y', 1, '2021-02-28 07:01:19', '2021-02-28 01:31:19'),
(10, 'Technicians', 'Y', 1, '2021-02-28 07:01:06', '2021-02-28 01:31:06'),
(11, 'Laboratory Attendants', 'Y', 1, '2021-02-28 07:00:50', '2021-02-28 01:30:50'),
(12, 'Technical Assistant', 'Y', 1, '2021-02-28 07:00:41', '2021-02-28 01:30:41'),
(13, 'ARTIST', 'N', 24, '2021-04-16 10:42:41', '2021-04-16 05:12:41');

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
-- Table structure for table `t_features`
--

CREATE TABLE `t_features` (
  `id` bigint(20) NOT NULL,
  `feature_name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_features`
--

INSERT INTO `t_features` (`id`, `feature_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin Modules', 'Y', '2021-03-31 07:13:27', '2021-03-31 01:43:27'),
(2, 'Employee Modules', 'Y', '2021-03-31 07:13:13', '2021-03-31 01:43:13'),
(3, 'master modules', 'Y', '2021-04-02 01:59:44', '2021-04-02 01:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_features_details`
--

CREATE TABLE `t_features_details` (
  `id` bigint(20) NOT NULL,
  `t_organizations_id` bigint(20) NOT NULL DEFAULT 0,
  `t_branch_details_id` bigint(20) DEFAULT 0,
  `t_features_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `sub_menu_id` bigint(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_features_details`
--

INSERT INTO `t_features_details` (`id`, `t_organizations_id`, `t_branch_details_id`, `t_features_id`, `menu_id`, `sub_menu_id`, `status`, `created_at`, `updated_at`) VALUES
(20, 0, 0, 2, 1, 0, 'Y', '2021-03-31 01:43:13', '2021-03-31 01:43:13'),
(21, 0, 0, 2, 6, 8, 'Y', '2021-03-31 01:43:13', '2021-03-31 01:43:13'),
(22, 0, 0, 2, 6, 10, 'Y', '2021-03-31 01:43:13', '2021-03-31 01:43:13'),
(23, 0, 0, 2, 6, 9, 'Y', '2021-03-31 01:43:13', '2021-03-31 01:43:13'),
(31, 0, 0, 1, 1, 0, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(32, 0, 0, 1, 2, 1, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(33, 0, 0, 1, 2, 2, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(34, 0, 0, 1, 2, 3, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(35, 0, 0, 1, 2, 22, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(36, 0, 0, 1, 2, 4, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(37, 0, 0, 1, 2, 5, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(38, 0, 0, 1, 2, 11, 'Y', '2021-03-31 01:43:27', '2021-03-31 01:43:27'),
(87, 0, 0, 3, 1, 0, 'Y', '2021-04-02 01:59:44', '2021-04-02 01:59:44'),
(88, 0, 0, 3, 8, 14, 'Y', '2021-04-02 01:59:44', '2021-04-02 01:59:44'),
(89, 0, 0, 3, 8, 19, 'Y', '2021-04-02 01:59:44', '2021-04-02 01:59:44'),
(90, 0, 0, 3, 8, 20, 'Y', '2021-04-02 01:59:44', '2021-04-02 01:59:44'),
(103, 1, 0, 1, 1, 0, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(104, 1, 0, 1, 2, 1, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(105, 1, 0, 1, 2, 2, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(106, 1, 0, 1, 2, 3, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(107, 1, 0, 1, 2, 22, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(108, 1, 0, 1, 2, 4, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(109, 1, 0, 1, 2, 5, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(110, 1, 0, 1, 2, 11, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(111, 1, 0, 2, 1, 0, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(112, 1, 0, 2, 6, 8, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(113, 1, 0, 2, 6, 10, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(114, 1, 0, 2, 6, 9, 'Y', '2021-04-16 03:16:34', '2021-04-16 03:16:34'),
(127, 1, 2, 1, 1, 0, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(128, 1, 2, 1, 2, 1, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(129, 1, 2, 1, 2, 2, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(130, 1, 2, 1, 2, 3, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(131, 1, 2, 1, 2, 22, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(132, 1, 2, 1, 2, 4, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(133, 1, 2, 1, 2, 5, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(134, 1, 2, 1, 2, 11, 'Y', '2021-04-16 04:05:46', '2021-04-16 04:05:46'),
(135, 1, 1, 1, 1, 0, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(136, 1, 1, 1, 2, 1, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(137, 1, 1, 1, 2, 2, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(138, 1, 1, 1, 2, 3, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(139, 1, 1, 1, 2, 22, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(140, 1, 1, 1, 2, 4, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(141, 1, 1, 1, 2, 5, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(142, 1, 1, 1, 2, 11, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(143, 1, 1, 1, 1, 0, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(144, 1, 1, 1, 2, 1, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(145, 1, 1, 1, 2, 2, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(146, 1, 1, 1, 2, 3, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(147, 1, 1, 1, 2, 22, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(148, 1, 1, 1, 2, 4, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(149, 1, 1, 1, 2, 5, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(150, 1, 1, 1, 2, 11, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(151, 1, 1, 2, 1, 0, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(152, 1, 1, 2, 6, 8, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(153, 1, 1, 2, 6, 10, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02'),
(154, 1, 1, 2, 6, 9, 'Y', '2021-04-16 04:11:02', '2021-04-16 04:11:02');

-- --------------------------------------------------------

--
-- Table structure for table `t_organizations`
--

CREATE TABLE `t_organizations` (
  `id` bigint(20) NOT NULL,
  `organization_name` varchar(200) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `alter_mobile_number` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `pan_number` varchar(75) NOT NULL,
  `gst_number` varchar(75) NOT NULL,
  `points_of_contact` int(11) NOT NULL,
  `number_of_branch` int(11) NOT NULL,
  `bank_name` varchar(75) NOT NULL,
  `branch_name` varchar(75) NOT NULL,
  `ifsc_code` varchar(75) NOT NULL,
  `account_number` varchar(75) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_organizations`
--

INSERT INTO `t_organizations` (`id`, `organization_name`, `mobile_number`, `alter_mobile_number`, `address`, `email_id`, `pan_number`, `gst_number`, `points_of_contact`, `number_of_branch`, `bank_name`, `branch_name`, `ifsc_code`, `account_number`, `logo`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'GENIX PATHOLAB', '8917406257', '', 'Sivaji Nagar', 'info@genixpatholab.com', '1234567890', '123456789012345', 1, 2, 'dfsdf', 'sdfsdf', '53453453445', '45345345345', '1_606328050c89f.png', 'Y', 1, '2021-02-28 00:55:23', '2021-04-16 03:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `t_states`
--

CREATE TABLE `t_states` (
  `id` bigint(20) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_by` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t_states`
--

INSERT INTO `t_states` (`id`, `state_name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Odisha', 'Y', 1, '2021-02-28 02:04:02', '2021-03-12 04:26:30'),
(2, 'West Bengal', 'Y', 1, '2021-02-28 02:24:11', '2021-03-12 04:26:43'),
(3, 'UP', 'N', 24, '2021-04-16 04:59:52', '2021-04-16 05:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `t_organizations_id` bigint(20) NOT NULL DEFAULT 0,
  `t_branch_details_id` bigint(20) NOT NULL DEFAULT 0,
  `t_business_logistic_dtl_id` bigint(20) NOT NULL DEFAULT 0,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `re_password` varchar(75) NOT NULL,
  `ogr_password` varchar(100) NOT NULL,
  `user_photo` varchar(75) NOT NULL,
  `mobile_number` varchar(75) NOT NULL,
  `alter_mobile_number` varchar(75) NOT NULL,
  `adhar_number` varchar(75) NOT NULL,
  `remember_token` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0 COMMENT '0-> active, 1->Inactive,2->Pending',
  `is_reset_req` smallint(6) NOT NULL DEFAULT 0 COMMENT '0->No, 1 -> Yes',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `t_organizations_id`, `t_branch_details_id`, `t_business_logistic_dtl_id`, `full_name`, `email_id`, `password`, `re_password`, `ogr_password`, `user_photo`, `mobile_number`, `alter_mobile_number`, `adhar_number`, `remember_token`, `address`, `status`, `is_reset_req`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, 0, 'Developer Panel', 'amitavc65@gmail.com', '$2y$10$iZBmlMl/v4h4e6SvTgteyOIXATEq.eMGg2hqrWMadOuzNxeABWzy6', '$2y$10$rBG//Rh/jqE1Ndyo9jaP4eu39t4Xxap9Sq3mXHV4Jx33Lva4yM3EO', 'password', '', '9658778395', '', '', 'jbwuT5U0PbB4hBmcfkDJwAXf96oFsPvFIgSmNQoeWQDTKUi2MgH2DXk4htWx', '', 0, 0, '2021-02-20 10:13:48', '2021-03-01 07:14:37'),
(24, 2, 1, 0, 0, 'Leena Dutta', 'leena.dutta@gmail.com', '$2y$10$iJEy8Sb.KY9ZgQ5q4jYyZO.4UBc7cU8cQkNBmMY8hZhZHXFUJZhIa', '$2y$10$l1nAtlJW1Z2fBe4FK4zcB.C8xmw/ONDuGngwVt8HOv.uT2poAbQ5y', 'password', '24_607975453c043.png', '9090785645', '', '8917406257123456', 'foPigeyhcgrUnkaCBzO46WRHIx18zTIaPhmWBXpbc2kTe604lRMTEYMRLaQm', 'BBSR', 0, 0, '2021-03-01 23:06:58', '2021-04-16 06:00:13'),
(26, 3, 1, 1, 0, 'Subham Sahoo', 'subham@gmail.com', '$2y$10$ayYGoqypbma2ZuLZRTAH0.p.Gz1E9hlirZMVcLZPYPTzEi.STltjG', '$2y$10$DzIRik3zpR1WU2LAQIOmT.T5S4HEe5sOzOz/rGMVpyHq.GvVgXmmu', 'password', '24_60793c9de2f0c.png', '8917456253', '', '1234567890123451', 'hZpTsqScvfXgZtDi7cFGvJywaTzKbBnci0aN9hbp', 'BBSR', 0, 0, '2021-04-16 01:58:30', '2021-04-16 01:58:41'),
(27, 5, 1, 0, 1, 'Pragnya', 'prangya@gmail.com', '$2y$10$tmdcirPr2DL8YRcffmwUYu2hgJjDfWBVVokl6CshP1YSAtG4TR5Fa', '$2y$10$1jaBOQuwR8iL3MtTXtvpzuJNhIvomJYSuKSFUqEn4X4w/Z/MeTO9S', 'password', '24_60816507d8715.png', '8989898989', '', '1234567890123456', 'RgfUeQrvO1nBIHA0P2hC18akyTMKQGT32rRE2I1D', 'BBSR\r\nODISHA', 0, 0, '2021-04-22 06:29:04', '2021-04-22 06:34:50'),
(28, 4, 1, 1, 2, 'Basudev', 'basu@gmail.com', '$2y$10$oEDRbY/ZGc8GFSR8upoWc.Ye1jY7k6EjQoExipZv2oBGGXFkj6mRu', '$2y$10$Hp.wShKYPUVtKwIU3T5KuOzh/JBV80z80cz9Oqxf1bQKPshVRSIu6', 'password', '', '9999999888', '', '1234567890123456', 'RgfUeQrvO1nBIHA0P2hC18akyTMKQGT32rRE2I1D', '', 0, 0, '2021-04-22 07:02:33', '2021-04-22 07:02:51');

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
-- Indexes for table `t_branch_details`
--
ALTER TABLE `t_branch_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_organizations_id` (`t_organizations_id`),
  ADD KEY `t_cities_id` (`t_cities_id`),
  ADD KEY `id` (`id`,`t_organizations_id`,`t_states_id`,`t_cities_id`),
  ADD KEY `t_states_id` (`t_states_id`);

--
-- Indexes for table `t_business_logistic_dtls`
--
ALTER TABLE `t_business_logistic_dtls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_cities`
--
ALTER TABLE `t_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_states_id` (`t_states_id`);

--
-- Indexes for table `t_department`
--
ALTER TABLE `t_department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `t_designation`
--
ALTER TABLE `t_designation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `t_employee`
--
ALTER TABLE `t_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_department_id` (`t_department_id`),
  ADD KEY `t_designation_id` (`t_designation_id`);

--
-- Indexes for table `t_features`
--
ALTER TABLE `t_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_features_details`
--
ALTER TABLE `t_features_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `t_features_id` (`t_features_id`),
  ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `t_organizations`
--
ALTER TABLE `t_organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `t_states`
--
ALTER TABLE `t_states`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=553;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `t_branch_details`
--
ALTER TABLE `t_branch_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_business_logistic_dtls`
--
ALTER TABLE `t_business_logistic_dtls`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_cities`
--
ALTER TABLE `t_cities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_department`
--
ALTER TABLE `t_department`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
-- AUTO_INCREMENT for table `t_features`
--
ALTER TABLE `t_features`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_features_details`
--
ALTER TABLE `t_features_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `t_organizations`
--
ALTER TABLE `t_organizations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `t_states`
--
ALTER TABLE `t_states`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- Constraints for table `t_branch_details`
--
ALTER TABLE `t_branch_details`
  ADD CONSTRAINT `t_branch_details_ibfk_1` FOREIGN KEY (`t_organizations_id`) REFERENCES `t_organizations` (`id`),
  ADD CONSTRAINT `t_branch_details_ibfk_3` FOREIGN KEY (`t_cities_id`) REFERENCES `t_cities` (`id`),
  ADD CONSTRAINT `t_branch_details_ibfk_4` FOREIGN KEY (`t_states_id`) REFERENCES `t_states` (`id`);

--
-- Constraints for table `t_cities`
--
ALTER TABLE `t_cities`
  ADD CONSTRAINT `t_cities_ibfk_1` FOREIGN KEY (`t_states_id`) REFERENCES `t_states` (`id`);

--
-- Constraints for table `t_employee`
--
ALTER TABLE `t_employee`
  ADD CONSTRAINT `t_employee_ibfk_1` FOREIGN KEY (`t_department_id`) REFERENCES `t_department` (`id`),
  ADD CONSTRAINT `t_employee_ibfk_2` FOREIGN KEY (`t_designation_id`) REFERENCES `t_designation` (`id`);

--
-- Constraints for table `t_features_details`
--
ALTER TABLE `t_features_details`
  ADD CONSTRAINT `t_features_details_ibfk_1` FOREIGN KEY (`t_features_id`) REFERENCES `t_features` (`id`),
  ADD CONSTRAINT `t_features_details_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
