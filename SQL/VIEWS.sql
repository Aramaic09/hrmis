CREATE OR REPLACE VIEW view_users AS
SELECT
	a.*,
	b.division_acro,
	c.employment_desc,
	f.id AS plantilla_id,f.plantilla_item_number,f.position_id,g.position_desc,f.designation_id,f.plantilla_step,f.plantilla_salary AS work_salary,f.plantilla_date_from,f.plantilla_special,f.plantilla_remarks,
	h.basicinfo_sex,h.basicinfo_civilstatus,
	DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(a.birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(a.birthdate, '00-%m-%d')) AS age,
	i.addinfo_atm
FROM
	users AS a
LEFT JOIN
	divisions AS b ON b.division_id = a.division
LEFT JOIN
	employments AS c ON c.employment_id = a.employment_id
LEFT JOIN
	plantillas AS f ON f.user_id = a.id
LEFT JOIN
	positions AS g ON g.position_id = f.position_id
LEFT JOIN
	employee_basicinfos AS h ON h.user_id = a.id
LEFT JOIN
	employee_addinfos AS i ON i.user_id = a.id
WHERE
	a.employment_id IN(1,13,14,15)
GROUP BY
		a.username

CREATE OR REPLACE VIEW view_archived_users AS
SELECT
	a.*,
	b.division_acro,
	c.employment_desc,
	f.id AS plantilla_id,f.plantilla_item_number,f.position_id,g.position_desc,f.designation_id,f.plantilla_step,f.plantilla_salary AS work_salary,f.plantilla_date_from,f.plantilla_special,f.plantilla_remarks,
	h.basicinfo_sex
FROM
	users AS a
LEFT JOIN
	divisions AS b ON b.division_id = a.division
LEFT JOIN
	employments AS c ON c.employment_id = a.employment_id
LEFT JOIN
	plantillas AS f ON f.user_id = a.id
LEFT JOIN
	positions AS g ON g.position_id = f.position_id
LEFT JOIN
	employee_basicinfos AS h ON h.user_id = a.id
WHERE
	a.employment_id IN(9,10,12);

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_users_with_age AS
SELECT
	a.id,a.lname,a.fname,a.mname,a.exname,a.division,a.birthdate,a.employment_id,a.sex,
	DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(a.birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(a.birthdate, '00-%m-%d')) AS age,
	(SELECT GROUP_CONCAT(`competency_desc` SEPARATOR ',') FROM employee_competencies WHERE user_id = a.id) AS competencies,
	(SELECT )
FROM users AS a
WHERE
	a.employment_id IN(1,13,14,15);

/*----------------------------------------------------------------------*/


CREATE OR REPLACE VIEW view_division_retiree AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM view_users_with_age WHERE division = a.division_id AND age >= 60 AND age <= 65 GROUP BY division) AS total
FROM
	divisions AS a;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_employee_position AS
SELECT
	a.id,a.lname,a.fname,a.mname,a.exname,a.division,
	b.plantilla_item_number,b.position_id,
	c.position_desc,c.position_class,a.username,b.plantilla_date_to,b.plantilla_salary
FROM 
	users AS a
LEFT JOIN
	plantillas AS b ON a.id = b.user_id
LEFT JOIN
	positions AS c ON b.position_id = c.position_id
WHERE
	a.employment_id IN(1,13,14,15)
	AND
	a.deleted_at IS NULL
	AND
	b.deleted_at IS NULL;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_users_temps AS
SELECT
	a.*,
	b.division_acro,
	c.employment_desc,
	f.designation_id,
	e.designation_desc,
	f.position_id,g.position_desc,f.workexp_salary AS work_salary
FROM
	users AS a
LEFT JOIN
	divisions AS b ON b.division_id = a.division
LEFT JOIN
	employments AS C ON c.employment_id = a.employment_id
LEFT JOIN
	employee_temp_positions AS f ON f.user_id = a.id
LEFT JOIN
	designations AS e ON e.designation_id = f.designation_id
