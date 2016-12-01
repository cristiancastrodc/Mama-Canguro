ALTER TABLE `tadetalle_historia` ADD `id_servicio` INT NULL AFTER `anamnemesis`;

INSERT INTO migrations VALUES ('2016-12-01-18-45-add_id_servicio_a_detalle_historial.sql');
