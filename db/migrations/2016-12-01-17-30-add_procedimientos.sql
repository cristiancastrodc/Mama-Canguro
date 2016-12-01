CREATE PROCEDURE `sp_radiologo_atenciones_paciente` (IN `dni` CHAR(8))  BEGIN
	SELECT int_nro_atencion, tas.vch_denominacion, taa.dat_fecha_emuestra, taa.dat_fecha_eresultado, vch_estado
		FROM taatencion taa
		INNER JOIN taservicio tas ON taa.int_idservicio = tas.int_idservicio
		INNER JOIN tapaciente tap ON taa.chr_dni_paciente = tap.chr_dni_paciente
	WHERE tas.vch_tipo = 'Consulta'
	AND tas.int_consultorio = 4
	AND tap.chr_dni_paciente = dni
	ORDER BY taa.int_nro_atencion DESC;
END$$

INSERT INTO migrations VALUES ('2016-12-01-17-30-add_procedimientos.sql');