LEFT JOIN
	positions AS g ON g.position_id = f.position_id
WHERE
	a.employment_id IN(5,6,7,8);

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_employee_training AS
SELECT
	a.training_title,a.training_type,a.training_amount,a.training_inclusive_dates,a.training_date_from,a.training_hours,a.training_ld,a.training_conducted_by,
	CONCAT(b.lname,", ",b.fname," ",b.mname) AS fullname,
	c.division_acro

FROM 
	employee_trainings AS a
LEFT JOIN
	users AS b ON a.user_id = b.id
LEFT JOIN
	divisions AS c ON a.division_id = c.division_id;


/*----------------------------------------------------------------------*/


-- CREATE OR REPLACE VIEW view_all_users AS
-- SELECT
-- 	a.*,
-- 	b.division_acro,
-- 	c.employment_desc,
-- 	f.designation_id,
-- 	e.designation_desc,
-- 	f.position_id,f.workexp_salary AS work_salary
-- FROM
-- 	users AS a
-- LEFT JOIN
-- 	divisions AS b ON b.division_id = a.division
-- LEFT JOIN
-- 	employments AS C ON c.employment_id = a.employment_id
-- LEFT JOIN
-- 	employee_temp_positions AS f ON f.user_id = a.id
-- LEFT JOIN
-- 	designations AS e ON e.designation_id = f.designation_id
-- LEFT JOIN
-- 	positions AS g ON g.position_id = f.designation_id
-- WHERE
-- 	a.employment_id NOT IN(9,10,12);

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_plantillas AS
SELECT
	a.*,
	b.division_acro,
	c.position_desc
FROM
	plantillas AS a
LEFT JOIN
	divisions AS b ON b.division_id = a.plantilla_division
LEFT JOIN
	positions AS c ON c.position_id = a.position_id;

/*----------------------------------------------------------------------*/


CREATE OR REPLACE VIEW view_plantilla_histories AS
SELECT
	a.plantilla_item_number,a.plantilla_salary,a.plantilla_date_from,a.plantilla_date_to,a.username,
	b.employment_desc,c.position_desc,a.deleted_at
FROM
	plantillas_histories AS a
LEFT JOIN
	employments AS b ON b.employment_id = a.employment_id
LEFT JOIN
	positions AS c ON c.position_id = a.position_id
ORDER BY plantilla_date_from ASC;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_vacant_plantillas AS
SELECT
	a.*,
	b.position_desc,c.division_acro,
	d.shortlisted_fad,d.shortlisted_div,d.request_status
FROM
	vacant_plantillas AS a
LEFT JOIN
	positions AS b ON b.position_id = a.position_id
LEFT JOIN
	divisions AS c ON c.division_id= a.division_id
LEFT JOIN
	request_for_hirings AS d ON d.plantilla_id = a.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_position_class_admin_by_division AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_class = 'Administrative' AND division = a.division_id) AS total
FROM
	divisions AS a;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_position_class AS
SELECT
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id IN(SELECT position_id FROM positions WHERE position_class = 'Administrative')) AS total_admin,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id IN(SELECT position_id FROM positions WHERE position_class = 'Technical')) AS total_technical,
	(SELECT COUNT(id) FROM vacant_plantillas WHERE deleted_at IS NULL) AS total_vacant
FROM
	position_class AS a
LIMIT 1;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_trainings AS
SELECT
	a.division_acro,
	(SELECT COUNT(id) FROM employee_trainings WHERE division_id = a.division_id AND training_type = 'Free' AND YEAR(training_date_from) >= 2015 GROUP BY division_id) AS total_training_free,
	(SELECT COUNT(id) FROM employee_trainings WHERE division_id = a.division_id AND training_type = 'Funded' AND YEAR(training_date_from) >= 2015 GROUP BY division_id) AS total_training_funded
FROM
	divisions AS a
WHERE
	deleted_at IS NULL;


/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_vacant_position_by_division AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM vacant_plantillas WHERE division_id = a.division_id) AS total
FROM
	divisions AS a;


