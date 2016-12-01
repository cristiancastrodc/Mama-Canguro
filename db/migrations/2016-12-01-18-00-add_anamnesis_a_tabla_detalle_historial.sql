ALTER TABLE `tadetalle_historia` ADD `anamnemesis` VARCHAR(500) NULL AFTER `dat_proxima_cita`;

INSERT INTO migrations VALUES ('2016-12-01-18-00-add_anamnesis_a_tabla_detalle_historial.sql');
