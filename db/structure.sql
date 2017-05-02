drop table if exists P4_t_comment;
drop table if exists P4_t_user;
drop table if exists P4_t_billet;

create table P4_t_billet (
    billet_id integer not null primary key auto_increment,
    billet_title varchar(100) not null,
    billet_content varchar(2000) not null,
    billet_dateAjout date not null,
    billet_dateModif date not null,
    billet_nbComments int(255) NOT NULL
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table P4_t_comment (
    com_id integer not null primary key auto_increment,
    com_content varchar(500) not null,
    billet_id integer not null,
    user_id integer not null,
    com_date datetime not null,
    constraint fk_com_billet foreign key(billet_id) references P4_t_billet(billet_id),
    constraint fk_com_user foreign key(user_id) references P4_t_user(user_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table P4_t_user (
    user_id integer not null primary key auto_increment,
    user_name varchar(50) not null,
    user_password varchar(88) not null,
    user_salt varchar(23) not null,
    user_role varchar(50) not null 
) engine=innodb character set utf8 collate utf8_unicode_ci;
