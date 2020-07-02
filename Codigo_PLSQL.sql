SET SERVEROUTPUT ON

DROP TABLE ServiciosNoContratados;
DROP SEQUENCE sec_serv_NoContratados;
DROP TABLE Gerentes;
DROP TABLE ServiciosContratados;
DROP SEQUENCE sec_serv_contratados;
DROP TABLE Tratamientos;
DROP SEQUENCE sec_tratamientos;
DROP TABLE Trabajadores;
DROP SEQUENCE sec_trabajadores;
DROP TABLE Facturas;
DROP SEQUENCE sec_facturas;
DROP TABLE Vehiculos;
DROP TABLE Clientes;

--Crear Tablas


CREATE TABLE Clientes(
DNI_CIF VARCHAR2(9) NOT NULL CHECK (REGEXP_LIKE(DNI_CIF, '[A-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]')),
Contrasena VARCHAR2(25) NOT NULL,
Telefono NUMBER(9) NOT NULL,
Email VARCHAR2(25),
TipoCliente VARCHAR2(25),
Nombre VARCHAR2(30) NOT NULL,
FormaPago VARCHAR2(20),
NumeroCuenta VARCHAR2 (24),
CancelacionesIndebidas INT CHECK (CancelacionesIndebidas BETWEEN 0 and 3),
PRIMARY KEY(DNI_CIF),
CONSTRAINT Clientes_chk1 CHECK (TipoCliente IN ('Particular', 'Empresa', 'Administracion Publica'))
);

CREATE TABLE Vehiculos(
Matricula VARCHAR2(10) NOT NULL,
MarcaModelo VARCHAR2(40),
KmTotales INT,
NumBastidor VARCHAR2(18),
FechaProxITV DATE,
FechaExpSeguro DATE,
PRIMARY KEY (Matricula)
);

CREATE TABLE Facturas(
NumeroFactura INT NOT NULL,
Contrato VARCHAR2(10) NOT NULL,
Fecha DATE,
Serie VARCHAR2(20),
Concepto VARCHAR2(50),
Base INT,
TipoImpositivo INT,
IVA INT,
Total INT,
FechaPago DATE,
Importe NUMBER(7,2),
FormaPago VARCHAR2(15),
Codigo VARCHAR2(20),
Status VARCHAR2(10),
Pago SMALLINT CHECK(Pago=0 OR Pago=1),
Recepcion SMALLINT CHECK(Recepcion=0 OR Recepcion=1),
PersonaRecepcion VARCHAR2(20),
FechaRecepcion DATE,
Observaciones VARCHAR2(300),
PRIMARY KEY(NumeroFactura)
);

CREATE SEQUENCE sec_facturas INCREMENT BY 1 START WITH 1;

