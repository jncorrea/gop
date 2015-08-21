/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     10/08/2015 21:34:01                          */
/*==============================================================*/
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

drop table if exists ALINEACION;

drop table if exists CAMPEONATOS;

drop table if exists CENTROS_DEPORTIVOS;

drop table if exists CENTROS_FAVORITOS;

drop table if exists CHAT;

drop table if exists COMENTARIOS;

drop table if exists DEPORTES;

drop table if exists DEPORTES_FAVORITOS;

drop table if exists GRUPOS;

drop table if exists GRUPOS_CAMPEONATO;

drop table if exists MENSAJES;

drop table if exists PARTIDOS;

drop table if exists TEMP;

drop table if exists USER_GRUPO;

drop table if exists USUARIOS;

/*==============================================================*/
/* Table: ALINEACION                                            */
/*==============================================================*/
create table ALINEACION
(
   ID_ALINEACION        int not null AUTO_INCREMENT,
   ID_PARTIDO           int DEFAULT NULL,
   ID_USER              int DEFAULT NULL,
   POSICION_EVENT       int DEFAULT NULL,
   EQUIPO_EVENT         varchar(100) DEFAULT NULL,
   RENDIMIENTO          varchar(100) DEFAULT NULL,
   FECHA_ALINEACION     datetime DEFAULT NULL,
   ESTADO_ALINEACION    varchar(5) DEFAULT NULL,
   primary key (ID_ALINEACION)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: CAMPEONATOS                                           */
/*==============================================================*/
create table CAMPEONATOS
(
   ID_CAMPEONATO        int not null AUTO_INCREMENT,
   NOMBRE_CAMPEONATO    varchar(100) not null,
   FECHA_INICIO         date DEFAULT NULL,
   FECHA_FIN            date DEFAULT NULL,
   ETAPAS               int DEFAULT NULL,
   DESCRIPCION          text,
   primary key (ID_CAMPEONATO)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: CENTROS_DEPORTIVOS                                    */
/*==============================================================*/
create table CENTROS_DEPORTIVOS
(
   ID_CENTRO            int not null AUTO_INCREMENT,
   ID_USER              int,
   CENTRO_DEPORTIVO     varchar(150) not null,
   CIUDAD               varchar(150) DEFAULT NULL,
   FOTO_CENTRO          varchar(100) DEFAULT NULL,
   DIRECCION            varchar(250) DEFAULT NULL,
   LATITUD              varchar(25) DEFAULT NULL,
   LONGITUD             varchar(25) DEFAULT NULL,
   TELEF_CENTRO         varchar(100) DEFAULT NULL,
   HORA_INICIO          time DEFAULT NULL,
   HORA_FIN             time DEFAULT NULL,
   TIEMPO_ALQUILER      decimal(4,2) DEFAULT NULL,
   COSTO                float(5) DEFAULT NULL,
   NUM_JUGADORES        int DEFAULT NULL,
   primary key (ID_CENTRO)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


/*==============================================================*/
/* Table: CENTROS_FAVORITOS                                     */
/*==============================================================*/
create table CENTROS_FAVORITOS
(
   ID_CENTRO_FAV        int not null AUTO_INCREMENT,
   ID_CENTRO            int not null,
   ID_USER              int not null,
   primary key (ID_CENTRO_FAV)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: CHAT                                                  */
/*==============================================================*/
create table CHAT
(
   ID_CHAT              int not null AUTO_INCREMENT,
   FROM_               varchar(100) not null,
   TO_                   varchar(100) not null,
   MESSAGE              text not null,
   SENT                 datetime DEFAULT NULL,
   RECD                 int DEFAULT NULL,
   primary key (ID_CHAT)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: COMENTARIOS                                           */
/*==============================================================*/
create table COMENTARIOS
(
   ID_COMENTARIO        int not null AUTO_INCREMENT,
   ID_USER              int DEFAULT NULL,
   ID_GRUPO             int DEFAULT NULL,
   ID_PARTIDO           int DEFAULT NULL,
   ID_CAMPEONATO        int DEFAULT NULL,
   FECHA_PUBLICACION    datetime not null,
   COMENTARIO           text not null,
   primary key (ID_COMENTARIO)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: DEPORTES                                              */
/*==============================================================*/
create table DEPORTES
(
   ID_DEPORTE           int not null AUTO_INCREMENT,
   DEPORTE              varchar(150) not null,
   primary key (ID_DEPORTE)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: DEPORTES_FAVORITOS                                    */
/*==============================================================*/
create table DEPORTES_FAVORITOS
(
   ID_DEP_FAV           int not null AUTO_INCREMENT,
   ID_DEPORTE           int not null,
   ID_USER              int not null,
   primary key (ID_DEP_FAV)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: GRUPOS                                                */
/*==============================================================*/
create table GRUPOS
(
   ID_GRUPO             int not null AUTO_INCREMENT,
   ID_USER              int not null,
   NOMBRE_GRUPO         varchar(150) not null,
   LOGO                 varchar(150) DEFAULT NULL,
   CREADO               datetime not null,
   primary key (ID_GRUPO)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: GRUPOS_CAMPEONATO                                     */
/*==============================================================*/
create table GRUPOS_CAMPEONATO
(
   ID_GRUPO_C           int not null AUTO_INCREMENT,
   ID_CAMPEONATO        int not null,
   ID_GRUPO             int not null,
   ESTADO_INV           varchar(5),
   primary key (ID_GRUPO_C)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: MENSAJES                                              */
/*==============================================================*/
create table MENSAJES
(
   ID_MENSAJE           int not null AUTO_INCREMENT,
   FROM_MSG             varchar(50) not null,
   TO_MSG               varchar(50) not null,
   MENSAJE              text not null,
   DATE_MSG             datetime DEFAULT NULL,
   RCVD                 varchar(5) DEFAULT NULL,
   primary key (ID_MENSAJE)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: PARTIDOS                                              */
/*==============================================================*/
create table PARTIDOS
(
   ID_PARTIDO           int not null AUTO_INCREMENT,
   ID_CENTRO            int DEFAULT NULL,
   ID_CAMPEONATO        int DEFAULT NULL,
   ID_GRUPO             int DEFAULT NULL,
   NOMBRE_PARTIDO       varchar(150) not null,
   DESCRIPCION_PARTIDO  text DEFAULT NULL,
   FECHA_PARTIDO        date not null,
   HORA_PARTIDO         time not null,
   EQUIPO_A             varchar(150) DEFAULT NULL,
   EQUIPO_B             varchar(150) DEFAULT NULL,
   RES_A                int DEFAULT NULL,
   RES_B                int DEFAULT NULL,
   ESTADO_PARTIDO       varchar(5) DEFAULT NULL,
   primary key (ID_PARTIDO)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: TEMP                                                  */
/*==============================================================*/
create table TEMP
(
   ID_TEMP              int not null AUTO_INCREMENT,
   ID_GRUPO             int DEFAULT NULL,
   EMAIL_TEMP           varchar(150) not null,
   FECHA_TEMP           date DEFAULT NULL,
   primary key (ID_TEMP)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: USER_GRUPO                                            */
/*==============================================================*/
create table USER_GRUPO
(
   ID_USERG             int not null AUTO_INCREMENT,
   ID_GRUPO             int not null,
   ID_USER              int not null,
   FECHA_INV            datetime DEFAULT NULL,
   ESTADO_CONEC         varchar(5) DEFAULT NULL,
   primary key (ID_USERG)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*==============================================================*/
/* Table: USUARIOS                                              */
/*==============================================================*/
create table USUARIOS
(
   ID_USER              int not null AUTO_INCREMENT,
   EMAIL                varchar(150) not null,
   PASS                 varchar(50) not null,
   USER                 varchar(25) not null,
   NOMBRES              varchar(150) DEFAULT NULL,
   APELLIDOS            varchar(150) DEFAULT NULL,
   NACIMIENTO           date DEFAULT NULL,
   POSICION             varchar(100) DEFAULT NULL,
   CELULAR              varchar(20) DEFAULT NULL,
   TELEFONO             varchar(20) DEFAULT NULL,
   AVATAR               varchar(50) DEFAULT NULL,
   DISPONIBLE           varchar(5) DEFAULT NULL,
   REGISTRADO           datetime not null,
   ESTADO               varchar(5) DEFAULT NULL,
   primary key (ID_USER)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

alter table ALINEACION add constraint FK_JUEGA foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

alter table ALINEACION add constraint FK_POSEE foreign key (ID_PARTIDO)
      references PARTIDOS (ID_PARTIDO) on delete cascade on update cascade;

alter table CENTROS_DEPORTIVOS add constraint FK_ADMINISTRA foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

alter table CENTROS_FAVORITOS add constraint FK_TIENE foreign key (ID_CENTRO)
      references CENTROS_DEPORTIVOS (ID_CENTRO) on delete cascade on update cascade;

alter table CENTROS_FAVORITOS add constraint FK_TIENE2 foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

alter table COMENTARIOS add constraint FK_COMENTA foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

alter table COMENTARIOS add constraint FK_HACE foreign key (ID_PARTIDO)
      references PARTIDOS (ID_PARTIDO) on delete cascade on update cascade;

alter table COMENTARIOS add constraint FK_INTERACTUA foreign key (ID_GRUPO)
      references GRUPOS (ID_GRUPO) on delete cascade on update cascade;

alter table COMENTARIOS add constraint FK_RELACIONA foreign key (ID_CAMPEONATO)
      references CAMPEONATOS (ID_CAMPEONATO) on delete cascade on update cascade;

alter table DEPORTES_FAVORITOS add constraint FK_PRACTICA foreign key (ID_DEPORTE)
      references DEPORTES (ID_DEPORTE) on delete cascade on update cascade;

alter table DEPORTES_FAVORITOS add constraint FK_PRACTICA2 foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

alter table GRUPOS add constraint FK_CREA foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

alter table GRUPOS_CAMPEONATO add constraint FK_ESTA foreign key (ID_CAMPEONATO)
      references CAMPEONATOS (ID_CAMPEONATO) on delete cascade on update cascade;

alter table GRUPOS_CAMPEONATO add constraint FK_INCLUYE foreign key (ID_GRUPO)
      references GRUPOS (ID_GRUPO) on delete cascade on update cascade;

alter table PARTIDOS add constraint FK_ORGANIZA foreign key (ID_CAMPEONATO)
      references CAMPEONATOS (ID_CAMPEONATO) on delete cascade on update cascade;

alter table PARTIDOS add constraint FK_PARTICIPA foreign key (ID_GRUPO)
      references GRUPOS (ID_GRUPO) on delete cascade on update cascade;

alter table PARTIDOS add constraint FK_SE_REALIZA foreign key (ID_CENTRO)
      references CENTROS_DEPORTIVOS (ID_CENTRO) on delete cascade on update cascade;

alter table TEMP add constraint FK_INVITA foreign key (ID_GRUPO)
      references GRUPOS (ID_GRUPO) on delete cascade on update cascade;

alter table USER_GRUPO add constraint FK_PERTENECE foreign key (ID_GRUPO)
      references GRUPOS (ID_GRUPO) on delete cascade on update cascade;

alter table USER_GRUPO add constraint FK_PERTENECE2 foreign key (ID_USER)
      references USUARIOS (ID_USER) on delete cascade on update cascade;

