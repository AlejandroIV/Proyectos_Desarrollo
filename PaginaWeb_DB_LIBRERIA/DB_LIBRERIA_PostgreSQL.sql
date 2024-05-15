-- Creacion de catalogos
CREATE TABLE CTLG_LIBRO_CATEGORIA (
	cIdCategoria CHAR(2) PRIMARY KEY,
	vcCategoria VARCHAR(30) NOT NULL,
	vcDescripcion VARCHAR(50) DEFAULT NULL,
	dFechaCreacion DATE DEFAULT CURRENT_DATE NOT NULL,
	dFechaModificacion DATE DEFAULT NULL
);

CREATE TABLE CTLG_LIBRO (
	vcIdLibro VARCHAR(4) PRIMARY KEY,
	cIdCategoria CHAR(2) NOT NULL,
	vcTitulo VARCHAR(150) NOT NULL,
	vcAutores VARCHAR(300) NOT NULL,
	siAnhoPublicacion SMALLINT NOT NULL,
	vcCiudadPublicacion VARCHAR(100) NOT NULL,
	vcEditorial VARCHAR(100) NOT NULL,
	tiEdicion SMALLINT DEFAULT 1,
	cIsbn CHAR(13) DEFAULT NULL,
	dFechaCreacion DATE DEFAULT CURRENT_DATE NOT NULL,
	dFechaModificacion DATE DEFAULT NULL
);

CREATE TABLE CTLG_UBICACION (
	vcIdUbicacion VARCHAR(3) PRIMARY KEY,
	vcDescripcion VARCHAR(40) DEFAULT NULL,
	siCapacidad SMALLINT NOT NULL,
	dFechaCreacion DATE DEFAULT CURRENT_DATE NOT NULL,
	dFechaModificacion DATE DEFAULT NULL
);

CREATE TABLE CTLG_ESTADO (
	iIdEstado INT PRIMARY KEY,
	vcEstado VARCHAR(40) NOT NULL,
	vcDescripcion VARCHAR(70) DEFAULT NULL,
	dFechaCreacion DATE DEFAULT CURRENT_DATE NOT NULL,
	dFechaModificacion DATE DEFAULT NULL
);

-- Creacion de tablas
CREATE TABLE TBL_STOCK (
	iIdStock SERIAL PRIMARY KEY,
	vcIdLibro VARCHAR(4) NOT NULL,
	vcIdUbicacion VARCHAR(3) NOT NULL,
	siCantidadDisponible SMALLINT NOT NULL
);-- Transaccional

CREATE TABLE TBL_LIBRO_VENTA (
	cIdLibroVenta CHAR(4) PRIMARY KEY,
	vcIdLibro VARCHAR(4) NOT NULL,
	siCantidadParaVenta SMALLINT NOT NULL,
	decPrecioUnitario DECIMAL(7, 2) NOT NULL
);-- Registros creados desde el sistema

CREATE TABLE TBL_VENTA (
	iIdVenta SERIAL PRIMARY KEY,
	cIdLibroVenta CHAR(4) NOT NULL,
	siCantidadVendida SMALLINT NOT NULL,
	decTotalVenta DECIMAL(9, 2) NOT NULL,
	vcMetodoPago VARCHAR (30) NOT NULL
);-- Transaccional

CREATE TABLE TBL_PERSONA (
	vcIdPersona VARCHAR(10) PRIMARY KEY,
	vcNombre VARCHAR(50) NOT NULL,
	vcApellidoPaterno VARCHAR(50) NOT NULL,
	vcApellidoMaterno VARCHAR(50) DEFAULT NULL,
	dFechaNacimiento DATE DEFAULT NULL,
	cGenero CHAR(1) DEFAULT NULL,
	vcDireccion VARCHAR(150) DEFAULT NULL,
	vcTelefono VARCHAR(15) DEFAULT NULL,
	vcCorreoElectronico VARCHAR(254) DEFAULT NULL
);

CREATE TABLE TBL_USUARIO (
	vcIdUsuario VARCHAR(7) PRIMARY KEY,
	vcIdPersona VARCHAR(10) NOT NULL,
	iIdEstado INT NOT NULL,
	dFechaInicio DATE DEFAULT CURRENT_DATE NOT NULL
);

CREATE TABLE TBL_PRESTAMO (
	vcIdPrestamo VARCHAR(6) PRIMARY KEY,
	vcIdUsuario VARCHAR(7) NOT NULL,
	iIdEstado INT NOT NULL,
	vcIdLibro VARCHAR(4) NOT NULL,
	dFechaPrestamo DATE DEFAULT CURRENT_DATE NOT NULL,
	dFechaDevolucion DATE NOT NULL
);-- Transaccional

