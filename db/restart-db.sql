-- Eliminar los datos
TRUNCATE taantecedentes_medicina_general;
TRUNCATE taantecedentes_pediatricos;
TRUNCATE taantecedente_ginecologico;
TRUNCATE taatencion;
TRUNCATE tadetalle_historia;
TRUNCATE tapaciente;
DELETE FROM taservicio WHERE int_idservicio > 169;
TRUNCATE tausuario;
-- Insertar el usuario por defecto
