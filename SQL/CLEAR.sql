TRUNCATE `applicants`;
TRUNCATE `applicant_position_applies`;
TRUNCATE `employee_training_temps`;
TRUNCATE `h_r_d_hrdcs`;
TRUNCATE `h_r_d_plans`;
TRUNCATE `h_r_d_plan_degrees`;
TRUNCATE `h_r_d_plan_divisions`;
TRUNCATE `h_r_d_plan_non_degrees`;
TRUNCATE `h_r_d_plan_non_degree_areas`;
TRUNCATE `h_r_d_plan_staffs`;
TRUNCATE `h_r_d_remarks`;
TRUNCATE `invitations`;
TRUNCATE `link_to_applicants`;
TRUNCATE `performance_dpcrs`;
TRUNCATE `performance_ipcrs`;
TRUNCATE `performance_ipcr_staffs`;
TRUNCATE `recruitment_file_histories`;
TRUNCATE `recruitment_histories`;
TRUNCATE `recruitment_letter_histories`;
TRUNCATE `request_for_hirings`;
TRUNCATE `vacant_plantillas`;

/*--CLEAR--*/
DELETE FROM users WHERE id > 356;