CREATE TABLE TBL_SUSPENSION (
	vcIdSuspension VARCHAR(5) PRIMARY KEY,
	vcIdUsuario VARCHAR(7) NOT NULL,
	iIdEstado INT NOT NULL,
	vcDescripcion VARCHAR(40),
	dFechaSuspension DATE DEFAULT CURRENT_DATE NOT NULL,
	dFechaModificacion DATE DEFAULT NULL
);-- Transaccional

-- Relaciones
ALTER TABLE CTLG_LIBRO
ADD FOREIGN KEY (cIdCategoria) REFERENCES CTLG_LIBRO_CATEGORIA(cIdCategoria);

ALTER TABLE TBL_STOCK
ADD FOREIGN KEY (vcIdLibro) REFERENCES CTLG_LIBRO(vcIdLibro);
ALTER TABLE TBL_STOCK
ADD FOREIGN KEY (vcIdUbicacion) REFERENCES CTLG_UBICACION(vcIdUbicacion);

ALTER TABLE TBL_LIBRO_VENTA
ADD FOREIGN KEY (vcIdLibro) REFERENCES CTLG_LIBRO(vcIdLibro);

ALTER TABLE TBL_VENTA
ADD FOREIGN KEY (cIdLibroVenta) REFERENCES TBL_LIBRO_VENTA(cIdLibroVenta);

ALTER TABLE TBL_USUARIO
ADD FOREIGN KEY (vcIdPersona) REFERENCES TBL_PERSONA(vcIdPersona);
ALTER TABLE TBL_USUARIO
ADD FOREIGN KEY (iIdEstado) REFERENCES CTLG_ESTADO(iIdEstado);

ALTER TABLE TBL_PRESTAMO
ADD FOREIGN KEY (vcIdUsuario) REFERENCES TBL_USUARIO(vcIdUsuario);
ALTER TABLE TBL_PRESTAMO
ADD FOREIGN KEY (iIdEstado) REFERENCES CTLG_ESTADO(iIdEstado);
ALTER TABLE TBL_PRESTAMO
ADD FOREIGN KEY (vcIdLibro) REFERENCES CTLG_LIBRO(vcIdLibro);

ALTER TABLE TBL_SUSPENSION
ADD FOREIGN KEY (vcIdUsuario) REFERENCES TBL_USUARIO(vcIdUsuario);
ALTER TABLE TBL_SUSPENSION
ADD FOREIGN KEY (iIdEstado) REFERENCES CTLG_ESTADO(iIdEstado);

-- Insercion de datos de prueba
INSERT INTO CTLG_LIBRO_CATEGORIA (cIdCategoria, vcCategoria, vcDescripcion) VALUES 
	('LT', 'Literatura', 'Cuentos, poemarios y novelas'),
	('CR', 'Referencia', 'Diccionarios, enciclopedias y atlas'),
	('AI', 'Artístico e ilustrativo', 'Catálogos de museo y libros de fotografía'),
	('DI', 'Divulgativo', 'Biografías o libros de divulgación científica'),
	('TE', 'Técnico o especializado', 'Documentación y libros de temas especializados'),
	('PR', 'Prácticos', 'Recetarios, instructivos y manuales'),
	('TX', 'Texto', 'Otros');
	
INSERT INTO CTLG_UBICACION (vcIdUbicacion, vcDescripcion, siCapacidad) VALUES
	('ZN1', 'Almacén 1', 120),
	('ZN2', 'Almacén 2', 120),
	('ZN3', 'Almacén 3', 120),
	('PA', 'Pasillo A', 40),
	('PB', 'Pasillo B', 40),
	('PC', 'Pasillo C', 40),
	('PD', 'Pasillo D', 40),
	('PE', 'Pasillo E', 40),
	('PF', 'Pasillo F', 40),
	('PG', 'Pasillo G', 40),
	('PH', 'Pasillo H', 40),
	('PI', 'Pasillo I', 40),
	('E1', 'Estante 1', 20),
	('E2', 'Estante 2', 20),
	('E3', 'Estante 3', 20),
	('E4', 'Estante 4', 20),
	('E5', 'Estante 5', 20),
	('E6', 'Estante 6', 20),
	('E7', 'Estante 7', 20),
	('E8', 'Estante 8', 20),
	('E9', 'Estante 9', 20),
	('E10', 'Estante 10', 20),
	('E11', 'Estante 11', 20),
	('E12', 'Estante 12', 20),
	('E13', 'Estante 13', 20),
	('E14', 'Estante 14', 20),
	('E15', 'Estante 15', 20),
	('E16', 'Estante 16', 20),
	('E17', 'Estante 17', 20),
	('E18', 'Estante 18', 20);
	
