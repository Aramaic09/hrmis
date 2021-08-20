-- DELIMITER $$

-- CREATE PROCEDURE GetAdminPosition(IN DIVISION CHAR(100))
-- BEGIN
-- 	IF (DIVISION = 'ALL') THEN
-- 				SELECT
-- 					COUNT(id) AS total,
-- 					a.position_desc,a.division
-- 				FROM
-- 					view_employee_position AS a
-- 				WHERE
-- 					a.position_class = 'Administrative'
-- 				GROUP BY
-- 					a.position_desc;
-- 			ELSE
-- 				SELECT
-- 					COUNT(id) AS total,
-- 					a.position_desc,a.division
-- 				FROM
-- 					view_employee_position AS a
-- 				WHERE
-- 					a.position_class = 'Administrative'
-- 					AND
-- 					a.division = DIVISION collate utf8mb4_unicode_ci
-- 				GROUP BY
-- 					a.position_desc;
-- 	END IF;
-- END


DELIMITER $$

CREATE PROCEDURE GetTechnicalPosition(IN DIVISION CHAR(100))
BEGIN
	IF (DIVISION = 'ALL') THEN
				SELECT
					COUNT(id) AS total,
					a.position_desc,a.division
				FROM
					view_employee_position AS a
				WHERE
					a.position_class = 'Technical'
				GROUP BY
					a.position_desc;
			ELSE
				SELECT
					COUNT(id) AS total,
					a.position_desc,a.division
				FROM
					view_employee_position AS a
				WHERE
					a.position_class = 'Technical'
					AND
					a.division = DIVISION collate utf8mb4_unicode_ci
				GROUP BY
					a.position_desc;
	END IF;
END