/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_position_class_admin AS
SELECT
	a.position_id,a.position_desc,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id = a.position_id) AS total
FROM
	positions AS a
WHERE
	position_class = 'Administrative';

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_position_class_technical AS
SELECT
	a.position_id,a.position_desc,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id = a.position_id) AS total
FROM
	positions AS a
WHERE
	position_class = 'Technical';

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_total_position_class_technical_by_division AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_class = 'Technical' AND division = a.division_id) AS total
FROM
	divisions AS a;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_request_leaves AS
SELECT
	a.*,
	CONCAT(b.lname,', ',b.fname,' ',b.mname) AS fullname,
	c.leave_desc,
	b.usertype,b.division
FROM
	request_leaves AS a
LEFT JOIN
	users AS b ON a.user_id = b.id
LEFT JOIN
	leave_types AS c ON a.leave_id = c.id
WHERE
	a.deleted_at IS NULL;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_employee_add_permanent AS
SELECT
	a.*,
	b.brgy_desc,c.mun_desc,d.prov_desc
FROM
	employee_address_permanents AS a
LEFT JOIN
	location_barangays AS b ON a.permanent_add_brgy = b.id
LEFT JOIN
	location_municipals AS c ON a.permanent_add_mun = c.id
LEFT JOIN
	location_provinces AS d ON a.permanent_add_prov = d.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_employee_add_residential AS
SELECT
	a.*,
	b.brgy_desc,c.mun_desc,d.prov_desc
FROM
	employee_address_residentials AS a
LEFT JOIN
	location_barangays AS b ON a.residential_add_brgy = b.id
LEFT JOIN
	location_municipals AS c ON a.residential_add_mun = c.id
LEFT JOIN
	location_provinces AS d ON a.residential_add_prov = d.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_employee_education AS
SELECT
	a.*,
	b.division_acro,
	DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(a.birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(a.birthdate, '00-%m-%d')) AS age,
	(SELECT educ_level FROM employee_educations WHERE user_id = a.id ORDER BY educ_date_from DESC LIMIT 1) AS educ_level,
	(SELECT educ_course FROM employee_educations WHERE user_id = a.id ORDER BY educ_date_from DESC LIMIT 1) AS educ_course
FROM
	users AS a
LEFT JOIN
	divisions AS b ON b.division_id = a.division
WHERE
	a.employment_id NOT IN(9,10,12);

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_job_applications AS
SELECT
	b.*,
	a.request_id,a.vacant_plantilla_id,a.remarks,a.fad_shortlisted,a.div_shortlisted,a.hired,a.pcaarrd,
	c.plantilla_item_number,c.position_id,c.division_id,c.plantilla_salary,c.plantilla_special,c.plantilla_steps,
	d.position_desc
FROM
	applicant_position_applies AS a
LEFT JOIN
	applicants AS b ON b.id = a.applicant_id
LEFT JOIN
	vacant_plantillas AS c ON c.id = a.vacant_plantilla_id
LEFT JOIN
	positions AS d ON d.position_id = c.position_id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_for_pdf_invitations AS
SELECT
	a.*,
	b.lname,b.fname,b.mname,b.position_desc,
	c.division_acro
FROM
	invitations AS a
LEFT JOIN
	view_users AS b ON b.id = a.user_id
LEFT JOIN
	divisions AS c ON c.division_id = b.division;


/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_submission_lists AS
SELECT
	a.*,
	b.id AS submission_list_id,b.submission_division,b.submission_file,b.submission_division_datesubmitted
FROM
	submissions AS a
LEFT JOIN
	submission_lists AS b ON b.submission_id = a.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_training_temps AS
SELECT
	a.*
FROM
	employee_training_temps AS a;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_hrd_divisions AS
SELECT
	a.*,
	b.hrd_year,b.hrd_deadline,b.hrd_status
FROM
	h_r_d_plan_divisions AS a
LEFT JOIN
	h_r_d_plans AS b ON b.id = a.hrd_plan_id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_hrd_hrdcs AS
