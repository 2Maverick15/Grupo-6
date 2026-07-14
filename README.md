# Informe de Auditoría de Seguridad

Auditor: Estudiante 3 (Oficial de Seguridad)
Enfoque: Filosofía "Zero Trust" e Integridad de Persistencia

# 1. Verificacion de Hashing Criptográfico
Estado: COMPLETO / POR VERIFICAR
Detalle: Se ha auditado el modulo de registro desarrollado por el Estudiante 2. Se confirma la implementacion obligatoria del algoritmo `PASSWORD_BCRYPT` a traves de la funcion `password_hash()`. Esto garantiza un hashing de nivel industrial con una estructura de sal (salt) integrada y resistente a ataques de fuerza bruta.

# 2. Análisis de Bloques Try...Catch (Fugas de Informacion)
Estado: COMPLETO / POR VERIFICAR
Detalle: Se reviso exhaustivamente el archivo `conexion.php` y los scripts DML del Estudiante 2. Se constato que los bloques `catch` capturan correctamente las excepciones `PDOException` sin exponer datos sensibles (como nombres de tablas, columnas, credenciales de la base de datos o rutas del servidor). Los errores crudos son enviados al log interno del servidor (`error_log`) y de cara al usuario final se despliegan mensajes genericos y controlados.

# 3. Mitigacion de Inyeccion SQL (SQLi)
Estado: COMPLETO / POR VERIFICAR
Detalle: Se confirma la erradicacion total del paradigma procedural obsoleto (`mysqli_query`). El Estudiante 2 estructuro el acceso a datos mediante la clase PDO e implemento estrictamente Sentencias Preparadas (Prepared Statements) con placeholders. No existen concatenaciones de variables en las consultas evaluadas, neutralizando la superficie de ataque para Inyecciones SQL (SQLi).