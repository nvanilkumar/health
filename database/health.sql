-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.12-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5151
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for laravel
CREATE DATABASE IF NOT EXISTS `laravel` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `laravel`;

-- Dumping structure for table laravel.activations
CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.activations: ~0 rows (approximately)
/*!40000 ALTER TABLE `activations` DISABLE KEYS */;
INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
	(1, 1, '1S4u7lJzehk62xDm3DgYgXXYWtbHE6gSP', 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `activations` ENABLE KEYS */;

-- Dumping structure for table laravel.household
CREATE TABLE IF NOT EXISTS `household` (
  `_id` int(11) NOT NULL,
  `hh_id` text,
  `door_no` text,
  `locality_id` int(11) DEFAULT NULL,
  `village_name` text,
  `phc_name` text,
  `total_hh_size` int(11) DEFAULT NULL,
  `total_hh_eligible` int(11) DEFAULT NULL,
  `hh_head_fname` text,
  `hh_head_lname` text,
  `date` text,
  `type_of_house` text,
  `status_of_toilets` text,
  `drng_water_arrg` text,
  `eleciricity_arrg` text,
  `motor_vehcile` text,
  `type_of_fuel_cook_food` text,
  `contact_info` text,
  `patient_id_counter` int(11) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table laravel.household: ~0 rows (approximately)
/*!40000 ALTER TABLE `household` DISABLE KEYS */;
INSERT INTO `household` (`_id`, `hh_id`, `door_no`, `locality_id`, `village_name`, `phc_name`, `total_hh_size`, `total_hh_eligible`, `hh_head_fname`, `hh_head_lname`, `date`, `type_of_house`, `status_of_toilets`, `drng_water_arrg`, `eleciricity_arrg`, `motor_vehcile`, `type_of_fuel_cook_food`, `contact_info`, `patient_id_counter`) VALUES
	(1, '145', '5', 5, 'TestVillage1', 'phc12', 0, 0, 'vfdfc', 'test', '01-12-2017 15:59', 'Kutcha', 'Toilets with no water facility', 'ngcv', 'Have Electricity', 'Motor Bike', 'Kerosene Oil', '8745585558', 5),
	(2, '5555', '5', 5, 'TestVillage1', 'phc1', 0, 0, 'fdxcc', 'test', '01-12-2017 16:16', 'Fixed made of brick and concrete', 'Toilets with no water facility', 'hgfvb', 'Solar Power', 'Tractor', 'Coal', '8455855555', 5);
/*!40000 ALTER TABLE `household` ENABLE KEYS */;

-- Dumping structure for table laravel.mainline_riskassess
CREATE TABLE IF NOT EXISTS `mainline_riskassess` (
  `_id` int(11) NOT NULL,
  `patient_id` varchar(50) NOT NULL,
  `consent_num` text,
  `first_name` text,
  `sur_name` text,
  `contact_num` text,
  `shared_phone` text,
  `dob` text,
  `dob_unsure` text,
  `address` text,
  `vill_name` text,
  `locality` text,
  `gender` text,
  `doa` text,
  `age` text,
  `id_card` text,
  `aadhar_num` text,
  `state_insurance` text,
  `breath_dlty` text,
  `cough` text,
  `bld_sputum` text,
  `getg_seizures` text,
  `dlty_open_mth` text,
  `rashes_patches` text,
  `chg_voice` text,
  `lump_in_brst` text,
  `bld_tinged_nple` text,
  `diff_sizes_brts` text,
  `bledg_bt_mensprd` text,
  `atr_menopause` text,
  `drg_intcrs` text,
  `foul_dicrg` text,
  `hbp` text,
  `hbp_dt_invg` text,
  `hbp_tst_rst` text,
  `hbp_dt_diag` text,
  `hbp_trt_phc_nm` text,
  `hbp_trt_drg_avl` text,
  `hbp_trt_ontrt` text,
  `hbp_sdeffct` text,
  `diag` text,
  `diag_dt_invg` text,
  `diag_tst_rst` text,
  `diag_dt_diag` text,
  `diag_trt_phc_nm` text,
  `diag_trt_drg_avl` text,
  `diag_trt_ontrt` text,
  `diag_sdeffct` text,
  `mth_cn` text,
  `mth_cn_dt_invg` text,
  `mth_cn_tst_rst` text,
  `mth_cn_dt_diag` text,
  `mth_cn_trt_phc_nm` text,
  `mth_cn_trt_drg_avl` text,
  `mth_cn_trt_ontrt` text,
  `mth_cn_sdeffct` text,
  `brts_cn` text,
  `brts_cn_dt_invg` text,
  `brts_cn_tst_rst` text,
  `brts_cn_dt_diag` text,
  `brts_cn_trt_phc_nm` text,
  `brts_cn_trt_drg_avl` text,
  `brts_cn_trt_ontrt` text,
  `brts_cn_sdeffct` text,
  `cvr_cn` text,
  `cvr_cn_dt_invg` text,
  `cvr_cn_tst_rst` text,
  `cvr_cn_dt_diag` text,
  `cvr_cn_trt_phc_nm` text,
  `cvr_cn_trt_drg_avl` text,
  `cvr_cn_trt_ontrt` text,
  `cvr_cn_sdeffct` text,
  `copd_dis` text,
  `copd_dis_dt_invg` text,
  `copd_dis_tst_rst` text,
  `copd_dis_dt_diag` text,
  `copd_dis_trt_phc_nm` text,
  `copd_dis_trt_drg_avl` text,
  `copd_dis_trt_ontrt` text,
  `copd_dis_sdeffct` text,
  `ph_hrtattack` text,
  `ph_bp` text,
  `ph_bp_since` text,
  `ph_medication` text,
  `ph_stroke` text,
  `ph_pvd` text,
  `ph_pvd_since` text,
  `ph_diab` text,
  `ph_hrtattack_since` text,
  `ph_stroke_since` text,
  `ph_diab_since` text,
  `fh_hrtattack` text,
  `fh_stroke` text,
  `fh_diab` text,
  `fh_hbp` text,
  `rh_q1` text,
  `rh_q2` text,
  `rh_q2_yes` text,
  `rh_q2_no` text,
  `rh_ques2_if_other_reason` text,
  `th_bp` text,
  `th_bg` text,
  `th_aptt` text,
  `th_lltt` text,
  `th_diab` text,
  `tobacco_ques` text,
  `sh_current` text,
  `sh_agestarted` text,
  `sh_quit` text,
  `ch_current` text,
  `ch_agestarted` text,
  `ch_quit` text,
  `crntly_alcoholic` text,
  `do_you_exe` text,
  `sbp1` text,
  `dbp1` text,
  `sbp2` text,
  `dbp2` text,
  `sbp3` text,
  `dbp3` text,
  `hr1` text,
  `hr2` text,
  `hr3` text,
  `sbp_avg` text,
  `dbp_avg` text,
  `hr_avg` text,
  `bp_cuffsize` text,
  `pulse` text,
  `bg_fasting_calc` text,
  `bg_rectime` text,
  `bg_value` text,
  `tc` text,
  `ldl` text,
  `hdl` text,
  `tg` text,
  `chol_resultdate` text,
  `ht` text,
  `wt` text,
  `wst_mrmt` text,
  `bg_lasteat` text,
  `bp_perday` text,
  `bp_perweek` text,
  `bp_perlastweek` text,
  `bp_peryesterday` text,
  `bg_perday` text,
  `bg_perweek` text,
  `bg_perlastweek` text,
  `bg_peryesterday` text,
  `lltt_perday` text,
  `lltt_perweek` text,
  `lltt_perlastweek` text,
  `lltt_peryesterday` text,
  `aptt_perday` text,
  `aptt_perweek` text,
  `aptt_perlastweek` text,
  `aptt_peryesterday` text,
  `bp_druglist` text,
  `lltt_druglist` text,
  `aptt_druglist` text,
  `diabetes_druglist` text,
  `med_bp` text,
  `med_statin` text,
  `med_aspirin` text,
  `med_diabetes` text,
  `med_bp_reason` text,
  `med_lltt_reason` text,
  `med_aptt_reason` text,
  `med_diabetes_reason` text,
  `tt_pres` text,
  `ref_card_no` text,
  `cvd_risk` text,
  `smoker_calc` text,
  `ref_doc` text,
  `next_visit_1month` text,
  `tt_adher` text,
  `med_received` text,
  `update_date` text,
  `created_date` text,
  `current_user_login` text,
  `current_user_role` text,
  `last_encounter` text,
  `current_encounter` text,
  `enc_date` text,
  `enc_type` text,
  `phc_name` text,
  `asha_assigned` text,
  `diab_calc` text,
  `smoker_tl` text,
  `ar_recom` text,
  `nv_ar` text,
  `nv_ar_tl` text,
  `ph_cvd_calc` text,
  `high_risk_calc` text,
  `nv_diab` text,
  `nv_diab_tl` text,
  `ref_doc_tl` text,
  `target_sbp` text,
  `target_sbp_tl` text,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table laravel.mainline_riskassess: ~20 rows (approximately)
/*!40000 ALTER TABLE `mainline_riskassess` DISABLE KEYS */;
INSERT INTO `mainline_riskassess` (`_id`, `patient_id`, `consent_num`, `first_name`, `sur_name`, `contact_num`, `shared_phone`, `dob`, `dob_unsure`, `address`, `vill_name`, `locality`, `gender`, `doa`, `age`, `id_card`, `aadhar_num`, `state_insurance`, `breath_dlty`, `cough`, `bld_sputum`, `getg_seizures`, `dlty_open_mth`, `rashes_patches`, `chg_voice`, `lump_in_brst`, `bld_tinged_nple`, `diff_sizes_brts`, `bledg_bt_mensprd`, `atr_menopause`, `drg_intcrs`, `foul_dicrg`, `hbp`, `hbp_dt_invg`, `hbp_tst_rst`, `hbp_dt_diag`, `hbp_trt_phc_nm`, `hbp_trt_drg_avl`, `hbp_trt_ontrt`, `hbp_sdeffct`, `diag`, `diag_dt_invg`, `diag_tst_rst`, `diag_dt_diag`, `diag_trt_phc_nm`, `diag_trt_drg_avl`, `diag_trt_ontrt`, `diag_sdeffct`, `mth_cn`, `mth_cn_dt_invg`, `mth_cn_tst_rst`, `mth_cn_dt_diag`, `mth_cn_trt_phc_nm`, `mth_cn_trt_drg_avl`, `mth_cn_trt_ontrt`, `mth_cn_sdeffct`, `brts_cn`, `brts_cn_dt_invg`, `brts_cn_tst_rst`, `brts_cn_dt_diag`, `brts_cn_trt_phc_nm`, `brts_cn_trt_drg_avl`, `brts_cn_trt_ontrt`, `brts_cn_sdeffct`, `cvr_cn`, `cvr_cn_dt_invg`, `cvr_cn_tst_rst`, `cvr_cn_dt_diag`, `cvr_cn_trt_phc_nm`, `cvr_cn_trt_drg_avl`, `cvr_cn_trt_ontrt`, `cvr_cn_sdeffct`, `copd_dis`, `copd_dis_dt_invg`, `copd_dis_tst_rst`, `copd_dis_dt_diag`, `copd_dis_trt_phc_nm`, `copd_dis_trt_drg_avl`, `copd_dis_trt_ontrt`, `copd_dis_sdeffct`, `ph_hrtattack`, `ph_bp`, `ph_bp_since`, `ph_medication`, `ph_stroke`, `ph_pvd`, `ph_pvd_since`, `ph_diab`, `ph_hrtattack_since`, `ph_stroke_since`, `ph_diab_since`, `fh_hrtattack`, `fh_stroke`, `fh_diab`, `fh_hbp`, `rh_q1`, `rh_q2`, `rh_q2_yes`, `rh_q2_no`, `rh_ques2_if_other_reason`, `th_bp`, `th_bg`, `th_aptt`, `th_lltt`, `th_diab`, `tobacco_ques`, `sh_current`, `sh_agestarted`, `sh_quit`, `ch_current`, `ch_agestarted`, `ch_quit`, `crntly_alcoholic`, `do_you_exe`, `sbp1`, `dbp1`, `sbp2`, `dbp2`, `sbp3`, `dbp3`, `hr1`, `hr2`, `hr3`, `sbp_avg`, `dbp_avg`, `hr_avg`, `bp_cuffsize`, `pulse`, `bg_fasting_calc`, `bg_rectime`, `bg_value`, `tc`, `ldl`, `hdl`, `tg`, `chol_resultdate`, `ht`, `wt`, `wst_mrmt`, `bg_lasteat`, `bp_perday`, `bp_perweek`, `bp_perlastweek`, `bp_peryesterday`, `bg_perday`, `bg_perweek`, `bg_perlastweek`, `bg_peryesterday`, `lltt_perday`, `lltt_perweek`, `lltt_perlastweek`, `lltt_peryesterday`, `aptt_perday`, `aptt_perweek`, `aptt_perlastweek`, `aptt_peryesterday`, `bp_druglist`, `lltt_druglist`, `aptt_druglist`, `diabetes_druglist`, `med_bp`, `med_statin`, `med_aspirin`, `med_diabetes`, `med_bp_reason`, `med_lltt_reason`, `med_aptt_reason`, `med_diabetes_reason`, `tt_pres`, `ref_card_no`, `cvd_risk`, `smoker_calc`, `ref_doc`, `next_visit_1month`, `tt_adher`, `med_received`, `update_date`, `created_date`, `current_user_login`, `current_user_role`, `last_encounter`, `current_encounter`, `enc_date`, `enc_type`, `phc_name`, `asha_assigned`, `diab_calc`, `smoker_tl`, `ar_recom`, `nv_ar`, `nv_ar_tl`, `ph_cvd_calc`, `high_risk_calc`, `nv_diab`, `nv_diab_tl`, `ref_doc_tl`, `target_sbp`, `target_sbp_tl`) VALUES
	(1, '101011010001', '', 'aa', '', '8755464554', '0', '1-1-1966', '0', 'aaa', 'TestVillage1', '', 'M', '04-12-2017', '51', '1', '848546485464', 'Y', '0', '0', '0', '0', '0', '0', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '', '0', '0', '0', '4', '-1', '', '-1', '-1', '', '-1', '0', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 11:35', '200', '-1', '-1', '-1', '-1', '-1', '145', '60', '10', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '1', '1', '0', '1', '1', '', '', '04-12-2017 11:35', '04-12-2017 11:35', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:35', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '-1', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '-1', '-1'),
	(2, '101011010002', '', 'bb', '', '7848455454', '0', '1-1-1965', '0', 'bbh', 'TestVillage1', '', 'M', '04-12-2017', '52', '1', '645548486454', 'Y', '1', '1', '1', '1', '1', '1', '1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '1', '4-12-2017', 'hbp', '4-12-2017', 'hbp', '1', '1', 'hbp', '1', '4-12-2017', 'dbt', '4-12-2017', 'dbt', '1', '1', 'dbt', '1', '4-12-2017', 'mtcn', '4-12-2017', 'mtcn', '1', '1', 'mtcn', '1', '4-12-2017', 'bscn', '4-12-2017', 'bscn', '1', '1', 'bscn', '-1', '', '', '', '', '', '', '', '1', '4-12-2017', 'copd', '4-12-2017', 'copd', '1', '1', 'copd', '1', '1', '1', '', '1', '1', '1', '1', '2', '1', '1', '1', '1', '1', '1', '', '', '', '', '', '1', '', '1', '1', '1', '3', '1', '25', '-1', '1', '28', '-1', '1', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 11:38', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '10', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '2', '6', '1', '1', '1', '', '', '04-12-2017 11:38', '04-12-2017 11:38', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:38', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(3, '101011010003', '', 'cc', '', '8756465766', '0', '1-1-1964', '0', 'ccc', 'TestVillage1', '', 'F', '04-12-2017', '53', '1', '778875455484', 'N', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '', '0', '0', '0', '4', '-1', '', '-1', '-1', '', '-1', '0', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 11:39', '200', '-1', '-1', '-1', '-1', '-1', '142', '60', '10', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '3', '1', '0', '1', '1', '', '', '04-12-2017 11:40', '04-12-2017 11:40', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:40', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '-1', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '-1', '-1'),
	(4, '101011010004', '', 'dd', '', '6857557584', '0', '1-1-1963', '0', 'ddd', 'TestVillage1', '', 'F', '04-12-2017', '54', '1', '548858845948', 'Y', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'crcn', '4-12-2017', 'crcn', '1', '1', 'crcn', '0', '', '', '', '', '', '', '', '1', '1', '2', '', '1', '1', '3', '0', '1', '2', '0', '1', '1', '0', '0', '', '', '', '', '', '1', '', '1', '1', '1', '3', '1', '21', '-1', '1', '23', '-1', '1', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 11:42', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '11', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '4', '6', '1', '1', '1', '', '', '04-12-2017 11:42', '04-12-2017 11:42', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:42', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(5, '101011010005', '', 'ee', '', '9495757967', '0', '1-1-1962', '0', 'eee', 'TestVillage1', '', 'M', '04-12-2017', '55', '1', '554548488484', 'Y', '1', '1', '1', '1', '0', '0', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'bscn', '4-12-2017', 'bscn', '1', '0', 'bscn', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '1', '1', '', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', '', '', '', '', '1', '', '0', '0', '1', '3', '0', '', '1', '0', '', '1', '0', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 11:44', '200', '-1', '-1', '-1', '-1', '-1', '145', '60', '10', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '5', '1', '1', '1', '1', '', '', '04-12-2017 11:44', '04-12-2017 11:44', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:44', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '10', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '3', '1'),
	(6, '101011010006', '', 'ff', '', '8755454554', '0', '1-1-1961', '0', 'fff', 'TestVillage1', '', 'F', '04-12-2017', '56', '2', '848544548546', 'Y', '0', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'bscn', '4-12-2017', 'bscn', '1', '0', 'bscn', '1', '4-12-2017', 'crcn', '4-12-2017', 'crcn', '1', '0', 'crcn', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '1', '1', '0', '0', '0', '0', '0', '1', '0', '0', '', '', '', '', '', '0', '', '1', '0', '1', '3', '0', '', '1', '1', '14', '-1', '1', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 11:46', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '11', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '6', '6', '1', '1', '1', '', '', '04-12-2017 11:46', '04-12-2017 11:46', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:46', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(7, '101011010007', '', 'gg', '', '8456454648', '0', '1-1-1960', '0', 'ggg', 'TestVillage1', '', 'M', '04-12-2017', '57', '1', '878546496434', 'Y', '1', '1', '0', '0', '0', '0', '1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', '', '', '', '', '0', '', '1', '1', '1', '2', '-1', '', '-1', '0', '', '0', '1', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 11:47', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '12', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '7', '1', '0', '1', '1', '', '', '04-12-2017 11:48', '04-12-2017 11:48', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:48', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '10', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '-1', '-1'),
	(8, '101011010008', '', 'hh', '', '9465454846', '0', '1-1-1959', '0', 'hhh', 'TestVillage1', '', 'F', '04-12-2017', '58', '2', '548884964646', 'Y', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '1', '1', '1', '0', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'copd', '4-12-2017', 'copd', '0', '1', 'copd', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '0', '', '0', '0', '0', '4', '-1', '', '-1', '-1', '', '-1', '0', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 11:49', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '12', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '8', '1', '0', '1', '1', '', '', '04-12-2017 11:49', '04-12-2017 11:49', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:49', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '-1', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '-1', '-1'),
	(9, '101011010009', '', 'ii', '', '9544752255', '0', '1-1-1958', '0', 'iii', 'TestVillage1', '', 'M', '04-12-2017', '59', '1', '544255526555', 'N', '0', '0', '1', '1', '1', '1', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '0', '0', '', '1', '0', '0', '0', '3', '2', '0', '1', '0', '0', '0', '', '', '', '', '', '0', '', '0', '0', '1', '3', '0', '', '1', '1', '', '-1', '1', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 11:51', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '14', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '9', '6', '1', '1', '1', '', '', '04-12-2017 11:51', '04-12-2017 11:51', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:51', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(10, '101011010010', '', 'jj', '', '8755454845', '0', '1-1-1957', '0', 'jjj', 'TestVillage1', '', 'F', '04-12-2017', '60', '2', '888566656546', 'N', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'dbt', '4-12-2017', 'dbt', '0', '1', 'dbt', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '0', '0', '1', '0', '0', '2', '1', '1', '1', '0', '', '', '', '', '', '1', '', '0', '0', '0', '4', '-1', '', '-1', '-1', '', '-1', '1', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 11:52', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '12', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '10', '2', '0', '1', '1', '', '', '04-12-2017 11:53', '04-12-2017 11:53', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 11:52', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '10', '3', 'Absolute risk is 10% to < 20% , Absolute risk screening recommended once every 2 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '3', '1'),
	(11, '101011010011', '', 'll', '', '8456464664', '0', '1-1-1963', '0', 'lll', 'TestVillage1', '', 'F', '04-12-2017', '54', '2', '545848489494', 'Y', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '4-12-2017', 'hbp', '4-12-2017', 'hnp', '1', '1', 'hbp', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'crcn', '4-12-2017', 'crvn', '0', '0', 'crcn', '0', '', '', '', '', '', '', '', '0', '1', '2', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '', '', '', '', '', '1', '', '0', '0', '1', '3', '0', '', '0', '1', '45', '-1', '0', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 12:00', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '10', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '11', '1', '0', '1', '1', '', '', '04-12-2017 12:00', '04-12-2017 12:00', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:00', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '10', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '3', '1'),
	(12, '101011010012', '', 'mm', '', '8454654554', '0', '1-1-1963', '0', 'mmmeo', 'TestVillage1', '', 'M', '04-12-2017', '54', '1', '656468484884', 'N', '0', '0', '0', '1', '1', '1', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'dbt', '4-12-2017', 'dbt', '0', '0', 'dbt', '1', '4-12-2017', 'mtcn', '4-12-2017', 'mtcm', '0', '0', 'mtcn', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '1', '1', '1', '0', '0', '2', '0', '0', '1', '0', '', '', '', '', '', '0', '', '0', '1', '0', '2', '-1', '', '-1', '1', '15', '-1', '1', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 12:02', '200', '-1', '-1', '-1', '-1', '-1', '140', '60', '10', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '12', '6', '0', '1', '1', '', '', '04-12-2017 12:03', '04-12-2017 12:03', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:03', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(13, '101011010013', '', 'nn', '', '9465575575', '0', '1-1-1963', '0', 'nnn', 'TestVillage1', '', 'F', '04-12-2017', '54', '2', '848545755575', 'N', '0', '0', '0', '0', '0', '1', '1', '1', '1', '1', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'mtcn', '4-12-2017', 'mtcn', '0', '0', 'mtcn', '1', '4-12-2017', 'bscn', '4-12-2017', 'bscn', '0', '1', 'bscn', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '1', '0', '0', '0', '0', '2', '0', '1', '0', '0', '0', '', '', '', '', '', '1', '', '0', '0', '1', '4', '-1', '', '-1', '-1', '', '-1', '1', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 12:04', '200', '-1', '-1', '-1', '-1', '-1', '148', '65', '11', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '13', '6', '0', '1', '1', '', '', '04-12-2017 12:05', '04-12-2017 12:05', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:04', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(14, '101011010014', '', 'oo', '', '5455454854', '0', '1-1-1959', '0', 'ooo', 'TestVillage1', '', 'M', '04-12-2017', '58', '2', '554554848845', 'Y', '0', '0', '0', '1', '1', '0', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '1', '4-12-2017', 'hbp', '4-12-2017', 'hnp', '1', '1', 'hbp', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '1', '4-12-2017', 'copd', '4-12-2017', 'copd', '0', '1', 'copr', '0', '0', '0', '', '0', '1', '3', '0', '0', '0', '0', '0', '1', '0', '1', '', '', '', '', '', '1', '', '1', '1', '0', '1', '0', '', '1', '-1', '', '-1', '0', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 12:06', '200', '-1', '-1', '-1', '-1', '-1', '142', '78', '15', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '14', '6', '1', '1', '1', '', '', '04-12-2017 12:07', '04-12-2017 12:07', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:07', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(15, '101011010015', '', 'pp', '', '6425484646', '0', '1-1-1958', '0', 'pp9', 'TestVillage1', '', 'F', '04-12-2017', '59', '2', '545548642425', 'N', '1', '1', '0', '0', '0', '0', '0', '1', '1', '1', '0', '0', '0', '0', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'dbt', '4-12-2017', 'dbt', '0', '1', 'db5', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'crcn', '4-12-2017', 'crcn', '0', '1', 'crcn', '0', '', '', '', '', '', '', '', '0', '1', '2', '', '0', '0', '0', '1', '0', '0', '2', '0', '0', '1', '0', '', '', '', '', '', '1', '', '1', '1', '1', '4', '-1', '', '-1', '-1', '', '-1', '1', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 12:08', '200', '-1', '-1', '-1', '-1', '-1', '142', '65', '13', '2', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '15', '1', '0', '1', '1', '', '', '04-12-2017 12:09', '04-12-2017 12:09', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:09', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '10', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '3', '1'),
	(16, '101011010016', '', 'qq', '', '8752454854', '0', '1-1-1955', '0', 'qqq', 'TestVillage1', '', 'M', '04-12-2017', '62', '2', '848458454664', 'N', '1', '1', '0', '0', '0', '0', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'mtcn', '4-12-2017', 'mtcn', '0', '0', 'mtcn', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '1', '4-12-2017', 'copd', '4-12-2017', 'copd', '0', '0', 'copd', '0', '1', '2', '', '0', '1', '2', '0', '0', '0', '0', '1', '1', '0', '0', '', '', '', '', '', '0', '', '0', '1', '0', '1', '1', '25', '-1', '-1', '', '-1', '0', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 12:11', '200', '-1', '-1', '-1', '-1', '-1', '140', '72', '11', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '16', '6', '1', '1', '1', '', '', '04-12-2017 12:11', '04-12-2017 12:11', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:11', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', 'Strongly advice to stop smoking', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(17, '101011010017', '', 'rr', '', '9785487577', '0', '1-1-1920', '0', 'rrr', 'TestVillage1', '', 'M', '04-12-2017', '97', '2', '854548545546', 'N', '0', '0', '0', '1', '1', '1', '1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '1', '4-12-2017', 'copd', '4-12-2017', 'copd', '0', '0', 'copd', '1', '0', '0', '', '1', '0', '0', '0', '2', '2', '0', '1', '0', '0', '0', '', '', '', '', '', '1', '', '0', '0', '0', '3', '0', '', '0', '0', '', '0', '0', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 12:12', '200', '-1', '-1', '-1', '-1', '-1', '142', '68', '12', '4', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '17', '6', '0', '1', '1', '', '', '04-12-2017 12:13', '04-12-2017 12:13', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:13', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(18, '101011010018', '', 'ss', '', '9848884845', '0', '1-1-1963', '0', 'sss', 'TestVillage1', '', 'F', '04-12-2017', '54', '2', '885555554449', 'N', '0', '0', '0', '0', '1', '1', '1', '1', '1', '1', '1', '1', '0', '0', '1', '4-12-2017', 'hbp', '4-12-2017', 'hnp', '0', '0', 'hbp', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'copd', '4-12-2017', 'copd', '0', '0', 'copr', '0', '0', '0', '', '0', '1', '2', '0', '0', '0', '0', '0', '0', '0', '1', '', '', '', '', '', '1', '', '1', '1', '1', '4', '-1', '', '-1', '-1', '', '-1', '1', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '1', '80', '0', '04-12-2017 12:15', '200', '-1', '-1', '-1', '-1', '-1', '145', '68', '12', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '18', '6', '0', '1', '1', '', '', '04-12-2017 12:15', '04-12-2017 12:15', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:15', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '1', '6', 'CVD or one or more clinically high risk condition is present, Absolute risk screening recommended once every 3-6 months', '1', '1', '-1', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', 'Need to visit the doctor for the following:\nDiabetes is present. CVD is present.', '3', '1'),
	(19, '101011010019', '', 'tt', '', '8785464664', '0', '1-1-1958', '0', 'ttt', 'TestVillage1', '', 'M', '04-12-2017', '59', '1', '444554664646', 'N', '1', '1', '1', '0', '0', '0', '0', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '1', '4-12-2017', 'mtcn', '4-12-2017', 'mtcn', '0', '0', 'mtcn', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', '', '', '1', '', '0', '0', '0', '4', '-1', '', '-1', '-1', '', '-1', '0', '0', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 12:16', '200', '-1', '-1', '-1', '-1', '-1', '142', '63', '15', '3', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '19', '1', '0', '1', '1', '', '', '04-12-2017 12:17', '04-12-2017 12:17', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:17', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '10', '3', 'Absolute risk is < 10%. Absolute risk screening recommended once every 5 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '3', '1'),
	(20, '101011010020', '', 'vv', '', '8649645486', '0', '1-1-1952', '0', 'vvv', 'TestVillage1', '', 'M', '04-12-2017', '65', '2', '748546466464', 'Y', '0', '0', '0', '0', '0', '1', '1', '-1', '-1', '-1', '-1', '-1', '-1', '-1', '1', '4-12-2017', 'hbp', '4-12-2017', 'hbp', '0', '0', 'hnp', '1', '4-12-2017', 'dbt', '4-12-2017', 'dbt', '1', '1', 'dbt', '0', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '-1', '', '', '', '', '', '', '', '0', '', '', '', '', '', '', '', '0', '0', '0', '', '0', '0', '0', '1', '0', '0', '4', '0', '0', '1', '1', '', '', '', '', '', '1', '', '0', '0', '0', '2', '-1', '', '-1', '1', '35', '-1', '0', '1', '120', '80', '120', '80', '120', '80', '80', '80', '80', '120', '80', '80', '0', '80', '0', '04-12-2017 12:18', '200', '-1', '-1', '-1', '-1', '-1', '135', '58', '13', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '{}', '{}', '{}', '{}', '0', '0', '0', '0', '', '', '', '', '0', '20', '2', '0', '1', '1', '', '', '04-12-2017 12:19', '04-12-2017 12:19', 'asha1', 'asha', '', 'SH_CVD_ASHA_SCREENING_1', '04-12-2017 12:19', 'SH_CVD_ASHA_SCREENING_1', 'phc1', 'asha1', 'Present', '-1', '10', '3', 'Absolute risk is 10% to < 20% , Absolute risk screening recommended once every 2 years', '0', '2', '-1', 'Need to visit the doctor for the following:\nDiabetes is present.', 'Need to visit the doctor for the following:\nDiabetes is present.', '3', '1');
/*!40000 ALTER TABLE `mainline_riskassess` ENABLE KEYS */;

-- Dumping structure for table laravel.mainline_riskassess2
CREATE TABLE IF NOT EXISTS `mainline_riskassess2` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` int(20) NOT NULL DEFAULT '0',
  `consent_num` varchar(100) NOT NULL DEFAULT '0',
  `first_name` varchar(200) NOT NULL DEFAULT '0',
  `sur_name` varchar(100) NOT NULL DEFAULT '0',
  `contact_num` varchar(100) NOT NULL DEFAULT '0',
  `shared_phone` varchar(50) NOT NULL DEFAULT '0',
  `dob` varchar(50) NOT NULL DEFAULT '0',
  `dob_unsure` varchar(50) NOT NULL DEFAULT '0',
  `address` text NOT NULL,
  `vill_name` varchar(200) NOT NULL DEFAULT '0',
  `locality` varchar(200) NOT NULL DEFAULT '0',
  `gender` varchar(200) NOT NULL DEFAULT '0',
  `doa` varchar(200) NOT NULL DEFAULT '0',
  `age` varchar(200) NOT NULL DEFAULT '0',
  `id_card` varchar(200) NOT NULL DEFAULT '0',
  `aadhar_num` varchar(200) NOT NULL DEFAULT '0',
  `state_insurance` varchar(200) NOT NULL DEFAULT '0',
  `breath_dlty` varchar(200) NOT NULL DEFAULT '0',
  `cough` varchar(200) NOT NULL DEFAULT '0',
  `bld_sputum` varchar(200) NOT NULL DEFAULT '0',
  `getg_seizures` varchar(200) NOT NULL DEFAULT '0',
  `dlty_open_mth` varchar(200) NOT NULL DEFAULT '0',
  `rashes_patches` varchar(200) NOT NULL DEFAULT '0',
  `chg_voice` varchar(200) NOT NULL DEFAULT '0',
  `lump_in_brst` varchar(200) NOT NULL DEFAULT '0',
  `bld_tinged_nple` varchar(200) NOT NULL DEFAULT '0',
  `diff_sizes_brts` varchar(200) NOT NULL DEFAULT '0',
  `bledg_bt_mensprd` varchar(200) NOT NULL DEFAULT '0',
  `atr_menopause` varchar(200) NOT NULL DEFAULT '0',
  `drg_intcrs` varchar(200) NOT NULL DEFAULT '0',
  `foul_dicrg` varchar(200) NOT NULL DEFAULT '0',
  `hbp` varchar(200) NOT NULL DEFAULT '0',
  `hbp_dt_invg` varchar(200) NOT NULL DEFAULT '0',
  `hbp_tst_rst` varchar(200) NOT NULL DEFAULT '0',
  `hbp_dt_diag` varchar(200) NOT NULL DEFAULT '0',
  `hbp_trt_phc_nm` varchar(200) NOT NULL DEFAULT '0',
  `hbp_trt_drg_avl` varchar(200) NOT NULL DEFAULT '0',
  `hbp_trt_ontrt` varchar(200) NOT NULL DEFAULT '0',
  `hbp_sdeffct` varchar(200) NOT NULL DEFAULT '0',
  `diag` varchar(200) NOT NULL DEFAULT '0',
  `diag_dt_invg` varchar(200) NOT NULL DEFAULT '0',
  `diag_tst_rst` varchar(200) NOT NULL DEFAULT '0',
  `diag_dt_diag` varchar(200) NOT NULL DEFAULT '0',
  `diag_trt_phc_nm` varchar(200) NOT NULL DEFAULT '0',
  `diag_trt_drg_avl` varchar(200) NOT NULL DEFAULT '0',
  `diag_trt_ontrt` varchar(200) NOT NULL DEFAULT '0',
  `diag_sdeffct` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_dt_invg` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_tst_rst` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_dt_diag` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_trt_phc_nm` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_trt_drg_avl` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_trt_ontrt` varchar(200) NOT NULL DEFAULT '0',
  `mth_cn_sdeffct` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_dt_invg` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_tst_rst` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_dt_diag` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_trt_phc_nm` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_trt_drg_avl` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_trt_ontrt` varchar(200) NOT NULL DEFAULT '0',
  `brts_cn_sdeffct` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_dt_invg` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_tst_rst` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_dt_diag` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_trt_phc_nm` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_trt_drg_avl` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_trt_ontrt` varchar(200) NOT NULL DEFAULT '0',
  `cvr_cn_sdeffct` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_dt_invg` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_tst_rst` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_dt_diag` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_trt_phc_nm` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_trt_drg_avl` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_trt_ontrt` varchar(200) NOT NULL DEFAULT '0',
  `copd_dis_sdeffct` varchar(200) NOT NULL DEFAULT '0',
  `ph_hrtattack` varchar(200) NOT NULL DEFAULT '0',
  `ph_bp` varchar(200) NOT NULL DEFAULT '0',
  `ph_bp_since` varchar(200) NOT NULL DEFAULT '0',
  `ph_medication` varchar(200) NOT NULL DEFAULT '0',
  `ph_stroke` varchar(200) NOT NULL DEFAULT '0',
  `ph_pvd` varchar(200) NOT NULL DEFAULT '0',
  `ph_pvd_since` varchar(200) NOT NULL DEFAULT '0',
  `ph_diab` varchar(200) NOT NULL DEFAULT '0',
  `ph_hrtattack_since` varchar(200) NOT NULL DEFAULT '0',
  `ph_stroke_since` varchar(200) NOT NULL DEFAULT '0',
  `ph_diab_since` varchar(200) NOT NULL DEFAULT '0',
  `fh_hrtattack` varchar(200) NOT NULL DEFAULT '0',
  `fh_stroke` varchar(200) NOT NULL DEFAULT '0',
  `fh_diab` varchar(200) NOT NULL DEFAULT '0',
  `fh_hbp` varchar(200) NOT NULL DEFAULT '0',
  `rh_q1` varchar(200) NOT NULL DEFAULT '0',
  `rh_q2` varchar(200) NOT NULL DEFAULT '0',
  `rh_q2_yes` varchar(200) NOT NULL DEFAULT '0',
  `rh_q2_no` varchar(200) NOT NULL DEFAULT '0',
  `rh_ques2_if_other_reason` varchar(200) NOT NULL DEFAULT '0',
  `th_bp` varchar(200) NOT NULL DEFAULT '0',
  `th_bg` varchar(200) NOT NULL DEFAULT '0',
  `th_aptt` varchar(200) NOT NULL DEFAULT '0',
  `th_lltt` varchar(200) NOT NULL DEFAULT '0',
  `th_diab` varchar(200) NOT NULL DEFAULT '0',
  `tobacco_ques` varchar(200) NOT NULL DEFAULT '0',
  `sh_current` varchar(200) NOT NULL DEFAULT '0',
  `sh_agestarted` varchar(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`_id`),
  UNIQUE KEY `_id` (`_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table laravel.mainline_riskassess2: 0 rows
/*!40000 ALTER TABLE `mainline_riskassess2` DISABLE KEYS */;
/*!40000 ALTER TABLE `mainline_riskassess2` ENABLE KEYS */;

-- Dumping structure for table laravel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.migrations: ~2 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_07_02_230147_migration_cartalyst_sentinel', 1),
	(2, '2017_05_05_084634_PasswordReset', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table laravel.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table laravel.persistences
CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.persistences: ~0 rows (approximately)
/*!40000 ALTER TABLE `persistences` DISABLE KEYS */;
INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
	(2, 1, 'um6DrEbe3f3QXzaLq7JA1MewBHpvpfUw', '2017-05-15 09:59:33', '2017-05-15 09:59:33');
/*!40000 ALTER TABLE `persistences` ENABLE KEYS */;

-- Dumping structure for table laravel.reminders
CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.reminders: ~0 rows (approximately)
/*!40000 ALTER TABLE `reminders` DISABLE KEYS */;
/*!40000 ALTER TABLE `reminders` ENABLE KEYS */;

-- Dumping structure for table laravel.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.roles: ~2 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'Admin', '{"password.request":true,"password.email":true,"password.reset":true,"home.dashboard":true,"user.index":true,"user.create":true,"user.store":true,"user.show":true,"user.edit":true,"user.update":true,"user.destroy":true,"user.permissions":true,"user.save":true,"user.activate":true,"user.deactivate":true,"role.index":true,"role.create":true,"role.store":true,"role.show":true,"role.edit":true,"role.update":true,"role.destroy":true,"role.permissions":true,"role.save":true}', NULL, NULL),
	(2, 'client', 'client', '{"home.dashboard":true}', NULL, NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table laravel.role_users
CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.role_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;
INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL);
/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;

-- Dumping structure for table laravel.throttle
CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.throttle: ~2 rows (approximately)
/*!40000 ALTER TABLE `throttle` DISABLE KEYS */;
INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'global', NULL, '2017-05-15 09:59:20', '2017-05-15 09:59:20'),
	(2, NULL, 'ip', '::1', '2017-05-15 09:59:20', '2017-05-15 09:59:20'),
	(3, 1, 'user', NULL, '2017-05-15 09:59:20', '2017-05-15 09:59:20');
/*!40000 ALTER TABLE `throttle` ENABLE KEYS */;

-- Dumping structure for table laravel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_name` enum('admin','user') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table laravel.users: ~2 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `remember_token`, `deleted_at`, `created_at`, `updated_at`, `role_name`) VALUES
	(1, 'admin@admin.com', '$2y$10$qcCp05vp2KPxlxV1kFOZzuX.LkylyEMl50V.o2EvphzYZQWGpPMN.', '{"home.dashboard":true}', '2017-05-15 09:59:33', 'John', 'Doe', NULL, NULL, NULL, '2017-05-15 09:59:33', 'admin'),
	(2, 'test', '098f6bcd4621d373cade4e832627b4f6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