CREATE TABLE Trabajadores(
NumeroTrabajador INT NOT NULL,
Nombre VARCHAR2(40) NOT NULL,
DNI VARCHAR2(9) NOT NULL CHECK (REGEXP_LIKE(DNI, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]')),
Contrasena VARCHAR2(25) NOT NULL,
NumTlf INT,
Direccion VARCHAR2(60),
HorasSemanales INT,
HorasMensuales INT,
HorasExtras INT,
NumCuentaCorriente VARCHAR(24),
NumSeguridadSocial VARCHAR(26),
Formacion VARCHAR(200),
Matricula VARCHAR(10),
PRIMARY KEY(NumeroTrabajador),
FOREIGN KEY (Matricula) references Vehiculos
);

CREATE SEQUENCE sec_trabajadores INCREMENT BY 1 START WITH 1;

CREATE TABLE Tratamientos(
ID_T INT NOT NULL,
Peligro VARCHAR2(300),
Mascara VARCHAR2(2) CHECK(Mascara='Si' OR Mascara='No'),
Abandono VARCHAR2(2) CHECK(Abandono='Si' OR Abandono= 'No'),
PRIMARY KEY (ID_T)
);

CREATE SEQUENCE sec_tratamientos INCREMENT BY 1 START WITH 1;

CREATE TABLE ServiciosContratados(
ID_SC INT PRIMARY KEY NOT NULL,
Fecha DATE NOT NULL,
Hora VARCHAR2(50),
Lugar VARCHAR2(50) NOT NULL,
Duracion NUMBER(6,2) NOT NULL,
Observaciones VARCHAR2(300 BYTE) NOT NULL,
DNI_CIF VARCHAR2(9 BYTE) NOT NULL,
NumeroFactura INT,
NumeroTrabajador INT NOT NULL,
ID_T INT NOT NULL,
Completado VARCHAR2(50),
TipoTratamiento VARCHAR2(50),
TipoMaquinas VARCHAR2(50),
TipoMateriales VARCHAR2(50),
TipoServicios VARCHAR2(50),
TipoPlagas VARCHAR2(50),
FOREIGN KEY (DNI_CIF) references Clientes,
FOREIGN KEY (NumeroFactura) references Facturas,
FOREIGN KEY (NumeroTrabajador) references Trabajadores,
FOREIGN KEY (ID_T) references Tratamientos
);

CREATE SEQUENCE sec_serv_contratados INCREMENT BY 1 START WITH 1;


CREATE TABLE Gerentes (
DNI CHAR(9) NOT NULL CHECK (REGEXP_LIKE(DNI, '[0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][A-Z]')),
Contrasena VARCHAR2(25) NOT NULL,
Nombre VARCHAR2(40) NOT NULL,
NumeroTelefono CHAR(9),
NumeroCuenta CHAR(24),
CorreoElectronico VARCHAR(50),
PRIMARY KEY (DNI)
);

CREATE TABLE ServiciosNoContratados(
ID_SNC INT PRIMARY KEY NOT NULL,
Fecha DATE NOT NULL,
Hora VARCHAR2(50),
Duracion NUMBER(4,2),
Observaciones VARCHAR2(300 BYTE),
DNI_CIF VARCHAR2(9 BYTE) NOT NULL,
TipoTratamiento VARCHAR2(50),
TipoMaquinas VARCHAR2(50),
TipoMateriales VARCHAR2(50),
TipoServicios VARCHAR2(50),
TipoPlagas VARCHAR2(50),
FOREIGN KEY (DNI_CIF) references Clientes
);

CREATE SEQUENCE sec_serv_NoContratados INCREMENT BY 1 START WITH 1;

--Inserts
/
CREATE OR REPLACE PACKAGE INSERTS AS

    PROCEDURE insert_clientes(w_DNI_CIF clientes.dni_cif%TYPE,w_Contrasena clientes.contrasena%TYPE,w_Telefono clientes.telefono%TYPE,w_Email clientes.email%TYPE,
    w_TipoCliente clientes.tipocliente%TYPE,w_Nombre clientes.nombre%TYPE,
    w_FormaPago clientes.formapago%TYPE,w_NumeroCuenta clientes.numerocuenta%TYPE,
    w_CancelacionesIndebidas clientes.cancelacionesindebidas%TYPE);
    PROCEDURE insert_vehiculos(w_Matricula vehiculos.matricula%TYPE, w_MarcaModelo vehiculos.marcamodelo%TYPE,
    w_KmTotales vehiculos.matricula%TYPE,w_NumBastidor vehiculos.numbastidor%TYPE, w_FechaProxITV vehiculos.fechaproxitv%TYPE,
    w_FechaExpSeguro vehiculos.fechaexpseguro%TYPE);
    PROCEDURE insert_facturas(w_Contrato facturas.contrato%TYPE,w_Fecha facturas.fecha%TYPE,w_Serie facturas.serie%TYPE,
    w_Concepto facturas.concepto%TYPE,w_Base facturas.base%TYPE,w_TipoImpositivo facturas.tipoimpositivo%TYPE,
    w_IVA facturas.iva%TYPE,w_Total facturas.total%TYPE,w_FechaPago facturas.fechapago%TYPE,w_Importe facturas.importe%TYPE,
    W_FormaPago facturas.formapago%TYPE,w_Codigo facturas.codigo%TYPE,w_Status facturas.status%TYPE,w_Pago facturas.status%TYPE,
    w_Recepcion facturas.recepcion%TYPE,w_PersonaRecepcion facturas.personarecepcion%TYPE,
    w_FechaRecepcion facturas.fecharecepcion%TYPE,w_Observaciones facturas.observaciones%TYPE);
    PROCEDURE insert_Trabajadores(w_Nombre Trabajadores.Nombre%TYPE,w_DNI Trabajadores.DNI%TYPE,w_Contrasena Trabajadores.contrasena%TYPE,
    w_NumTlf Trabajadores.NumTlf%TYPE,w_Direccion Trabajadores.Direccion%TYPE,w_HorasSemanales Trabajadores.HorasSemanales%TYPE,
    w_HorasMensuales Trabajadores.HorasMensuales%TYPE,w_HorasExtras Trabajadores.HorasExtras%TYPE,
    w_NumCuentaCorriente Trabajadores.NumCuentaCorriente%TYPE, w_NumSeguridadSocial Trabajadores.NumSeguridadSocial%TYPE,
    w_Formacion Trabajadores.Formacion%TYPE, w_Matricula Trabajadores.Matricula%TYPE);
    PROCEDURE insert_Tratamientos(w_Peligro Tratamientos.Peligro%TYPE,w_Mascara Tratamientos.Mascara%TYPE ,w_Abandono Tratamientos.Abandono%TYPE);
    PROCEDURE insert_servicios_contratados(w_Fecha servicioscontratados.fecha%TYPE,w_Hora servicioscontratados.Hora%TYPE,w_Lugar servicioscontratados.lugar%TYPE,
    w_Duracion servicioscontratados.duracion%TYPE,
    w_Observaciones servicioscontratados.observaciones%TYPE,w_DNI_CIF servicioscontratados.dni_cif%TYPE,
    w_NumeroFactura servicioscontratados.numerofactura%TYPE,w_NumeroTrabajador servicioscontratados.numerotrabajador%TYPE,
    w_ID_T servicioscontratados.id_t%TYPE,w_Completado servicioscontratados.Completado%TYPE,w_TipoTratamiento servicioscontratados.TipoTratamiento%TYPE,
    w_TipoMaquinas servicioscontratados.TipoMaquinas%TYPE,w_TipoMateriales servicioscontratados.TipoMateriales%TYPE,
    w_TipoServicios servicioscontratados.TipoServicios%TYPE, w_TipoPlagas servicioscontratados.TipoPlagas%TYPE);
    PROCEDURE insert_gerentes(w_DNI gerentes.dni%TYPE,w_Contrasena gerentes.contrasena%TYPE,w_Nombre gerentes.nombre%TYPE,w_NumeroTelefono gerentes.numerotelefono%TYPE,
    w_NumeroCuenta gerentes.numerocuenta%TYPE,w_CorreoElectronico gerentes.correoelectronico%TYPE);
    PROCEDURE insert_servicios_NoContratados(w_Fecha serviciosnocontratados.fecha%TYPE,w_Hora serviciosnocontratados.Hora%TYPE,w_Duracion serviciosnocontratados.duracion%TYPE,
    w_Observaciones serviciosnocontratados.observaciones%TYPE,w_DNI_CIF serviciosnocontratados.dni_cif%TYPE,w_TipoTratamiento serviciosnocontratados.TipoTratamiento%TYPE,
    w_TipoMaquinas serviciosnocontratados.TipoMaquinas%TYPE,w_TipoMateriales serviciosnocontratados.TipoMateriales%TYPE,
    w_TipoServicios serviciosnocontratados.TipoServicios%TYPE, w_TipoPlagas serviciosnocontratados.TipoPlagas%TYPE);

END INSERTS;
/
CREATE OR REPLACE PACKAGE BODY INSERTS AS 


PROCEDURE insert_clientes(w_DNI_CIF clientes.dni_cif%TYPE,w_Contrasena clientes.contrasena%TYPE,w_Telefono clientes.telefono%TYPE,w_Email clientes.email%TYPE,
w_TipoCliente clientes.tipocliente%TYPE,w_Nombre clientes.nombre%TYPE,w_FormaPago clientes.formapago%TYPE,w_NumeroCuenta clientes.numerocuenta%TYPE,
w_CancelacionesIndebidas clientes.cancelacionesindebidas%TYPE)
IS

BEGIN

INSERT INTO Clientes (DNI_CIF,Contrasena,Telefono,Email,TipoCliente,Nombre,FormaPago,NumeroCuenta,CancelacionesIndebidas)
VALUES(w_DNI_CIF,w_Contrasena,w_Telefono,w_Email,w_TipoCliente,w_Nombre,w_FormaPago,w_NumeroCuenta,w_CancelacionesIndebidas);

END insert_clientes;

PROCEDURE insert_vehiculos
(w_Matricula vehiculos.matricula%TYPE, w_MarcaModelo vehiculos.marcamodelo%TYPE, w_KmTotales vehiculos.matricula%TYPE,
w_NumBastidor vehiculos.numbastidor%TYPE, w_FechaProxITV vehiculos.fechaproxitv%TYPE, w_FechaExpSeguro vehiculos.fechaexpseguro%TYPE)
IS

BEGIN

INSERT INTO Vehiculos(Matricula, MarcaModelo, KmTotales, NumBastidor, FechaProxITV, FechaExpSeguro) 
VALUES (w_Matricula,w_MarcaModelo,w_KmTotales,w_NumBastidor,w_FechaProxITV,w_FechaExpSeguro);

END insert_vehiculos;

PROCEDURE insert_facturas
(w_Contrato facturas.contrato%TYPE,w_Fecha facturas.fecha%TYPE,w_Serie facturas.serie%TYPE,w_Concepto facturas.concepto%TYPE,
w_Base facturas.base%TYPE,w_TipoImpositivo facturas.tipoimpositivo%TYPE,w_IVA facturas.iva%TYPE,w_Total facturas.total%TYPE,
w_FechaPago facturas.fechapago%TYPE,w_Importe facturas.importe%TYPE,W_FormaPago facturas.formapago%TYPE,
w_Codigo facturas.codigo%TYPE,w_Status facturas.status%TYPE,w_Pago facturas.status%TYPE,w_Recepcion facturas.recepcion%TYPE,
w_PersonaRecepcion facturas.personarecepcion%TYPE,w_FechaRecepcion facturas.fecharecepcion%TYPE,
w_Observaciones facturas.observaciones%TYPE)
IS

BEGIN

INSERT INTO Facturas(NumeroFactura,Contrato,Fecha,Serie,Concepto,Base,TipoImpositivo,IVA,Total,FechaPago,Importe,
FormaPago,Codigo,Status,Pago,Recepcion,PersonaRecepcion,FechaRecepcion,Observaciones) VALUES 
(SEC_FACTURAS.nextval,w_Contrato,w_Fecha,w_Serie,w_Concepto,w_Base,w_TipoImpositivo,w_IVA,w_Total,w_FechaPago,w_Importe,
W_FormaPago,w_Codigo,w_Status,w_Pago,w_Recepcion,w_PersonaRecepcion,w_FechaRecepcion,w_Observaciones);

END insert_facturas;

PROCEDURE insert_Trabajadores(w_Nombre Trabajadores.Nombre%TYPE,w_DNI Trabajadores.DNI%TYPE,w_Contrasena Trabajadores.contrasena%TYPE,
w_NumTlf Trabajadores.NumTlf%TYPE,w_Direccion Trabajadores.Direccion%TYPE,w_HorasSemanales Trabajadores.HorasSemanales%TYPE,
w_HorasMensuales Trabajadores.HorasMensuales%TYPE,w_HorasExtras Trabajadores.HorasExtras%TYPE,
w_NumCuentaCorriente Trabajadores.NumCuentaCorriente%TYPE, w_NumSeguridadSocial Trabajadores.NumSeguridadSocial%TYPE,
w_Formacion Trabajadores.Formacion%TYPE, w_Matricula Trabajadores.Matricula%TYPE)
IS

BEGIN

INSERT INTO Trabajadores(NumeroTrabajador,Nombre,DNI,Contrasena,NumTlf,Direccion,HorasSemanales,HorasMensuales,HorasExtras,
NumCuentaCorriente,NumSeguridadSocial,Formacion, Matricula)
VALUES(SEC_TRABAJADORES.nextval,w_Nombre,w_DNI,w_Contrasena,w_NumTlf,w_Direccion,w_HorasSemanales,w_HorasMensuales,w_HorasExtras,
w_NumCuentaCorriente,w_NumSeguridadSocial,w_Formacion,w_Matricula);

END insert_Trabajadores;


PROCEDURE insert_Tratamientos(w_Peligro Tratamientos.Peligro%TYPE,w_Mascara Tratamientos.Mascara%TYPE ,w_Abandono Tratamientos.Abandono%TYPE)
IS

BEGIN

INSERT INTO Tratamientos(ID_T, Peligro, Mascara, Abandono)
VALUES(SEC_TRATAMIENTOS.nextval, w_Peligro, w_Mascara, w_Abandono);

END insert_Tratamientos;


PROCEDURE insert_servicios_contratados(w_Fecha servicioscontratados.fecha%TYPE,w_Hora servicioscontratados.Hora%TYPE,w_Lugar servicioscontratados.lugar%TYPE,
w_Duracion servicioscontratados.duracion%TYPE,
w_Observaciones servicioscontratados.observaciones%TYPE,w_DNI_CIF servicioscontratados.dni_cif%TYPE,
w_NumeroFactura servicioscontratados.numerofactura%TYPE,w_NumeroTrabajador servicioscontratados.numerotrabajador%TYPE,
w_ID_T servicioscontratados.id_t%TYPE,w_Completado servicioscontratados.Completado%TYPE,w_TipoTratamiento servicioscontratados.TipoTratamiento%TYPE,
w_TipoMaquinas servicioscontratados.TipoMaquinas%TYPE,w_TipoMateriales servicioscontratados.TipoMateriales%TYPE,
w_TipoServicios servicioscontratados.TipoServicios%TYPE, w_TipoPlagas servicioscontratados.TipoPlagas%TYPE)
IS

BEGIN

INSERT INTO servicioscontratados(ID_SC,Fecha,Hora,Lugar,Duracion,Observaciones,DNI_CIF,NumeroFactura,NumeroTrabajador,ID_T,Completado,TipoTratamiento,TipoMaquinas,
TipoMateriales,TipoServicios,TipoPlagas)
VALUES(SEC_SERV_CONTRATADOS.nextval,w_Fecha,w_Hora,w_Lugar,w_Duracion,w_Observaciones,w_DNI_CIF,w_NumeroFactura,w_NumeroTrabajador,
w_ID_T,w_Completado,w_TipoTratamiento,w_TipoMaquinas,w_TipoMateriales,w_TipoServicios,w_TipoPlagas);

END insert_servicios_contratados;


PROCEDURE insert_gerentes(w_DNI gerentes.dni%TYPE,w_Contrasena gerentes.contrasena%TYPE,w_Nombre gerentes.nombre%TYPE,w_NumeroTelefono gerentes.numerotelefono%TYPE,
w_NumeroCuenta gerentes.numerocuenta%TYPE,w_CorreoElectronico gerentes.correoelectronico%TYPE)
IS

BEGIN

INSERT INTO gerentes(DNI,Contrasena,Nombre,NumeroTelefono,NumeroCuenta,CorreoElectronico)
VALUES(w_DNI,w_Contrasena,w_Nombre,w_NumeroTelefono,w_NumeroCuenta,w_CorreoElectronico);

END insert_gerentes;


PROCEDURE insert_servicios_NoContratados(w_Fecha serviciosnocontratados.fecha%TYPE,w_Hora serviciosnocontratados.Hora%TYPE,w_Duracion serviciosnocontratados.duracion%TYPE,
w_Observaciones serviciosnocontratados.observaciones%TYPE,w_DNI_CIF serviciosnocontratados.dni_cif%TYPE,w_TipoTratamiento serviciosnocontratados.TipoTratamiento%TYPE,
w_TipoMaquinas serviciosnocontratados.TipoMaquinas%TYPE,w_TipoMateriales serviciosnocontratados.TipoMateriales%TYPE,
w_TipoServicios serviciosnocontratados.TipoServicios%TYPE, w_TipoPlagas serviciosnocontratados.TipoPlagas%TYPE)
IS

BEGIN

INSERT INTO serviciosNoContratados(ID_SNC,Fecha,Hora,Duracion,Observaciones,DNI_CIF,TipoTratamiento,TipoMaquinas,TipoMateriales,TipoServicios,TipoPlagas)
VALUES(sec_serv_NoContratados.nextval,w_Fecha,w_Hora,w_Duracion,w_Observaciones,w_DNI_CIF,w_TipoTratamiento,w_TipoMaquinas,w_TipoMateriales,w_TipoServicios,w_TipoPlagas);

END insert_servicios_NoContratados;
END INSERTS;
/
BEGIN

INSERTS.insert_clientes('11111111B','123456Aa',655655655,'manu@ordo.com','Particular','Manuel Ordoñez','Tarjeta','ES7119283746594039280192',0);
INSERTS.insert_clientes('S7370954E','123456Aa',611611611,'rbb@rbb.com','Empresa','RBB','En mano','Tarjeta',1);
INSERTS.insert_clientes('W9287643B','123456Aa',622622622,'ayto@sevilla.com','Administracion Publica','Ayto Sevilla','Tarjeta','ES7483972844736182093876',0);
INSERTS.insert_clientes('L9304928C','123456Aa',633633633,'sfc@sfc.com','Empresa','SFC','Tarjeta','ES7119283746594025789654',2);
INSERTS.insert_clientes('77777777T','123456Aa',644644644,'mercede@ink.com','Particular','Mercedes Gomez','Tarjeta','ES7119225879874039280192',2);
INSERTS.insert_clientes('12312389P','123456Aa',666666666,'una@muno.com','Particular','Miguel de Unamuno','Tarjeta','ES7119225879874039280971',0);
INSERTS.insert_clientes('12312378A','123456Aa',677677677,'mer@benz.com','Empresa','Mercedes Benz','Tarjeta','ES7119225879874039280369',1);
INSERTS.insert_clientes('12312367I','123456Aa',688688688,'mer@gome.com','Particular','Mercedes Gomez','Tarjeta','ES7119225879874039280654',1);
INSERTS.insert_clientes('12312356U','123456Aa',699699699,'bli@zzard.com','Empresa','Blizzard','Tarjeta','ES7119225879874039280482',0);


INSERTS.insert_vehiculos('SE 5540 MC', 'Opel Karl',100000,'WWWZZZ1JZ3W269546',to_date('1-1-2020','dd-mm-yyyy'), to_date('2-2-2021','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 6666 BK', 'Bugatti Veyron',50000,'GGGPP1UI2P2965453',to_date('3-3-2023','dd-mm-yyyy'), to_date('4-4-2024','dd-mm-yyyy'));
INSERTS.insert_vehiculos('Se 5000 CR', 'Furgoneta Citroën Berlingo First',200000,'WWWPPP1JZ3W789523',to_date('5-5-2020','dd-mm-yyyy'), to_date('6-6-2026','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 1000 PE', 'Furgoneta Renault Kangoo',500000,'WWWZZZ1JZ3W269547',to_date('12-1-2020','dd-mm-yyyy'), to_date('7-2-2021','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 2000 PI', 'Furgoneta Renault Master',250000,'WWWZZZ1JZ3W269548',to_date('13-1-2020','dd-mm-yyyy'), to_date('6-2-2021','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 3000 PA', 'Toyota Proace',110000,'WWWZZZ1JZ3W269548',to_date('14-1-2020','dd-mm-yyyy'), to_date('5-2-2021','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 4000 PO', 'Camión Toyota Dyna',100001,'WWWZZZ1JZ3W269549',to_date('15-1-2020','dd-mm-yyyy'), to_date('4-2-2021','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 6000 PU', 'Mercedes-Benz Vito',100002,'WWWZZZ1JZ3W269540',to_date('16-1-2020','dd-mm-yyyy'), to_date('3-2-2021','dd-mm-yyyy'));
INSERTS.insert_vehiculos('SE 5000 IU', 'Ford Fiesta',100003,'WWWZZZ1JZ3W289540',to_date('10-1-2020','dd-mm-yyyy'), to_date('23-2-2021','dd-mm-yyyy'));


INSERTS.insert_facturas('15263849EA',to_date('5-9-2017','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('10-11-2017','dd-mm-yyyy'),'102,24','Transferencia','1209381','Pagado',1,0,'Ismael',to_date('13-10-2017','dd-mm-yyyy'),null);
INSERTS.insert_facturas('15234249EB',to_date('10-8-2018','dd-mm-yyyy'),'Cambiar','Mantenimiento',10,3,21,28,null,'102,24',null,null,'En deuda',0,0,null,null,null);
INSERTS.insert_facturas('15263889AC',to_date('12-9-2018','dd-mm-yyyy'),'Cambiar','Desratizacion',10,0,21,31,to_date('10-10-2018','dd-mm-yyyy'),'1002,67','Talon','1209314','Pagado',1,1,'Rafael',to_date('10-10-2018','dd-mm-yyyy'),null);
INSERTS.insert_facturas('25263849EA',to_date('6-1-2018','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('11-11-2017','dd-mm-yyyy'),'103,24','Transferencia','1209382','Pagado',1,0,'Rafael',to_date('13-10-2017','dd-mm-yyyy'),null);
INSERTS.insert_facturas('35263849EA',to_date('5-2-2018','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('10-11-2017','dd-mm-yyyy'),'102,24','Transferencia','1209383','Pagado',1,0,'Rafael',to_date('14-10-2017','dd-mm-yyyy'),null);
INSERTS.insert_facturas('45263849EA',to_date('18-1-2019','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('10-11-2017','dd-mm-yyyy'),'103,24','Transferencia','1209384','Pagado',1,0,'Ismael',to_date('15-10-2017','dd-mm-yyyy'),null);
INSERTS.insert_facturas('55263849EA',to_date('19-9-2017','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('10-11-2017','dd-mm-yyyy'),'102,24','Transferencia','1209385','Pagado',1,0,'Ismael',to_date('16-10-2017','dd-mm-yyyy'),null);
INSERTS.insert_facturas('65263849EA',to_date('20-9-2017','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('10-11-2017','dd-mm-yyyy'),'102,24','Transferencia','1209386','Pagado',1,0,'Ismael',to_date('17-10-2017','dd-mm-yyyy'),null);
INSERTS.insert_facturas('75263849EA',to_date('21-9-2017','dd-mm-yyyy'),'Cambiar','Limpieza de canal',10,5,21,26,to_date('10-11-2017','dd-mm-yyyy'),'102,24','Transferencia','1209387','Pagado',1,0,'Ismael',to_date('18-10-2017','dd-mm-yyyy'),null);

--Aquí para ejecutar las pruebas de trabajadores
--end;

INSERTS.insert_Trabajadores('Alejandro Fuentes Gomez', '98765428E','123456Aa', 666666666, 'C/Salado Nº17', 30, 150, 0, 'ES7012341234010234567890', 'XXISI123456789012',null,'SE 5540 MC');
INSERTS.insert_Trabajadores('Federico Garcia Lorca', '12345678J','123456Aa', 999999999, 'C/Tetuan Nº1', 40, 160, 2, 'ES4012341234010987643210', 'XXISI98765432112','Secundaria','SE 6666 BK');
INSERTS.insert_Trabajadores('Antonio Machado Ruiz', '78912345P','123456Aa', 333333333, 'C/Esperanza de Trina Nº9', 40, 160, 4, 'ES8585211234011234567890', 'XXISI127139689072','Grado Superior en Educacion y Control Ambiental','Se 5000 CR');
INSERTS.insert_Trabajadores('Jose Manuel Cobo Guerrero', '18765428E','123456Aa', 666666661, 'C/Salado Nº16', 35, 150, 0, 'ES7012341234010234567891', 'XXISI123456789013','Bachillerato','SE 1000 PE');
INSERTS.insert_Trabajadores('Miguel Angel Moreno Olmo', '28765428E','123456Aa', 666666662, 'C/Salado Nº15', 31, 150, 0, 'ES7012341234010234567892', 'XXISI123456789014',null,'SE 2000 PI');
INSERTS.insert_Trabajadores('Alvaro Aguilar Alhama', '38765428E','123456Aa', 666666663, 'C/Salado Nº14', 10, 150, 0, 'ES7012341234010234567893', 'XXISI123456789015','Grado Medio en Control Ambiental','SE 3000 PA');
INSERTS.insert_Trabajadores('Enrique Reina Gutierrez', '48765428E','123456Aa', 666666664, 'C/Salado Nº13', 20, 150, 0, 'ES7012341234010234567894', 'XXISI123456789016',null,'SE 4000 PO');
INSERTS.insert_Trabajadores('Miguel Ponce Melero', '58765428E','123456Aa', 666666665, 'C/Salado Nº12', 250, 150, 0, 'ES7012341234010234567895', 'XXISI123456789017',null,'SE 5000 IU');
INSERTS.insert_Trabajadores('Francisco Quintela Vela', '68765428E','123456Aa', 666666667, 'C/Salado Nº11', 29 ,150, 0, 'ES7012341234010234567896', 'XXISI123456789018','Secundaria','SE 6000 PU');


INSERTS.insert_Tratamientos('Sin peligro', 'No','No');
INSERTS.insert_Tratamientos('Sin peligro pero necesita abandono', 'No','Si');
INSERTS.insert_Tratamientos('Sin peligro pero necesita máscara', 'Si','No');
INSERTS.insert_Tratamientos('Sin peligro pero necesita máscara y abandono', 'Si','Si');
INSERTS.insert_Tratamientos('Peligro para animales domésticos', 'No','No');
INSERTS.insert_Tratamientos('Peligro para animales domésticos y necesita máscara', 'Si','No');
INSERTS.insert_Tratamientos('Peligro para animales domésticos y necesita abandono', 'No','Si');
INSERTS.insert_Tratamientos('Peligro para animales domésticos y necesita máscara y abandono', 'Si','Si');
INSERTS.insert_Tratamientos('Peligro para todos los seres vivos', 'No','No');
INSERTS.insert_Tratamientos('Peligro para todos los seres vivos y necesita abandono', 'No','Si');
INSERTS.insert_Tratamientos('Peligro para todos los seres vivos y necesita máscara', 'Si','No');
INSERTS.insert_Tratamientos('Peligro para todos los seres vivos y necesita máscara y abandono', 'Si','Si');


--Aquí para ejecutar las pruebas de servicios contratados
--end;

INSERTS.insert_servicios_contratados(TO_DATE('03-11-2018', 'DD-MM-YYYY'),'10:00','Sevilla Este Pabellón','2,5','Ningún problema','11111111B','1','1','1','Si',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('04-11-2018', 'DD-MM-YYYY'),'11:00','C/Corrales Nº1','3','Sin comentarios','S7370954E','2','2','2','No',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('05-08-2017', 'DD-MM-YYYY'),'16:30','C/Corrales Nº2','4','LLamar cliente mañana','W9287643B','3','3','3','Si',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('15-09-2017', 'DD-MM-YYYY'),'17:30','C/Corrales Nº3','1','Sin comentarios','77777777T','4','4','4','Si',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('04-11-2018', 'DD-MM-YYYY'),'09:45','Palacio de Congresos','2,5','Ningún problema','L9304928C','5','5','5','No',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('05-11-2018', 'DD-MM-YYYY'),'07:00','Plaza de Toros Espartinas','2,5','Ningún problema','12312389P','6','6','6','No',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('06-11-2018', 'DD-MM-YYYY'),'13:25', 'Campo Futbol Castilleja','2,5','Ningún problema','12312378A','7','7','7','No',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('07-11-2018', 'DD-MM-YYYY'),'12:00','Club Nazaret Jerez ','2,5','Ningún problema','12312367I','8','8','8','Si',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_contratados(TO_DATE('08-11-2018', 'DD-MM-YYYY'),'19:50','C/Verdial','2,5','Ningún problema','12312356U','9','9','9','No',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');



INSERTS.insert_gerentes('12345678P','123456Aa', 'Rafael', '954123456','000011112222333344445555', 'rafa@dedesinSL.es');
INSERTS.insert_gerentes('87654321A','123456Aa', 'Ismael', '954009987','000011112222333344449999', 'ismael@dedesinSL.es');
INSERTS.insert_gerentes('34567899B','123456Aa', 'Marcos', '954876543','000011113333555577779999', 'marcos@dedesinSL.es');
INSERTS.insert_gerentes('54321456T','123456Aa', 'Manuel', '954008866','000022224444666688881111', 'manuel@dedesinSL.es');


INSERTS.insert_servicios_NoContratados(TO_DATE('04-02-2019', 'DD-MM-YYYY'),'17:00',2.5,'Preguntan Disponibilidad Trabajador Pepe','11111111B',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_NoContratados(TO_DATE('05-03-2019', 'DD-MM-YYYY'),'13:00',2.5,'Sin Comentarios','77777777T',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
INSERTS.insert_servicios_NoContratados(TO_DATE('30-03-2019', 'DD-MM-YYYY'),'20:00',2.5,'Llamar Cliente','12312389P',
'Cebo fresco, veneno fresco','Maquina de gas y fumígeno','Mascara y casco','Desratizacion','Legionella');
END;
/
CREATE OR REPLACE PROCEDURE NUEVO_CLIENTE

(wDNI_CIF IN CLIENTES.DNI_CIF%TYPE, 
wCONTRASENA IN CLIENTES.CONTRASENA%TYPE, 
wTELEFONO IN CLIENTES.TELEFONO%TYPE, 
wEMAIL IN CLIENTES.EMAIL%TYPE,
wTipoCliente clientes.tipocliente%TYPE,
wNOMBRE IN CLIENTES.NOMBRE%TYPE , 
wFORMAPAGO IN CLIENTES.FORMAPAGO%TYPE, 
wNUMEROCUENTA IN CLIENTES.NUMEROCUENTA%TYPE, 
wCANCELACIONESINDEBIDAS IN CLIENTES.CANCELACIONESINDEBIDAS%TYPE)

IS

BEGIN
  INSERT INTO CLIENTES(DNI_CIF, CONTRASENA, TELEFONO, EMAIL, TIPOCLIENTE, NOMBRE, FORMAPAGO,NUMEROCUENTA,CANCELACIONESINDEBIDAS)
  VALUES(wDNI_CIF, wCONTRASENA, wTELEFONO, wEMAIL, wTipoCliente, wNOMBRE, wFORMAPAGO,wNUMEROCUENTA,wCANCELACIONESINDEBIDAS);
  
END;
/

CREATE OR REPLACE PROCEDURE MODIFICAR_CLIENTE

(DNI_CIF_AMOD IN CLIENTES.DNI_CIF%TYPE, 
CONTRASENA_AMOD IN CLIENTES.CONTRASENA%TYPE, 
TELEFONO_AMOD IN CLIENTES.TELEFONO%TYPE, 
EMAIL_AMOD IN CLIENTES.EMAIL%TYPE,
TipoCliente_AMOD clientes.tipocliente%TYPE,
NOMBRE_AMOD IN CLIENTES.NOMBRE%TYPE , 
FORMAPAGO_AMOD IN CLIENTES.FORMAPAGO%TYPE, 
NUMEROCUENTA_AMOD IN CLIENTES.NUMEROCUENTA%TYPE, 
CANCELACIONESINDEBIDAS_AMOD IN CLIENTES.CANCELACIONESINDEBIDAS%TYPE)

IS

BEGIN

  UPDATE CLIENTES SET CONTRASENA=CONTRASENA_AMOD,
  TELEFONO=TELEFONO_AMOD, EMAIL=EMAIL_AMOD,TipoCliente=TipoCliente_AMOD, NOMBRE=NOMBRE_AMOD, 
  FORMAPAGO=FORMAPAGO_AMOD, NUMEROCUENTA=NUMEROCUENTA_AMOD, 
  CANCELACIONESINDEBIDAS=CANCELACIONESINDEBIDAS_AMOD 
  WHERE DNI_CIF=DNI_CIF_AMOD;
  
END;
/
CREATE OR REPLACE PROCEDURE BORRAR_CLIENTE 
(bDNI_CIF IN CLIENTES.DNI_CIF%TYPE) IS

BEGIN

    DELETE FROM CLIENTES WHERE DNI_CIF = bDNI_CIF;

END;
/
CREATE OR REPLACE PROCEDURE NUEVO_SNC
(w_Fecha serviciosnocontratados.fecha%TYPE,w_Hora serviciosnocontratados.Hora%TYPE,w_Duracion serviciosnocontratados.duracion%TYPE,
w_Observaciones serviciosnocontratados.observaciones%TYPE,w_DNI_CIF serviciosnocontratados.dni_cif%TYPE,w_TipoTratamiento serviciosnocontratados.TipoTratamiento%TYPE,
w_TipoMaquinas serviciosnocontratados.TipoMaquinas%TYPE,w_TipoMateriales serviciosnocontratados.TipoMateriales%TYPE,
w_TipoServicios serviciosnocontratados.TipoServicios%TYPE, w_TipoPlagas serviciosnocontratados.TipoPlagas%TYPE)
IS

BEGIN

INSERT INTO serviciosNoContratados(ID_SNC,Fecha,Hora,Duracion,Observaciones,DNI_CIF,TipoTratamiento,TipoMaquinas,TipoMateriales,TipoServicios,TipoPlagas)
VALUES(sec_serv_NoContratados.nextval,w_Fecha,w_Hora,w_Duracion,w_Observaciones,w_DNI_CIF,w_TipoTratamiento,w_TipoMaquinas,w_TipoMateriales,w_TipoServicios,w_TipoPlagas);

END;
/
CREATE OR REPLACE PROCEDURE NUEVO_SERVICIOCONTRATADO
(w_Fecha servicioscontratados.fecha%TYPE,w_Hora servicioscontratados.Hora%TYPE,w_Lugar servicioscontratados.lugar%TYPE,
w_Duracion servicioscontratados.duracion%TYPE,w_Observaciones servicioscontratados.observaciones%TYPE,w_DNI_CIF servicioscontratados.dni_cif%TYPE,
w_NumeroFactura servicioscontratados.numerofactura%TYPE,w_NumeroTrabajador servicioscontratados.numerotrabajador%TYPE,
w_ID_T servicioscontratados.id_t%TYPE,w_Completado servicioscontratados.Completado%TYPE,w_TipoTratamiento servicioscontratados.TipoTratamiento%TYPE,
w_TipoMaquinas servicioscontratados.TipoMaquinas%TYPE,w_TipoMateriales servicioscontratados.TipoMateriales%TYPE,
w_TipoServicios servicioscontratados.TipoServicios%TYPE, w_TipoPlagas servicioscontratados.TipoPlagas%TYPE)

IS

BEGIN

  INSERT INTO ServiciosContratados(ID_SC,Fecha,Hora,Lugar,Duracion,Observaciones,DNI_CIF,NumeroFactura,NumeroTrabajador,ID_T,Completado,
  TipoTratamiento,TipoMaquinas,TipoMateriales,TipoServicios,TipoPlagas)
  VALUES(SEC_SERV_CONTRATADOS.nextval,w_Fecha,w_Hora,w_Lugar,w_Duracion,w_Observaciones,w_DNI_CIF,w_NumeroFactura,w_NumeroTrabajador,w_ID_T,w_Completado,
  w_TipoTratamiento,w_TipoMaquinas,w_TipoMateriales,w_TipoServicios,w_TipoPlagas);

END;
/
-- VEHICULOS

CREATE OR REPLACE PROCEDURE MODIFICAR_VEHICULO

(MATRICULA_AMOD IN VEHICULOS.MATRICULA%TYPE, KMTOTALES_AMOD IN VEHICULOS.KMTOTALES%TYPE, 
FECHAPROXITV_AMOD IN VEHICULOS.FECHAPROXITV%TYPE, FECHAEXPSEGURO_AMOD IN VEHICULOS.FECHAEXPSEGURO%TYPE, 
NUMTRABAJADOR_AMOD IN TRABAJADORES.NUMEROTRABAJADOR%TYPE)

IS

BEGIN

  UPDATE VEHICULOS SET KMTOTALES=KMTOTALES_AMOD,FECHAPROXITV=FECHAPROXITV_AMOD,
  FECHAEXPSEGURO=FECHAEXPSEGURO_AMOD
  WHERE MATRICULA = MATRICULA_AMOD;
  
  UPDATE TRABAJADORES SET MATRICULA=NULL
  WHERE TRABAJADORES.MATRICULA = MATRICULA_AMOD;
  
  UPDATE TRABAJADORES SET MATRICULA=MATRICULA_AMOD
  WHERE NUMEROTRABAJADOR = NUMTRABAJADOR_AMOD;

END;
/

CREATE OR REPLACE PROCEDURE NUEVO_VEHICULO

(wMATRICULA IN VEHICULOS.MATRICULA%TYPE,wMARCAMODELO IN VEHICULOS.MARCAMODELO%TYPE,
wKMTOTALES IN VEHICULOS.KMTOTALES%TYPE, wNUMBASTIDOR IN VEHICULOS.NUMBASTIDOR%TYPE,
wFECHAPROXITV IN VEHICULOS.FECHAPROXITV%TYPE, wFECHAEXPSEGURO IN VEHICULOS.FECHAEXPSEGURO%TYPE, 
wNUMTRABAJADOR IN TRABAJADORES.NUMEROTRABAJADOR%TYPE)

IS

BEGIN

  INSERT INTO VEHICULOS(Matricula, MarcaModelo, KmTotales, NumBastidor, FechaProxITV, FechaExpSeguro)
  VALUES(wMATRICULA, wMARCAMODELO, wKMTOTALES, wNUMBASTIDOR, wFECHAPROXITV, wFECHAEXPSEGURO);
  
  UPDATE TRABAJADORES SET MATRICULA=wMATRICULA
  WHERE TRABAJADORES.NUMEROTRABAJADOR = wNUMTRABAJADOR;

END;
/

CREATE OR REPLACE PROCEDURE BORRAR_VEHICULO (MATRICULA_A_QUITAR IN VEHICULOS.MATRICULA%TYPE) IS

BEGIN

    UPDATE TRABAJADORES SET MATRICULA=NULL
    WHERE TRABAJADORES.MATRICULA = MATRICULA_A_QUITAR;

    DELETE FROM VEHICULOS WHERE MATRICULA = MATRICULA_A_QUITAR;

END;
/


-- SERVICIOS

CREATE OR REPLACE PROCEDURE MODIFICAR_SERVICIO_GERENTE

(ID_SC_AMOD IN SERVICIOSCONTRATADOS.ID_SC%TYPE,FECHA_AMOD IN SERVICIOSCONTRATADOS.FECHA%TYPE,HORA_AMOD IN SERVICIOSCONTRATADOS.HORA%TYPE,
LUGAR_AMOD IN SERVICIOSCONTRATADOS.LUGAR%TYPE,DURACION_AMOD IN SERVICIOSCONTRATADOS.DURACION%TYPE,NUMEROTRABAJADOR_AMOD IN SERVICIOSCONTRATADOS.NUMEROTRABAJADOR%TYPE,
OBSERVACIONES_AMOD IN SERVICIOSCONTRATADOS.OBSERVACIONES%TYPE,COMPLETADO_AMOD IN SERVICIOSCONTRATADOS.COMPLETADO%TYPE, TIPOTRATAMIENTO_AMOD IN SERVICIOSCONTRATADOS.TIPOTRATAMIENTO%TYPE,
TIPOMAQUINAS_AMOD IN SERVICIOSCONTRATADOS.TIPOMAQUINAS%TYPE,TIPOMATERIALES_AMOD IN SERVICIOSCONTRATADOS.TIPOMATERIALES%TYPE,
TIPOSERVICIOS_AMOD IN SERVICIOSCONTRATADOS.TIPOSERVICIOS%TYPE,TIPOPLAGAS_AMOD IN SERVICIOSCONTRATADOS.TIPOPLAGAS%TYPE)

IS

BEGIN

  UPDATE SERVICIOSCONTRATADOS 
  SET FECHA=FECHA_AMOD, HORA=HORA_AMOD, LUGAR=LUGAR_AMOD,
  DURACION=DURACION_AMOD, NUMEROTRABAJADOR=NUMEROTRABAJADOR_AMOD,
  OBSERVACIONES=OBSERVACIONES_AMOD, COMPLETADO=COMPLETADO_AMOD,
  TIPOTRATAMIENTO=TIPOTRATAMIENTO_AMOD,TIPOMAQUINAS=TIPOMAQUINAS_AMOD,
  TIPOMATERIALES=TIPOMATERIALES_AMOD,TIPOSERVICIOS=TIPOSERVICIOS_AMOD,
  TIPOPLAGAS=TIPOPLAGAS_AMOD
  WHERE ID_SC = ID_SC_AMOD;

END;
/

CREATE OR REPLACE PROCEDURE BORRAR_SERVICIO (ID_SC_QUITAR IN SERVICIOSCONTRATADOS.ID_SC%TYPE) IS

BEGIN

    DELETE FROM SERVICIOSCONTRATADOS WHERE ID_SC = ID_SC_QUITAR;

END;
/

CREATE OR REPLACE PROCEDURE MODIFICAR_SERVICIO_TRABAJADOR

(ID_SC_AMOD IN SERVICIOSCONTRATADOS.ID_SC%TYPE, OBSERVACIONES_AMOD IN SERVICIOSCONTRATADOS.OBSERVACIONES%TYPE,
COMPLETADO_AMOD IN SERVICIOSCONTRATADOS.COMPLETADO%TYPE)

IS

BEGIN

  UPDATE SERVICIOSCONTRATADOS 
  SET OBSERVACIONES=OBSERVACIONES_AMOD, COMPLETADO=COMPLETADO_AMOD
  WHERE ID_SC = ID_SC_AMOD;

END;
/

-- Facturas

CREATE OR REPLACE PROCEDURE MODIFICAR_FACTURA

(NUMEROFACTURA_AMOD IN FACTURAS.NUMEROFACTURA%TYPE,FECHA_AMOD IN FACTURAS.FECHA%TYPE, SERIE_AMOD IN FACTURAS.SERIE%TYPE,CONCEPTO_AMOD IN FACTURAS.CONCEPTO%TYPE,
TIPOIMPOSITIVO_AMOD IN FACTURAS.TIPOIMPOSITIVO%TYPE,IVA_AMOD IN FACTURAS.IVA%TYPE,TOTAL_AMOD IN FACTURAS.TOTAL%TYPE,FECHAPAGO_AMOD IN FACTURAS.FECHAPAGO%TYPE,
IMPORTE_AMOD IN FACTURAS.IMPORTE%TYPE,FORMAPAGO_AMOD IN FACTURAS.FORMAPAGO%TYPE,STATUS_AMOD IN FACTURAS.STATUS%TYPE,PAGO_AMOD IN FACTURAS.PAGO%TYPE,
RECEPCION_AMOD IN FACTURAS.RECEPCION%TYPE,PERSONARECEPCION_AMOD IN FACTURAS.PERSONARECEPCION%TYPE,FECHARECEPCION_AMOD IN FACTURAS.FECHARECEPCION%TYPE,
OBSERVACIONES_AMOD IN FACTURAS.OBSERVACIONES%TYPE)

IS

BEGIN

  UPDATE FACTURAS 
  SET FECHA=FECHA_AMOD,SERIE=SERIE_AMOD,CONCEPTO=CONCEPTO_AMOD,TIPOIMPOSITIVO=TIPOIMPOSITIVO_AMOD,IVA=IVA_AMOD,TOTAL=TOTAL_AMOD,FECHAPAGO=FECHAPAGO_AMOD,
  IMPORTE=IMPORTE_AMOD,FORMAPAGO=FORMAPAGO_AMOD,STATUS=STATUS_AMOD,PAGO=PAGO_AMOD,RECEPCION=RECEPCION_AMOD,PERSONARECEPCION=PERSONARECEPCION_AMOD,
  FECHARECEPCION=FECHARECEPCION_AMOD,OBSERVACIONES=OBSERVACIONES_AMOD
  WHERE NUMEROFACTURA = NUMEROFACTURA_AMOD;

END;
/

CREATE OR REPLACE PROCEDURE BORRAR_FACTURA (NUMEROFACTURA_QUITAR IN FACTURAS.NUMEROFACTURA%TYPE) IS

BEGIN
    
    DELETE FROM SERVICIOSCONTRATADOS
    WHERE SERVICIOSCONTRATADOS.NUMEROFACTURA = NUMEROFACTURA_QUITAR;
    
    DELETE FROM FACTURAS WHERE NUMEROFACTURA = NUMEROFACTURA_QUITAR;

END;
/

CREATE OR REPLACE PROCEDURE BORRAR_SERVICIO_NO_CONTRATADO(ID_SNC_QUITAR IN ServiciosNoContratados.ID_SNC%TYPE) IS

BEGIN

    DELETE FROM ServiciosNoContratados WHERE ID_SNC = ID_SNC_QUITAR;

END;