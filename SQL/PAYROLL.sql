CREATE OR REPLACE VIEW view_membership AS
SELECT
	a.*,
	b.ORG_NAME,b.ORG_ACRO
FROM 
	emp_org AS a
LEFT JOIN
	organizations AS b ON a.ORG_CODE = b.ORG_CODE;

CREATE OR REPLACE VIEW view_personal_loan AS
SELECT
	a.*,
	b.ORG_NAME,b.ORG_ACRO,
	c.SERV_DESC,c.SERV_ACRO
FROM 
	deduct AS a
LEFT JOIN
	organizations AS b ON a.ORG_CODE = b.ORG_CODE
LEFT JOIN
	org_serv AS c ON b.ORG_CODE = c.ORG_CODE AND a.SERV_CODE = c.SERV_CODE;


CREATE OR REPLACE VIEW view_deduction AS
SELECT
	a.*,
	b.deductCode,b.deductName
FROM 
	empdeduct AS a
LEFT JOIN
	deductmanda AS b ON a.deductID = b.deductID;



CREATE OR REPLACE VIEW view_compensation AS
SELECT
	a.*,
	b.compCode,b.compName
FROM 
	empcompensations AS a
LEFT JOIN
	compensations AS b ON a.compID = b.compID;
