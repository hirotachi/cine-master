create table posts
(
    id          int auto_increment,
    title       varchar(255) not null,
    rating      float        null,
    poster      varchar(255) not null,
    year        int          not null,
    genres      varchar(255) null,
    description longtext     null,
    banner      varchar(255) null,
    author_id   int          not null,
    constraint posts_pk
        primary key (id),
    constraint posts_users_id_fk
        foreign key (author_id) references users (id)
            on update cascade on delete cascade
);

create index posts_title_index
    on posts (title);

