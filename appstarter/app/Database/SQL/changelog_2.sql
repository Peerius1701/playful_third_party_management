alter table student_assistant
    add project_id int null;

alter table student_assistant
    add constraint student_assistant_project_id_fk
        foreign key (project_id) references project (id);

rename table project2user_assistant to project2student_assistant;


alter table leader
    add level char null;
alter table leader
    add contract_start date null;
alter table leader
    add contract_end date null;
alter table leader
    add h_index int null;
alter table leader
    add number_dissertations int null;
alter table leader
    add number_promotions int null;
alter table leader
    add personal_number int null;
alter table leader
    add birthdate date null;
alter table leader
    add employment_value int null;
alter table leader
    add third_party_funds double null;

alter table leader
    modify level char(255) null;

create table finance_type
(
    id                           int auto_increment,
    staff_e12_e15                double                                 null,
    staff_e11                    double                                 null,
    total_staff_expenses         double                                 null,
    student_assistant            int                                    null,
    external_orders              double                                 null,
    invest                       double                                 null comment '>800€',
    small_devices                double                                 null comment '< 800€',
    business_trips_national      double                                 null,
    business_trips_international double                                 null,
    total_expenses               double                                 null,
    project_lump_sum             double                                 null comment '[€]',
    project_lump_sum_percentage     int                                    null comment '[%]',
    total_funding                double                                 null,
    material_expenses            double                                 null,
    year                         int                                    null,
    project_id                   int                                    null,
    type                         enum ('allocation', 'remedy', 'total') null,
    constraint finance_type_pk
        primary key (id),
    constraint finance_type_project_id_fk
        foreign key (project_id) references project (id)
            on delete set null
);

create table remedy_retrieval
(
    id               int auto_increment,
    finance_type_id  int  not null,
    submission_date  DATE null,
    number_retrieval int  null,
    money_receipt_date date null,
    constraint remedy_retrieval_pk
        primary key (id),
    constraint remedy_retrieval_finance_type_id_fk
        foreign key (finance_type_id) references finance_type (id)
);

create table total_financing
(
    id               int auto_increment,
    finance_type_id  int  not null,
    project_id       int not null,
    year             int not null,
    constraint total_financing_pk
        primary key (id),
    constraint total_financing_finance_type_id_fk
        foreign key (finance_type_id) references finance_type (id),
    constraint total_financing_project_id_fk
        foreign key (project_id) references project (id)
);

create table grantor
(
    id               int auto_increment,
    name             char(255) not null,
    constraint total_financing_pk
        primary key (id)
);

alter table remedy_retrieval
    add project_id int null;

alter table remedy_retrieval
    add constraint remedy_retrieval_project_id_fk
        foreign key (project_id) references project (id)
            on delete set null;

alter table project
    drop column year;
alter table remedy_retrieval
    add column year int;
alter table remedy_retrieval
    add column number_retrieval_of_year int;
alter table finance_type
    drop column year;
alter table project
    add column grantor_others char(255) null;
alter table project
    modify grantor int;

alter table project
    add constraint project_grantor_id_fk
        foreign key (grantor) references grantor (id)
            on DELETE set null;

alter table teaching_services
    add cp int not null;
alter table journal_impact
    modify impact_factor double not null;
alter table conference_impact
    modify impact_factor double not null;

alter table users
    add profile_picture char(255) default null null comment 'file path and name of profile picture (typically stored in public/images/profile)';

alter table pando
    modify id int auto_increment;

alter table pando
    auto_increment = 1;