SELECT
	a.*,
	CONCAT(b.lname,', ',b.fname) AS fullname,
	c.hrd_year,c.hrd_deadline,c.hrd_status,c.file_consolidated,c.file_consolidated_uploaded
FROM
	h_r_d_hrdcs AS a
LEFT JOIN
	users AS b ON b.id = a.hrdc_member_id
LEFT JOIN
	h_r_d_plans AS c ON a.hrd_plan_id = c.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_hrd_plan_degrees AS
SELECT
	a.*,b.submitted_at,
	CONCAT(c.lname,', ',c.fname,' ',c.mname) AS fullname,
	c.position_desc
FROM
	h_r_d_plan_degrees AS a
LEFT JOIN
	h_r_d_plan_divisions AS b ON a.hrd_plan_division_id = b.id
LEFT JOIN
	view_users AS c ON a.user_id = c.id;


/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_hrd_plan_non_degrees AS
SELECT
	a.*,
	b.division_id,b.division_acro,b.submitted_at,
	CONCAT(c.lname,', ',c.fname,' ',c.mname) AS fullname,
	c.position_desc,
	d.hrd_status
FROM
	h_r_d_plan_non_degrees AS a
LEFT JOIN
	h_r_d_plans AS d ON d.id = a.hrd_plan_id
LEFT JOIN
	h_r_d_plan_divisions AS b ON a.hrd_plan_division_id = b.id
LEFT JOIN
	view_users AS c ON a.user_id = c.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_hrd_plan_non_degrees_areas AS
SELECT
	a.*,
	b.areas_of_discipline
FROM
	h_r_d_plan_non_degrees AS a
LEFT JOIN
	h_r_d_plan_non_degree_areas AS b ON a.id = b.hrd_plan_non_degrees_id
LEFT JOIN
	h_r_d_plan_divisions AS c ON a.hrd_plan_division_id = c.id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_performace_ipcr_staffs AS
SELECT
	a.*,
	b.ipcr_year,b.ipcr_period
FROM
	performance_ipcr_staffs AS a
LEFT JOIN
	performance_ipcrs AS b ON b.id = a.dpcr_id;

/*----------------------------------------------------------------------*/

-- CREATE OR REPLACE VIEW view_performance_group_ipcr_staffs AS
-- SELECT
-- 	a.ipcr_year,a.ipcr_period,a.ipcr_deadline
-- FROM
-- 	performance_ipcr_staffs AS a
-- GROUP BY
-- 	ipcr_year,ipcr_period,ipcr_deadline;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_performance_group_dpcrs AS
SELECT
	a.dpcr_year,a.dpcr_period,a.dpcr_deadline,a.dpcr_score,a.dpcr_file_path
FROM
	performance_dpcrs AS a
GROUP BY
	dpcr_year,dpcr_period,dpcr_deadline;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_performance_group_dpcr_ipcrs AS
SELECT
	b.dpcr_year,b.dpcr_period,b.dpcr_score,b.dpcr_deadline,b.dpcr_file_path,
	a.*
FROM
	performance_ipcr_staffs AS a
LEFT JOIN
	performance_dpcrs AS b ON b.id = a.dpcr_id;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_performance_dpcr_ipcr_counts AS
SELECT
	a.*,
	(SELECT COUNT(id) FROM performance_ipcr_staffs WHERE dpcr_id = a.id AND ipcr_submitted_at IS NOT NULL) AS submitted,
	(SELECT COUNT(id) FROM performance_ipcr_staffs WHERE dpcr_id = a.id) AS total
FROM
	performance_dpcrs AS a;

/*----------------------------------------------------------------------*/

CREATE OR REPLACE VIEW view_leave_list AS
SELECT
	a.id,a.leave_acro
FROM
	leave_types AS a;



-- FOR DASHBOARD ----

