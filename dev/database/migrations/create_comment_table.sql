create table comments
(
    post_id   int      not null,
    id        int auto_increment,
    author_id int      not null,
    content   longtext null,
    constraint comments_pk
        primary key (id),
    constraint comments_posts_id_fk
        foreign key (post_id) references posts (id)
            on update cascade on delete cascade,
    constraint comments_users_id_fk
        foreign key (author_id) references users (id)
            on update cascade on delete cascade
);

