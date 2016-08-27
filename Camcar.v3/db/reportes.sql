-- TODOS LOS EMPLEADOS

SELECT USR_NumeroEmpleado NumeroEmpleado,
       USR_ApellidoPaterno ApellidoPaterno,
       USR_ApellidoMaterno ApellidoMaterno,
       USR_Nombres Nombres,
       USR_Mail Mail,
       USR_Cumpleanos Cumpleanos,
       USR_FechaIngreso FechaIngreso,
       USR_Telefono Telefono,
       USR_Estado Estado,
       USR_Ciudad Ciudad,
       USR_NumeroAgencia NumeroAgencia,
       USR_Agencia Agencia,
       USR_Marca Marca,
       USR_Area Area,
       USR_Cargo Cargo
FROM camUsuarios
WHERE USR_Control <> 0
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
ORDER BY USR_NumeroEmpleado ASC;


-- CORREOS REPETIDOS

SELECT USR_Mail Mail, COUNT(USR_Mail) Repeticiones
FROM camUsuarios
WHERE USR_Control <> 0
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
GROUP BY USR_Mail
HAVING COUNT(USR_Mail) > 1

-- EMPLEADOS CON CORREOS REPETIDOS

SELECT USR_NumeroEmpleado NumeroEmpleado,
       USR_ApellidoPaterno ApellidoPaterno,
       USR_ApellidoMaterno ApellidoMaterno,
       USR_Nombres Nombres,
       USR_Mail Mail,
       USR_Cumpleanos Cumpleanos,
       USR_FechaIngreso FechaIngreso,
       USR_Telefono Telefono,
       USR_Estado Estado,
       USR_Ciudad Ciudad,
       USR_NumeroAgencia NumeroAgencia,
       USR_Agencia Agencia,
       USR_Marca Marca,
       USR_Area Area,
       USR_Cargo Cargo
FROM camUsuarios
WHERE USR_Control <> 0
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
AND USR_Mail IN (
     SELECT USR_Mail
     FROM camUsuarios
     WHERE USR_Control <> 0
     AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
     GROUP BY USR_Mail
     HAVING COUNT(USR_Mail) > 1
)
ORDER BY USR_Mail ASC;


-- NÚMEROS DE EMPLEADO REPETIDOS

SELECT USR_NumeroEmpleado Mail, COUNT(USR_NumeroEmpleado) Repeticiones
FROM camUsuarios
WHERE USR_Control <> 0
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
GROUP BY USR_NumeroEmpleado
HAVING COUNT(USR_NumeroEmpleado) > 1

-- EMPLEADOS CON NÚMEROS DE EMPLEADO REPETIDOS

SELECT USR_NumeroEmpleado NumeroEmpleado,
       USR_ApellidoPaterno ApellidoPaterno,
       USR_ApellidoMaterno ApellidoMaterno,
       USR_Nombres Nombres,
       USR_Mail Mail,
       USR_Cumpleanos Cumpleanos,
       USR_FechaIngreso FechaIngreso,
       USR_Telefono Telefono,
       USR_Estado Estado,
       USR_Ciudad Ciudad,
       USR_NumeroAgencia NumeroAgencia,
       USR_Agencia Agencia,
       USR_Marca Marca,
       USR_Area Area,
       USR_Cargo Cargo
FROM camUsuarios
WHERE USR_Control <> 0
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
AND USR_NumeroEmpleado IN (
     SELECT USR_NumeroEmpleado
     FROM camUsuarios
     WHERE USR_Control <> 0
     AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
     GROUP BY USR_NumeroEmpleado
     HAVING COUNT(USR_NumeroEmpleado) > 1
)
ORDER BY USR_NumeroEmpleado ASC;

-- EMPLEADOS REGISTRADOS Y CON PROCESO INICIADO

SELECT USR_NumeroEmpleado NumeroEmpleado,
       USR_ApellidoPaterno ApellidoPaterno,
       USR_ApellidoMaterno ApellidoMaterno,
       USR_Nombres Nombres,
       USR_Mail Mail,
       USR_Cumpleanos Cumpleanos,
       USR_FechaIngreso FechaIngreso,
       USR_Telefono Telefono,
       USR_Estado Estado,
       USR_Ciudad Ciudad,
       USR_NumeroAgencia NumeroAgencia,
       USR_Agencia Agencia,
       USR_Marca Marca,
       USR_Area Area,
       USR_Cargo Cargo,
       USR_UltimoIngreso,
       USR_Control
FROM camUsuarios
WHERE USR_Control NOT IN(0, 2)
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
ORDER BY USR_Control, USR_NumeroEmpleado ASC;

-- EMPLEADOS NUEVOS

SELECT USR_NumeroEmpleado NumeroEmpleado,
       USR_ApellidoPaterno ApellidoPaterno,
       USR_ApellidoMaterno ApellidoMaterno,
       USR_Nombres Nombres,
       USR_Mail Mail,
       USR_Cumpleanos Cumpleanos,
       USR_FechaIngreso FechaIngreso,
       USR_Telefono Telefono,
       USR_Estado Estado,
       USR_Ciudad Ciudad,
       USR_NumeroAgencia NumeroAgencia,
       USR_Agencia Agencia,
       USR_Marca Marca,
       USR_Area Area,
       USR_Cargo Cargo,
       USR_UltimoIngreso,
       USR_Control
FROM camUsuarios
WHERE USR_Control <> 0
AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
AND USR_FechaModificado BETWEEN '2016-07-17 00:00:00' AND '2016-08-23 00:00:00'
ORDER BY USR_Control, USR_NumeroEmpleado ASC;