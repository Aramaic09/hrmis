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