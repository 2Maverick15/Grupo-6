# Informe Técnico del Arquitecto de Persistencia

**Responsable:** Estudiante 2 (Arquitecto de Persistencia)  
**Enfoque:** Persistencia de Datos Segura mediante **PDO** y **Sentencias Preparadas (Prepared Statements)**.

---

# 1. Implementación de la Conexión Segura con PDO

**Estado:** ** COMPLETO**

**Detalle:** Se desarrolló el archivo **`conexion.php`** utilizando la clase **PDO (PHP Data Objects)** para establecer una conexión segura y orientada a objetos con el servidor **MySQL**.

La conexión fue configurada con el conjunto de caracteres **`utf8mb4`**, garantizando la compatibilidad con caracteres especiales y una correcta integridad de la información almacenada.

Como mecanismo de control de errores se configuró el atributo **`PDO::ATTR_ERRMODE`** con el valor **`PDO::ERRMODE_EXCEPTION`**, permitiendo que cualquier fallo durante la conexión sea administrado mediante excepciones.

Toda la inicialización fue encapsulada dentro de un bloque **`try...catch`**, garantizando un manejo seguro de errores y evitando interrupciones inesperadas del sistema.

---

# 2. Desarrollo del Módulo de Inserción de Usuarios

**Estado:** ** COMPLETO**

**Detalle:** Se implementó un **script funcional de registro de usuarios** utilizando **Sentencias Preparadas (Prepared Statements)** mediante el método **`prepare()`** de la clase **PDO**.

La consulta SQL fue construida utilizando **placeholders** (`:nombre`, `:correo`, `:password`), eliminando completamente la concatenación de variables dentro de la instrucción SQL.

Posteriormente, cada parámetro fue asociado mediante el método **`bindParam()`**, permitiendo que la base de datos procese la información de forma segura antes de ejecutar la consulta.

Finalmente, la operación fue realizada mediante el método **`execute()`**, logrando la inserción correcta de los datos en la base de datos.

---

# 3. Mitigación de Inyección SQL (SQL Injection)

**Estado:** ** COMPLETO**

**Detalle:** Como medida principal de seguridad se descartó completamente el uso de consultas construidas mediante concatenación de variables.

Todo el acceso a la base de datos fue implementado utilizando **Prepared Statements**, manteniendo separada la estructura de la consulta de los datos enviados por el usuario.

Esta implementación reduce significativamente la superficie de ataque frente a intentos de **SQL Injection (SQLi)** y cumple con las buenas prácticas modernas de desarrollo seguro.

---

# 4. Protección de Credenciales

**Estado:** ** COMPLETO**

**Detalle:** Antes de almacenar las contraseñas de los usuarios se implementó el algoritmo criptográfico **`PASSWORD_BCRYPT`** mediante la función **`password_hash()`**.

Esta técnica evita el almacenamiento de credenciales en texto plano, generando un **hash seguro** con **salt** incorporado, fortaleciendo la seguridad frente a ataques de fuerza bruta y posibles filtraciones de información.

---

# 5. Manejo de Excepciones

**Estado:** ** COMPLETO**

**Detalle:** Todas las operaciones relacionadas con la conexión y el registro de usuarios fueron protegidas mediante bloques **`try...catch`**, permitiendo capturar excepciones del tipo **`PDOException`**.

Este mecanismo mejora la estabilidad del sistema, facilita el diagnóstico de errores y evita fallos inesperados durante la ejecución de las operaciones de persistencia.

---

# Conclusión

Se desarrolló satisfactoriamente el módulo de persistencia correspondiente al **Estudiante 2 (Arquitecto de Persistencia)**, implementando una conexión segura mediante **PDO**, manejo de excepciones con **`try...catch`**, inserción de registros mediante **Sentencias Preparadas**, utilización de **placeholders** para prevenir ataques de **SQL Injection (SQLi)** y almacenamiento seguro de contraseñas utilizando **`PASSWORD_BCRYPT`**.

La solución implementada cumple con los requisitos establecidos en la evaluación y proporciona una base segura, robusta y escalable para la comunicación entre la aplicación y la base de datos, facilitando además la integración con los módulos desarrollados por el resto del equipo.







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