INSERT INTO CTLG_ESTADO (iIdEstado, vcEstado, vcDescripcion) VALUES
	(1, 'Habilitado', 'Usuario con posibilidad de pedir préstamos'),
	(2, 'Inhabilitado', 'Usuario con imposibilidad de pedir préstamos'),
	(3, 'Suspendido', 'Usuario suspendido por entrega con retraso o falta de entrega'),
	(4, 'Saturado', 'Usuario que ha excedido la cantidad de préstamos en el periodo actual'),
	(101, 'Activo', 'Préstamo activo'),
	(102, 'Finalizado', 'Préstamo finalizado'),
	(103, 'Renovado', 'Préstamo renovado'),
	(104, 'Retrasado', 'Préstamo que ha excedido la fecha de devolución'),
	(105, 'Revocado', 'Préstamo revocado'),
	(1001, 'Vigente', 'Suspensión vigente'),
	(1002, 'Cancelado', 'Suspensión cancelada');
	
-- Lista de procedimientos almacenados
/*
 * Asignar el estado 'Retrasado' a los prestamos que han excedido la fecha de devolucion 
 */
CREATE OR REPLACE PROCEDURE SPD_ACTUALIZAR_PRESTAMOS()
AS $$
BEGIN
	-- Actualizar la tabla 'TBL_PRESTAMO' si ya se excedio la fecha de devolucion
    UPDATE TBL_PRESTAMO
	SET iIdEstado = 104
	WHERE dFechaDevolucion < CURRENT_DATE;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al actualizar los registros';  -- RAISE EXCEPTION 'Error al insertar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Actualizar cantidad disponible, cantidad para venta y precio de un libro
 */
CREATE OR REPLACE PROCEDURE SPD_ACTUALIZAR_STOCK_VENTA_LIBRO(
	pVcIdLibro VARCHAR(4),
	pVcIdUbicacion VARCHAR(3),
	pSiCantidadDisponible SMALLINT,
	pCIdLibroVenta CHAR(4),
	pSiCantidadParaVenta SMALLINT,
	pDecPrecioUnitario DECIMAL(7, 2)
)
AS $$
BEGIN
	-- Actualizar registro de la tabla 'TBL_STOCK'
	UPDATE TBL_STOCK
	SET siCantidadDisponible = pSiCantidadDisponible
	WHERE vcIdLibro = pVcIdLibro
		AND vcIdUbicacion = pVcIdUbicacion;
	-- Si existe registro en la tabla 'TBL_LIBRO_VENTA' actualizar
	IF EXISTS (SELECT 1 FROM TBL_LIBRO_VENTA WHERE vcIdLibro = pVcIdLibro) THEN
		UPDATE TBL_LIBRO_VENTA
		SET siCantidadParaVenta = pSiCantidadParaVenta, decPrecioUnitario = pDecPrecioUnitario
		WHERE vcIdLibro = pVcIdLibro;
	-- Si no existe el registro en la tabla 'TBL_LIBRO_VENTA' crear
	ELSE
		INSERT INTO TBL_LIBRO_VENTA (cIdLibroVenta, vcIdLibro, siCantidadParaVenta, decPrecioUnitario)
		VALUES (pCIdLibroVenta, pVcIdLibro, pSiCantidadParaVenta, pDecPrecioUnitario);
    END IF;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al actualizar los registros';  -- RAISE EXCEPTION 'Error al actualizar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Insertar un nuevo registro a la tabla 'TBL_SUSPENSION' con un usuario especificado
 */
CREATE OR REPLACE PROCEDURE SPD_APLICAR_SUSPENSION(
	pVcIdSuspension VARCHAR(5),
	pVcIdUsuario VARCHAR(7)
)
AS $$
BEGIN
	-- Insertar registro en la tabla 'TBL_SUSPENSION'
	INSERT INTO TBL_SUSPENSION (vcIdSuspension, vcIdUsuario, iIdEstado, vcDescripcion)
	VALUES 	(pVcIdSuspension, pVcIdUsuario, 1001, 'Suspensión aplicada');
	-- Actualizar registro de la tabla 'TBL_USUARIO'
	UPDATE TBL_USUARIO
	SET iIdEstado = 3
	WHERE vcIdUsuario = pVcIdUsuario;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al insertar los registros';  -- RAISE EXCEPTION 'Error al insertar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Actualizar los registros asociados a la suspension de un usuario especificado
 */
