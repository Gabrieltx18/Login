create database Login;
use Login;
create table Usuarios
(
	cd_usuario int primary key,
	nm_usuario varchar(100),
    ds_senha varchar(100)
)
select * from Usuarios;