CREATE OR REPLACE VIEW view_dashboard_training_division AS
SELECT
	a.division_id,
	a.division_acro,
	(SELECT COUNT(id) FROM employee_trainings WHERE training_type = 'Free' AND division_id = a.division_id) AS training_free,
	(SELECT COUNT(id) FROM employee_trainings WHERE training_type = 'Funded' AND division_id = a.division_id) AS training_funded,
	(SELECT COUNT(id) FROM employee_trainings WHERE training_type = 'Personal' AND division_id = a.division_id) AS training_personal
FROM
	divisions AS a
WHERE
	a.deleted_at IS NULL
ORDER BY a.division_acro


CREATE OR REPLACE VIEW view_dashboard_sexes AS
SELECT
	(SELECT COUNT(id) FROM users WHERE sex = 'Male' AND employment_id IN(1,8,13,14)) AS total_male,
	(SELECT COUNT(id) FROM users WHERE sex = 'Female' AND employment_id IN(1,8,13,14)) AS total_female
FROM
	users
LIMIT 1

CREATE OR REPLACE VIEW view_dashboard_educ AS
SELECT
	(SELECT COUNT(id) FROM view_employee_education WHERE educ_level = 4) AS total_bs,
	(SELECT COUNT(id) FROM view_employee_education WHERE educ_level = 5) AS total_ms,
	(SELECT COUNT(id) FROM view_employee_education WHERE educ_level = 6) AS total_phd
FROM
	users
LIMIT 1

CREATE OR REPLACE VIEW view_dashboard_educ_division AS
SELECT
	a.division_id,
	a.division_acro,
	(SELECT COUNT(id) FROM view_employee_education WHERE educ_level = 4 AND division = a.division_id) AS educ_division_bs,
	(SELECT COUNT(id) FROM view_employee_education WHERE educ_level = 5 AND division = a.division_id) AS educ_division_ms,
	(SELECT COUNT(id) FROM view_employee_education WHERE educ_level = 6 AND division = a.division_id) AS educ_division_phd
FROM
	divisions AS a
WHERE
	a.deleted_at IS NULL
ORDER BY a.division_acro


-- UPDATE USER sex
UPDATE hrmisdb.users AS a
INNER JOIN employeedb2.tblempinfo b ON a.username = b.fldEmpCode
SET a.sex = if(b.fldSexID = 1, 'Male', 'Female')

-- UPDATE WORK SCHEDULE
UPDATE employee_dtrs SET dtr_option_id = 1 WHERE (YEAR(fldEmpDTRdate) BETWEEN 2007 AND 2019);
UPDATE employee_dtrs SET dtr_option_id = 7 WHERE (fldEmpDTRdate  BETWEEN '2020-03-17' AND '2020-05-24');
UPDATE employee_dtrs SET dtr_option_id = 6 WHERE (fldEmpDTRdate  BETWEEN '2020-05-24' AND '2021-02-28');
UPDATE employee_dtrs SET dtr_option_id = 1 WHERE (fldEmpDTRdate  BETWEEN '2021-03-01' AND '2021-03-21');
UPDATE employee_dtrs SET dtr_option_id = 8 WHERE (fldEmpDTRdate  BETWEEN '2021-03-22' AND '2021-03-28');
UPDATE employee_dtrs SET dtr_option_id = 5 WHERE (fldEmpDTRdate  BETWEEN '2021-03-29' AND '2021-04-30');


CREATE OR REPLACE VIEW view_dashboard_age_ranges AS
SELECT
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Male' AND age <= 20) AS 20_below_male,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Male' AND age BETWEEN 21 AND 30) AS 21_30_male,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Male' AND age BETWEEN 31 AND 40) AS 31_40_male,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Male' AND age BETWEEN 41 AND 50) AS 41_50_male,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Male' AND age BETWEEN 51 AND 60) AS 51_60_male,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Male' AND age BETWEEN 61 AND 65) AS above_60_male,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Female' AND age <= 20) AS 20_below_female,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Female' AND age BETWEEN 21 AND 30) AS 21_30_female,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Female' AND age BETWEEN 31 AND 40) AS 31_40_female,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Female' AND age BETWEEN 41 AND 50) AS 41_50_female,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Female' AND age BETWEEN 51 AND 60) AS 51_60_female,
	(SELECT COUNT(id) FROM view_users_with_age WHERE sex = 'Female' AND age BETWEEN 61 AND 65) AS above_60_female