CREATE OR REPLACE PROCEDURE SPD_CANCELAR_SUSPENSION(
	pVcIdUsuario VARCHAR(7)
)
AS $$
BEGIN
	-- Actualizar registros de la tabla 'TBL_SUSPENSION'
	UPDATE TBL_SUSPENSION
	SET iIdEstado = 1002, vcDescripcion = 'Suspensión cancelada', dFechaModificacion = CURRENT_DATE
	WHERE vcIdUsuario = pVcIdUsuario;
	-- Actualizar registro de la tabla 'TBL_USUARIO'
	UPDATE TBL_USUARIO
	SET iIdEstado = 1
	WHERE vcIdUsuario = pVcIdUsuario;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al insertar los registros';  -- RAISE EXCEPTION 'Error al insertar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Eliminar registros de la tabla 'TBL_STOCK' y si existen registros en la tabla 'TBL_LIBRO_VENTA' los actualiza
 */
CREATE OR REPLACE PROCEDURE SPD_ELIMINAR_STOCK_VENTA_LIBRO(
	pVcIdLibro VARCHAR(4),
	pVcIdUbicacion VARCHAR(3)
)
AS $$
BEGIN
	-- Eliminar registro de la tabla 'TBL_STOCK'
	DELETE FROM TBL_STOCK
	WHERE vcIdLibro = pVcIdLibro
		AND vcIdUbicacion = pVcIdUbicacion;
	-- Actualizar registro de la tabla 'TBL_LIBRO_VENTA'
	IF EXISTS (SELECT 1 FROM TBL_LIBRO_VENTA WHERE vcIdLibro = pVcIdLibro) THEN
		UPDATE TBL_LIBRO_VENTA
		SET siCantidadParaVenta = 0, decPrecioUnitario = 0
		WHERE vcIdLibro = pVcIdLibro;
    END IF;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al eliminar los registros'; -- RAISE EXCEPTION 'Error al eliminar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Insertar registros en la tabla 'TBL_PRESTAMO' y actualizar los registros de la tabla 'TBL_STOCK'
 */
CREATE OR REPLACE PROCEDURE SPD_INSERTAR_PRESTAMO(
	pVcIdsPrestamo VARCHAR(6)[],
	pVcIdUsuario VARCHAR(7),
	pIIdsStock INT[]
)
AS $$
DECLARE
    i INT;
BEGIN
    -- Iterar sobre los arrays
    FOR i IN 1..array_length(pVcIdsPrestamo, 1) LOOP
		-- Actualizar la tabla 'TBL_STOCK'
		UPDATE TBL_STOCK
		SET siCantidadDisponible = siCantidadDisponible - 1
		WHERE iIdStock = pIIdsStock[i];
		-- Insertar registro en la tabla 'TBL_PRESTAMO'
		INSERT INTO TBL_PRESTAMO (vcIdPrestamo, vcIdUsuario, iIdEstado, vcIdLibro, dFechaDevolucion)
		VALUES 	(pVcIdsPrestamo[i], pVcIdUsuario, 101, (SELECT vcIdLibro FROM TBL_STOCK WHERE iIdStock = pIIdsStock[i]), (SELECT CURRENT_DATE + INTERVAL '7 days'));
    END LOOP;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al insertar los registros';  -- RAISE EXCEPTION 'Error al insertar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Insertar registros en la tabla 'TBL_STOCK' o actualizar los registros de la tabla 'TBL_STOCK' ya existentes
 */
CREATE OR REPLACE PROCEDURE SPD_INSERTAR_STOCK(
	pVcIdLibros VARCHAR(4)[],
	pVcIdUbicaciones VARCHAR(3)[],
	pSiCantidadesDisponibles SMALLINT[]
)
AS $$
DECLARE
    i INT;
BEGIN
    -- Iterar sobre los arrays
    FOR i IN 1..array_length(pVcIdLibros, 1) LOOP
		-- Si ya existe el registro actualizar
		IF EXISTS (SELECT 1 FROM TBL_STOCK WHERE vcIdLibro = pVcIdLibros[i] AND vcIdUbicacion = pVcIdUbicaciones[i]) THEN
			UPDATE TBL_STOCK
			SET siCantidadDisponible = siCantidadDisponible + pSiCantidadesDisponibles[i]
			WHERE vcIdLibro = pVcIdLibros[i] AND vcIdUbicacion = pVcIdUbicaciones[i];
        -- Si no insertar el registro en la tabla 'TBL_STOCK'
		ELSE
        	INSERT INTO TBL_STOCK (vcIdLibro, vcIdUbicacion, siCantidadDisponible)
			VALUES (pVcIdLibros[i], pVcIdUbicaciones[i], pSiCantidadesDisponibles[i]);
		END IF;
    END LOOP;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al insertar los registros';
