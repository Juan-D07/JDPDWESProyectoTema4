CREATE DATABASE IF NOT EXISTS DBJDPDWESProyectoTema4;
USE DBJDPDWESProyectoTema4;

CREATE TABLE IF NOT EXISTS T02_Departamento (
    T02_CodDepartamento VARCHAR(3) PRIMARY KEY,
    T02_DescDepartamento VARCHAR(255),
    T02_FechaCreacionDepartamento datetime,
    T02_VolumenDeNegocio float,
    T02_FechaBajaDepartamento datetime)engine=InnoDB;
    
CREATE USER 'userJDPDWESProyectoTema4'@'%' IDENTIFIED BY 'paso';
GRANT ALL ON DBJDPDWESProyectoTema4.* to 'userJDPDWESProyectoTema4'@'%';