FROM
	users
LIMIT 1

CREATE OR REPLACE VIEW view_dashboard_class AS
SELECT
	(SELECT COUNT(id) FROM view_employee_position_current WHERE position_class = 'Administrative' GROUP BY position_class) AS class_admin,
	(SELECT COUNT(id) FROM view_employee_position_current WHERE position_class = 'Technical' GROUP BY position_class) AS class_tech,
FROM
	users
LIMIT 1

-- FOR JOOMLA
CREATE OR REPLACE VIEW view_dashboard_class AS
SELECT
	a.description AS description_class,
	(SELECT COUNT(id) FROM hrmisdb2.view_employee_position_current WHERE position_class = a.description GROUP BY position_class) AS total
FROM
	hrmisdb2.position_classification AS a


CREATE TABLE temp_table_class AS
SELECT
	a.description AS description_class,
	(SELECT COUNT(id) FROM hrmisdb2.view_employee_position_current WHERE position_class = a.description GROUP BY position_class) AS total
FROM
	hrmisdb2.position_classification AS a


CREATE OR REPLACE VIEW view_employee_position_current AS
SELECT
	a.id,a.lname,a.fname,a.mname,a.username,a.division,
	(SELECT plantilla_item_number FROM view_employee_position WHERE id = a.id ORDER BY plantilla_date_to LIMIT 1) AS plantilla_item_number,
	(SELECT plantilla_salary FROM view_employee_position WHERE id = a.id ORDER BY plantilla_date_to LIMIT 1) AS plantilla_salary,
	(SELECT position_class FROM view_employee_position WHERE id = a.id ORDER BY plantilla_date_to LIMIT 1) AS position_class,
	(SELECT position_desc FROM view_employee_position WHERE id = a.id ORDER BY plantilla_date_to LIMIT 1) AS position_desc
FROM
	view_users AS a


SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

CREATE OR REPLACE VIEW view_dashboard_class_division AS
SELECT
	a.division_id,
	a.division_acro,
	(SELECT COUNT(position_class) FROM view_employee_position_current WHERE position_class = 'Administrative' AND division = a.division_id GROUP BY position_class) AS class_division_admin,
	(SELECT COUNT(position_class) FROM view_employee_position_current WHERE position_class = 'Technical' AND division = a.division_id GROUP BY position_class) AS class_division_tech
FROM
	divisions AS a
WHERE
	a.deleted_at IS NULL
ORDER BY a.division_acro


CREATE OR REPLACE VIEW view_dashboard_class_position AS
SELECT
	a.*
FROM
	view_employee_position_current AS a
GROUP BY
	position_desc
	





CREATE OR REPLACE VIEW view_users_years_service AS
SELECT
	a.id,a.lname,a.fname,a.mname,a.exname,a.username,a.division,
	DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(a.fldservice, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(a.fldservice, '00-%m-%d')) AS years_service
FROM users AS a
WHERE
	a.employment_id IN(1,13,14,15)
AND
	a.usertype NOT IN('Administrator');


-- CORE COMPETENY

CREATE OR REPLACE VIEW view_core_division_competencies AS
SELECT
	a.core_desc,a.division,
	(SELECT GROUP_CONCAT(CONCAT(fname,' ',lname) SEPARATOR ', ') FROM users WHERE id IN(SELECT user_id FROM employee_competencies WHERE competency_desc = a.core_desc)) AS employees
FROM core_competencies AS a

---WORK SCHEDULE
UPDATE employee_dtrs
SET dtr_option_id = 8
WHERE
	(fldEmpDTRdate BETWEEN '2021-05-01' AND '2021-05-21')

CREATE OR REPLACE VIEW view_work_schedules AS
SELECT
	a.*,
	b.fldDTROptDesc
FROM work_schedules AS a
LEFT JOIN
	d_t_r_options AS b ON a.dtr_option_id = b.id

