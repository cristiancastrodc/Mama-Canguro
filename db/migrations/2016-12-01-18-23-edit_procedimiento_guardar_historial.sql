DROP PROCEDURE `sp_tadetalle_historia_insertar`;

CREATE PROCEDURE `sp_tadetalle_historia_insertar`(IN `pdni` CHAR(8), IN `pnro` INT(11), IN `pfecha` DATE, IN `pdiag` VARCHAR(500), IN `ptra` VARCHAR(500), IN `pNroatencion` INT, IN `pdni_atiende` CHAR(8), IN `pCita` DATE, IN `pAnamnemesis` VARCHAR(500))
BEGIN
	INSERT INTO tadetalle_historia(chr_dni_paciente,int_nro_detalle,dat_fecha_consulta,vch_diagnostico,vch_tratamiento,dat_proxima_cita,anamnemesis)
		VALUES (pdni,pnro,pfecha,pdiag,ptra,pCita,pAnamnemesis);
	UPDATE taatencion SET chr_dni_usuatiende = pdni_atiende, tim_hora_consulta = curtime(), vch_estado = 'atendido'
    WHERE int_nro_atencion=pNroatencion;
END

INSERT INTO migrations VALUES ('2016-12-01-18-23-edit_procedimiento_guardar_historial.sql');
