CREATE OR REPLACE VIEW view_users AS
SELECT
	a.*,
	b.division_acro,
	c.employment_desc,
	f.id AS plantilla_id,f.plantilla_item_number,f.position_id,g.position_desc,f.designation_id,f.plantilla_step,f.plantilla_salary AS work_salary,f.plantilla_date_from,f.plantilla_special,f.plantilla_remarks

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
WHERE
	a.employment_id NOT IN(5,6,7,8);

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_division_retiree AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM view_users_with_age WHERE division = a.division_id AND age >= 60 AND age <= 65 GROUP BY division) AS total
FROM
	divisions AS a

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_employee_position AS
SELECT
	a.id,a.lname,a.fname,a.mname,a.exname,a.division,
	b.plantilla_item_number,b.position_id,
	c.position_desc,c.position_class
FROM 
	users AS a
LEFT JOIN
	plantillas AS b ON a.id = b.user_id
LEFT JOIN
	positions AS c ON b.position_id = c.position_id
WHERE
	a.employment_id IN(1,13,14,15)
	AND
	a.deleted_at IS NULL;

----------------------------------------------------------------------

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

----------------------------------------------------------------------

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


----------------------------------------------------------------------


CREATE OR REPLACE VIEW view_all_users AS
SELECT
	a.*,
	b.division_acro,
	c.employment_desc,
	f.designation_id,
	e.designation_desc,
	f.position_id,f.workexp_salary AS work_salary
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
	positions AS f ON f.position_id = f.designation_id
WHERE
	a.employment_id NOT IN(9,10,12);

----------------------------------------------------------------------

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

----------------------------------------------------------------------


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

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_vacant_plantillas AS
SELECT
	a.*,
	b.position_desc,c.division_acro,
	d.shortlisted_fad,d.shortlisted_div
FROM
	vacant_plantillas AS a
LEFT JOIN
	positions AS b ON b.position_id = a.position_id
LEFT JOIN
	divisions AS c ON c.division_id= a.division_id
LEFT JOIN
	request_for_hirings AS d ON d.plantilla_id= a.id;

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_position_class AS
SELECT
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id IN(SELECT position_id FROM positions WHERE position_class = 'Administrative')) AS total_admin,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id IN(SELECT position_id FROM positions WHERE position_class = 'Technical')) AS total_technical,
	(SELECT COUNT(id) FROM vacant_plantillas WHERE deleted_at IS NULL) AS total_vacant
FROM
	position_class AS a
LIMIT 1;

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_trainings AS
SELECT
	a.division_acro,
	(SELECT COUNT(id) FROM employee_trainings WHERE division_id = a.division_id AND training_type = 'Free' AND YEAR(training_date_from) >= 2015 GROUP BY division_id) AS total_training_free,
	(SELECT COUNT(id) FROM employee_trainings WHERE division_id = a.division_id AND training_type = 'Funded' AND YEAR(training_date_from) >= 2015 GROUP BY division_id) AS total_training_funded
FROM
	divisions AS a
WHERE
	deleted_at IS NULL

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_users_with_age AS
SELECT
	a.id,a.lname,a.fname,a.mname,a.exname,a.division,a.birthdate,a.employment_id,
	DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(a.birthdate, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(a.birthdate, '00-%m-%d')) AS age
FROM users AS a
WHERE
	a.employment_id IN(1,15)

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_vacant_position_by_division AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM vacant_plantillas WHERE division_id = a.division_id) AS total
FROM
	divisions AS a;

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_position_class_admin_by_division AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_class = 'Administrative' AND division = a.division_id) AS total
FROM
	divisions AS a;

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_position_class_admin AS
SELECT
	a.position_id,a.position_desc,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id = a.position_id) AS total
FROM
	positions AS a
WHERE
	position_class = 'Administrative';

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_position_class_technical AS
SELECT
	a.position_id,a.position_desc,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_id = a.position_id) AS total
FROM
	positions AS a
WHERE
	position_class = 'Technical'

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_total_position_class_technical_by_division AS
SELECT
	a.division_id,a.division_acro,
	(SELECT COUNT(id) FROM view_employee_position WHERE position_class = 'Technical' AND division = a.division_id) AS total
FROM
	divisions AS a

----------------------------------------------------------------------

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
	a.deleted_at IS NULL

----------------------------------------------------------------------

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

----------------------------------------------------------------------

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

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_employee_education AS
SELECT
	a.*,
	b.division_acro,
	(SELECT educ_level FROM employee_educations WHERE user_id = a.id ORDER BY educ_date_from DESC LIMIT 1) AS educ_level,
	(SELECT educ_course FROM employee_educations WHERE user_id = a.id ORDER BY educ_date_from DESC LIMIT 1) AS educ_course
FROM
	users AS a
LEFT JOIN
	divisions AS b ON b.division_id = a.division
WHERE
	a.employment_id NOT IN(9,10,12);

----------------------------------------------------------------------

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
	positions AS d ON d.position_id = c.position_id

----------------------------------------------------------------------

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
	divisions AS c ON c.division_id = b.division


----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_submission_lists AS
SELECT
	a.*,
	b.id AS submission_list_id,b.submission_division,b.submission_file,b.submission_division_datesubmitted
FROM
	submissions AS a
LEFT JOIN
	submission_lists AS b ON b.submission_id = a.id

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_training_temps AS
SELECT
	a.*
FROM
	employee_training_temps AS a

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_hrd_divisions AS
SELECT
	a.*,
	b.hrd_year,b.hrd_deadline,b.hrd_status
FROM
	h_r_d_plan_divisions AS a
LEFT JOIN
	h_r_d_plans AS b ON b.id = a.hrd_plan_id

----------------------------------------------------------------------

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
	h_r_d_plans AS c ON a.hrd_plan_id = c.id

----------------------------------------------------------------------

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
	view_users AS c ON a.user_id = c.id 


----------------------------------------------------------------------

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
	view_users AS c ON a.user_id = c.id 

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_hrd_plan_non_degrees_areas AS
SELECT
	a.*,
	b.areas_of_discipline,
	c.hrd_plan_id
FROM
	h_r_d_plan_non_degrees AS a
LEFT JOIN
	h_r_d_plan_non_degree_areas AS b ON a.id = b.hrd_plan_non_degrees_id
LEFT JOIN
	h_r_d_plan_divisions AS c ON a.hrd_plan_division_id = c.id

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_performace_ipcr_staffs AS
SELECT
	a.*,
	b.ipcr_year,b.ipcr_period
FROM
	performance_ipcr_staffs AS a
LEFT JOIN
	performance_ipcrs AS b ON b.id = a.ipcr_id

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_performance_group_ipcr_staffs AS
SELECT
	a.ipcr_year,a.ipcr_period,a.ipcr_deadline
FROM
	performance_ipcr_staffs AS a
GROUP BY
	ipcr_year,ipcr_period,ipcr_deadline

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_performance_group_dpcrs AS
SELECT
	a.dpcr_year,a.dpcr_period,a.dpcr_deadline
FROM
	performance_dpcrs AS a
GROUP BY
	dpcr_year,dpcr_period,dpcr_deadline

----------------------------------------------------------------------

CREATE OR REPLACE VIEW view_performance_group_dpcr_ipcrs AS
SELECT
	b.dpcr_year,b.dpcr_period,b.dpcr_deadline,
	a.*
FROM
	performance_ipcr_staffs AS a
LEFT JOIN
	performance_dpcrs AS b ON b.id = a.dpcr_id