-- INSERT DTR
INSERT INTO employee_dtrs (fldEmpCode, fldEmpDTRdate ,fldEmpDTRamIn,fldEmpDTRamOut,fldEmpDTRpmIn,fldEmpDTRpmOut,photo_am_in,photo_am_out,photo_pm_in,photo_pm_out,photo_ot_in,photo_ot_out,created_at,updated_at)
SELECT fldEmpCode, fldEmpDTRdate ,fldEmpDTRamIn,fldEmpDTRamOut,fldEmpDTRpmIn,fldEmpDTRpmOut,photo_am_in,photo_am_out,photo_pm_in,photo_pm_out,photo_ot_in,photo_ot_out,created_at,updated_at
FROM  tblempdtr
WHERE
	YEAR(fldEmpDTRdate) >= 2016

UPDATE employee_dtrs AS a
INNER JOIN users b ON a.fldEmpCode = b.username
SET a.division = b.division,a.user_id = b.id,a.employee_name = CONCAT(b.lname,', ',b.fname,' ',b.mname)



-- SELECT INSERT LEAVE BALANCE
INSERT INTO employee_leaves (leave_id, empcode, leave_bal_prev,leave_bal,leave_bal_nega,created_at)
SELECT fldLeaveTypeID , fldEmpCode, fldPrevBalance, fldBalance,fldNegative,fldDate
FROM  tblleavebalance;

UPDATE employee_leaves a
INNER JOIN users b ON a.empcode = b.username
SET user_id = b.id;

-- SELECT LEAVE SUMMARY
INSERT INTO d_t_r_processeds (empcode,dtr_mon,dtr_year,notardy,nolates,noabsent,excess,vl_totalunderlatededuc,vl_leave,vl_lwop,vl_earn,vl_bal,sl_leave,sl_lwop,sl_earn,sl_bal)
SELECT fldEmpCode,fldMonth,fldYear,fldTardyUnder,fldTallyLates,fldTallyAbsent,fldExcessHours,fldVLUsedTardy,fldVLUsedLeave,fldVLNoPayLeave,fldVLEarned,fldVLBalance,fldSLUsed,fldSLNoPay,fldSLEarned,fldSLBalance
FROM  tblsummary

UPDATE d_t_r_processeds a
INNER JOIN users b ON a.empcode = b.username
SET a.userid  = b.id,a.empcode = b.username


----UPDATE REQUEST
INSERT INTO request_leaves (empcode,leave_id,created_at,leave_date_from,leave_date_to,fldAM_PM_WD)
SELECT fldEmpCode,fldLeaveTypeID,fldAppDate,fldFromDate,fldToDate,fldAM_PM_WD
FROM  camsonline2.tblempleave

UPDATE request_leaves a
INNER JOIN request_leaves b ON a.id = b.id
SET a.leave_deduction_time = 
		CASE
          WHEN a.fldAM_PM_WD = '1' THEN 'wholeday'
          WHEN a.fldAM_PM_WD = '2' THEN 'AM'
          ELSE 'PM'
      END,
    a.leave_deduction = 
		CASE
          WHEN a.fldAM_PM_WD = '1' THEN 1
          ELSE 0.5
      END

UPDATE request_leaves a
INNER JOIN users b ON a.empcode = b.username
SET a.user_id  = b.id,a.empcode = b.username,a.user_div = b.division


--UPDATE PLANTILLA
UPDATE plantillas a
INNER JOIN users b ON a.username = b.username
SET a.user_id  = b.id

---------UPDATE TRANING
UPDATE employee_trainings a
INNER JOIN users b ON a.username = b.username
SET 
	a.user_id  = b.id

---------UPDATE WORK
UPDATE employee_works a
INNER JOIN users b ON a.username = b.username
SET a.user_id  = b.id


---------UPDATE DTR PROCESSED
UPDATE d_t_r_processeds a
INNER JOIN users b ON a.empcode = b.username
SET a.dtr_division  = b.division