END;
$$ LANGUAGE plpgsql;



/*
 * Insertar registros en la tabla 'TBL_VENTA' y actualizar los registros de las tablas 'TBL_STOCK' y 'TBL_LIBRO_VENTA' ya existentes
 */
CREATE OR REPLACE PROCEDURE SPD_INSERTAR_VENTAS(
	pIIdsStock INT[],
	pCIdsLibrosVenta CHAR(4)[],
	pSiCantidades SMALLINT[]
)
AS $$
DECLARE
    i INT;
BEGIN
    -- Iterar sobre los arrays
    FOR i IN 1..array_length(pIIdsStock, 1) LOOP
		-- Actualizar la tabla 'TBL_STOCK'
		UPDATE TBL_STOCK
		SET siCantidadDisponible = siCantidadDisponible - pSiCantidades[i]
		WHERE iIdStock = pIIdsStock[i];
		-- Actualizar la tabla 'TBL_LIBRO_VENTA'
		UPDATE TBL_LIBRO_VENTA
		SET siCantidadParaVenta = siCantidadParaVenta - pSiCantidades[i]
		WHERE cIdLibroVenta = pCIdsLibrosVenta[i];
		-- Insertar registro en la tabla 'TBL_VENTA'
		INSERT INTO TBL_VENTA (cIdLibroVenta, siCantidadVendida, decTotalVenta, vcMetodoPago)
		VALUES 	(pCIdsLibrosVenta[i], pSiCantidades[i], (SELECT decPrecioUnitario * pSiCantidades[i] FROM TBL_LIBRO_VENTA WHERE cIdLibroVenta = pCIdsLibrosVenta[i]), 'Efectivo');
    END LOOP;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al insertar los registros';  -- RAISE EXCEPTION 'Error al insertar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



/*
 * Actualizar registros en la tabla 'TBL_PRESTAMO'
 */
CREATE OR REPLACE PROCEDURE SPD_REALIZAR_DEVOLUCION(
	pVcIdsPrestamo VARCHAR(6)[]
)
AS $$
DECLARE
    i INT;
BEGIN
    -- Iterar sobre el array
    FOR i IN 1..array_length(pVcIdsPrestamo, 1) LOOP
		-- Actualizar la tabla 'TBL_PRESTAMO'
		UPDATE TBL_PRESTAMO
		SET iIdEstado = 102, dFechaDevolucion = CURRENT_DATE
		WHERE vcIdPrestamo = pVcIdsPrestamo[i];
    END LOOP;
EXCEPTION
    -- Rollback en caso de error
    WHEN others THEN
        RAISE EXCEPTION 'Error al actualizar los registros';  -- RAISE EXCEPTION 'Error al actualizar los registros. Detalles: %', SQLERRM;
END;
$$ LANGUAGE plpgsql;



