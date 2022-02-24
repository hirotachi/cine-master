#  create users table
create table if not exists users
(
    id        int auto_increment primary key,
    email     varchar(255) unique key,
    username  varchar(255) unique key,
    password  varchar(255),
    name      varchar(255),
    createdAt timestamp default now(),
    updatedAt timestamp default now()
);