-- Lista de funciones
/*
 * Consultar datos de varias tablas relacionadas con los libros
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_DETALLES_LIBROS()
RETURNS TABLE (
	vcIdLibro VARCHAR(4),
    vcTitulo VARCHAR(150),
	vcCategoria VARCHAR(30),
    vcAutores VARCHAR(300),
    siAnhoPublicacion SMALLINT,
    vcCiudadPublicacion VARCHAR(100),
    vcEditorial VARCHAR(100),
    tiEdicion SMALLINT,
    cIsbn CHAR(13),
	siCantidadDisponible SMALLINT,
	vcIdUbicacion VARCHAR(3),
	vcDescripcionUbicacion VARCHAR(40),
	siCantidadParaVenta SMALLINT,
	decPrecioUnitario DECIMAL(7, 2),
	siCantidadTotal SMALLINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT CL.vcIdLibro,
		   CL.vcTitulo,
		   CLC.vcCategoria,
		   CL.vcAutores,
	       CL.siAnhoPublicacion,
	       CL.vcCiudadPublicacion, 
           CL.vcEditorial,
	       CL.tiEdicion,
	       CL.cIsbn,
		   TS.siCantidadDisponible,
		   CU.vcIdUbicacion,
		   CU.vcDescripcion,
		   COALESCE(TLV.siCantidadParaVenta, 0::SMALLINT),  -- Si los demas campos son nulos
		   COALESCE(TLV.decPrecioUnitario, 0::DECIMAL(7, 2)),
		   TST.siCantidadTotal
    FROM CTLG_LIBRO CL  -- Datos del libro
    INNER JOIN CTLG_LIBRO_CATEGORIA CLC  -- Categoria del libro
		ON CL.cIdCategoria = CLC.cIdCategoria
	INNER JOIN TBL_STOCK TS  -- Stock del libro
		ON CL.vcIdLibro = TS.vcIdLibro
	INNER JOIN CTLG_UBICACION CU  -- Ubicacion del libro por cada stock
		ON TS.vcIdUbicacion = CU.vcIdUbicacion
	LEFT JOIN TBL_LIBRO_VENTA TLV  -- Datos de venta del libro (si existen)
		ON CL.vcIdLibro = TLV.vcIdLibro
	INNER JOIN (SELECT TS.vcIdLibro, SUM(TS.siCantidadDisponible)::SMALLINT AS siCantidadTotal  -- Stock del libro en total
		FROM TBL_STOCK TS
		GROUP BY TS.vcIdLibro) TST  -- TBL_STOCK_TOTAL
		ON TS.vcIdLibro = TST.vcIdLibro
	ORDER BY CL.vcIdLibro;
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar datos de libros
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_LIBROS()
RETURNS TABLE (
	vcIdLibro VARCHAR(4),
    vctitulo VARCHAR(150),
	vcCategoria VARCHAR(30),
    vcAutores VARCHAR(300),
    siAnhoPublicacion SMALLINT,
    vcCiudadPublicacion VARCHAR(100),
    vcEditorial VARCHAR(100),
    tiEdicion SMALLINT,
    cIsbn CHAR(13)
) AS $$
BEGIN
    RETURN QUERY
    SELECT CL.vcIdLibro,
		   CL.vcTitulo,
		   CLC.vcCategoria,
		   CL.vcAutores,
	       CL.siAnhoPublicacion,
	       CL.vcCiudadPublicacion, 
           CL.vcEditorial,
	       CL.tiEdicion,
	       CL.cIsbn
    FROM CTLG_LIBRO CL
    INNER JOIN CTLG_LIBRO_CATEGORIA CLC
		ON CL.cIdCategoria = CLC.cIdCategoria;
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar el stock disponible de los libros
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_LIBROS_STOCK()
RETURNS TABLE (
	vcIdLibro VARCHAR(4),
    vcTitulo VARCHAR(150),
	vcCategoria VARCHAR(30),
    vcAutores VARCHAR(300),
    siAnhoPublicacion SMALLINT,
    vcCiudadPublicacion VARCHAR(100),
    vcEditorial VARCHAR(100),
    tiEdicion SMALLINT,
    cIsbn CHAR(13),
	iIdStock INT,
	siCantidadDisponible SMALLINT,
	vcIdUbicacion VARCHAR(3),
	vcDescripcionUbicacion VARCHAR(40),
	siCantidadTotal SMALLINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT CL.vcIdLibro,
		   CL.vcTitulo,
		   CLC.vcCategoria,
		   CL.vcAutores,
	       CL.siAnhoPublicacion,
	       CL.vcCiudadPublicacion, 
           CL.vcEditorial,
	       CL.tiEdicion,
	       CL.cIsbn,
		   TS.iIdStock,
		   TS.siCantidadDisponible,
		   CU.vcIdUbicacion,
		   CU.vcDescripcion,
		   TST.siCantidadTotal
    FROM CTLG_LIBRO CL  -- Datos del libro
    INNER JOIN CTLG_LIBRO_CATEGORIA CLC  -- Categoria del libro
		ON CL.cIdCategoria = CLC.cIdCategoria
	INNER JOIN TBL_STOCK TS  -- Stock del libro
		ON CL.vcIdLibro = TS.vcIdLibro
	INNER JOIN CTLG_UBICACION CU  -- Ubicacion del libro por cada stock
		ON TS.vcIdUbicacion = CU.vcIdUbicacion
	INNER JOIN (SELECT TS.vcIdLibro, SUM(TS.siCantidadDisponible)::SMALLINT AS siCantidadTotal  -- Stock del libro en total
		FROM TBL_STOCK TS
		GROUP BY TS.vcIdLibro) TST  -- TBL_STOCK_TOTAL
		ON TS.vcIdLibro = TST.vcIdLibro
	ORDER BY CL.vcIdLibro;
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar la cantidad disponible de libros para venta y el precio
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_LIBROS_VENTAS()
RETURNS TABLE (
	vcIdLibro VARCHAR(4),
    vcTitulo VARCHAR(150),
	vcCategoria VARCHAR(30),
    vcAutores VARCHAR(300),
    siAnhoPublicacion SMALLINT,
    vcCiudadPublicacion VARCHAR(100),
    vcEditorial VARCHAR(100),
    tiEdicion SMALLINT,
    cIsbn CHAR(13),
	iIdStock INT,
	siCantidadDisponible SMALLINT,
	vcIdUbicacion VARCHAR(3),
	vcDescripcionUbicacion VARCHAR(40),
	cIdLibroVenta CHAR(4),
	siCantidadParaVenta SMALLINT,
	decPrecioUnitario DECIMAL(7, 2),
	siCantidadTotal SMALLINT
) AS $$
BEGIN
    RETURN QUERY
    SELECT CL.vcIdLibro,
		   CL.vcTitulo,
		   CLC.vcCategoria,
		   CL.vcAutores,
	       CL.siAnhoPublicacion,
	       CL.vcCiudadPublicacion, 
           CL.vcEditorial,
	       CL.tiEdicion,
	       CL.cIsbn,
		   TS.iIdStock,
		   TS.siCantidadDisponible,
		   CU.vcIdUbicacion,
		   CU.vcDescripcion,
		   TLV.cIdLibroVenta,
		   TLV.siCantidadParaVenta,
		   TLV.decPrecioUnitario,
		   TST.siCantidadTotal
    FROM CTLG_LIBRO CL  -- Datos del libro
    INNER JOIN CTLG_LIBRO_CATEGORIA CLC  -- Categoria del libro
		ON CL.cIdCategoria = CLC.cIdCategoria
	INNER JOIN TBL_STOCK TS  -- Stock del libro
		ON CL.vcIdLibro = TS.vcIdLibro
	INNER JOIN CTLG_UBICACION CU  -- Ubicacion del libro por cada stock
		ON TS.vcIdUbicacion = CU.vcIdUbicacion
	INNER JOIN TBL_LIBRO_VENTA TLV  -- Datos de venta del libro (si existen)
		ON CL.vcIdLibro = TLV.vcIdLibro
	INNER JOIN (SELECT TS.vcIdLibro, SUM(TS.siCantidadDisponible)::SMALLINT AS siCantidadTotal  -- Stock del libro en total
		FROM TBL_STOCK TS
		GROUP BY TS.vcIdLibro) TST  -- TBL_STOCK_TOTAL
		ON TS.vcIdLibro = TST.vcIdLibro
	ORDER BY CL.vcIdLibro;
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar prestamos activos, renovados y retrasados
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_PRESTAMOS()
RETURNS TABLE (
	vcIdPrestamo VARCHAR(6),
	dFechaPrestamo DATE,
	dFechaDevolucion DATE,
	vcNombreCompleto TEXT,
    vcTelefono VARCHAR(15),
	vcCorreoElectronico VARCHAR(254),
	vcEstado VARCHAR(40),
	vcTitulo VARCHAR(150),
	vcCategoria VARCHAR(30),
	vcAutores VARCHAR(300),
	siAnhoPublicacion SMALLINT,
	vcCiudadPublicacion VARCHAR(100),
	vcEditorial VARCHAR(100),
	tiEdicion SMALLINT,
	cIsbn CHAR(13)
) AS $$
BEGIN
	-- Primero actualizar el estado de los prestamos
	CALL SPD_ACTUALIZAR_PRESTAMOS();

    RETURN QUERY
    SELECT TP.vcIdPrestamo,
		   TP.dFechaPrestamo,
		   TP.dFechaDevolucion,
		   (TP2.vcNombre || ' ' || TP2.vcApellidoPaterno || ' ' || TP2.vcApellidoMaterno) AS vcNombreCompleto,
		   TP2.vcTelefono,
		   TP2.vcCorreoElectronico,
		   CE.vcEstado,
	       CL.vcTitulo,
		   CLC.vcCategoria,
	       CL.vcAutores,
	       CL.siAnhoPublicacion,
	       CL.vcCiudadPublicacion,
	       CL.vcEditorial,
	       CL.tiEdicion,
	       CL.cIsbn
	FROM TBL_PRESTAMO TP  -- Prestamos
	INNER JOIN TBL_USUARIO TU  -- Usuarios asociados a los prestamos
		ON TP.vcIdUsuario = TU.vcIdUsuario
	INNER JOIN TBL_PERSONA TP2  -- Datos personales de los usuarios
		ON TU.vcIdPersona = TP2.vcIdPersona
	INNER JOIN CTLG_ESTADO CE  -- Estados de los prestamos
		ON TP.iIdEstado = CE.iIdEstado
	INNER JOIN CTLG_LIBRO CL  -- Datos de los libros asociados a los prestamos
		ON TP.vcIdLibro = CL.vcIdLibro
	INNER JOIN CTLG_LIBRO_CATEGORIA CLC  -- Categoria de los libros
		ON CL.cIdCategoria = CLC.cIdCategoria
	WHERE CE.iIdEstado IN (101, 103, 104);  -- Prestamos activos, renovados y retrasados
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar el contacto de un usuario
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_USUARIO_CONTACTO(
	pVcIdUsuario VARCHAR(7)
)
RETURNS TABLE (
	vcNombreCompleto TEXT,
    vcTelefono VARCHAR(15),
	vcCorreoElectronico VARCHAR(254)
) AS $$
BEGIN
    RETURN QUERY
    SELECT (TP.vcNombre || ' ' || TP.vcApellidoPaterno || ' ' || TP.vcApellidoMaterno) AS vcNombreCompleto,
		   TP.vcTelefono,
		   TP.vcCorreoElectronico
	FROM TBL_USUARIO TU  -- Usuarios
	INNER JOIN TBL_PERSONA TP  -- Datos personales de los usuarios
		ON TU.vcIdPersona = TP.vcIdPersona
	INNER JOIN CTLG_ESTADO CE  -- Estados de los usuarios
		ON TU.iIdEstado = CE.iIdEstado
	WHERE CE.iIdEstado = 1  -- Usuario habilitado
		AND TU.vcIdUsuario = pVcIdUsuario;
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar el contacto de los usuarios
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_USUARIOS_CONTACTOS()
RETURNS TABLE (
	vcNombreCompleto TEXT,
	vcTelefono VARCHAR(15),
	vcCorreoElectronico VARCHAR(254),
    vcIdUsuario VARCHAR(7),
	iIdEstado INT,
	vcEstado VARCHAR(40),
	vcIdSuspension VARCHAR(5)
) AS $$
BEGIN
    RETURN QUERY
    SELECT (TP.vcNombre || ' ' || TP.vcApellidoPaterno || ' ' || TP.vcApellidoMaterno) AS vcNombreCompleto,
		   TP.vcTelefono,
		   TP.vcCorreoElectronico,
		   TU.vcIdUsuario,
		   CE.iIdEstado,
		   CE.vcEstado,
		   TSV.vcIdSuspension
	FROM TBL_USUARIO TU  -- Usuarios
	INNER JOIN TBL_PERSONA TP  -- Datos personales de los usuarios
		ON TU.vcIdPersona = TP.vcIdPersona
	INNER JOIN CTLG_ESTADO CE  -- Estados de los usuarios
		ON TU.iIdEstado = CE.iIdEstado
	LEFT JOIN (SELECT TS.vcIdSuspension,
					   TS.vcIdUsuario
			FROM TBL_SUSPENSION TS
			WHERE TS.iIdEstado = 1001) TSV  -- TBL_SUSPENSION_VIGENTE
		ON TU.vcIdUsuario = TSV.vcIdUsuario;
END;
$$ LANGUAGE plpgsql;



/*
 * Consultar usuarios habilitados
 */
CREATE OR REPLACE FUNCTION FN_CONSULTAR_USUARIOS_HABILITADOS()
RETURNS TABLE (
	vcNombreCompleto TEXT,
    vcIdUsuario VARCHAR(7)
) AS $$
BEGIN
    RETURN QUERY
    SELECT (TP.vcNombre || ' ' || TP.vcApellidoPaterno || ' ' || TP.vcApellidoMaterno) AS vcNombreCompleto,
		   TU.vcIdUsuario
	FROM TBL_USUARIO TU  -- Usuarios
	INNER JOIN TBL_PERSONA TP  -- Datos personales de los usuarios
		ON TU.vcIdPersona = TP.vcIdPersona
	INNER JOIN CTLG_ESTADO CE  -- Estados de los usuarios
		ON TU.iIdEstado = CE.iIdEstado
	WHERE CE.iIdEstado = 1;  -- Usuario habilitado
END;
$$ LANGUAGE plpgsql;
