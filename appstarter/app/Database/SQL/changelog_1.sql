create or replace table conference_impact
(
    id            int auto_increment
        primary key
        unique,
    name    char(255) not null,
    impact_factor int       not null
);

create or replace table journal_impact
(
    id            int auto_increment
        primary key
        unique,
    name       char(255) not null,
    impact_factor int       not null
);

create or replace table publications
(
    id            int auto_increment,
    title         char(255) not null,
    authors       char(255) not null,
    release_year  int       not null,
    conference_id int       null,
    journal_id    int       null,
    download      char(255) null,
    doi           char(255) null,
    constraint publications_pk
        primary key (id),
    constraint publications_journal_impact_null_fk
        foreign key (journal_id) references journal_impact (id),
    constraint publications_conference_impact_null_fk
        foreign key (conference_id) references conference_impact (id)
);

create or replace table users
(
    id              int                                       auto_increment,
    code            char(3)                                   not null unique,
    password        char(255)                                 not null,
    name            char(255)                                 not null,
    lastname        char(255)                                 not null,
    title           char(255)                                 null,
    email           char(255)                                 null,
    phone           char(255)                                 null,
    mobile          char(255)                                 null,
    temporary_basis bool                                      null,
    user_type       enum ('leader', 'employee', 'management') not null,
    constraint User_pk
        primary key (id)
);

create or replace table users2publications
(
    id              int auto_increment,
    user_id         int       null,
    publications_id int       not null,
    name_extern     char(255) null,
    lastname_extern char(255) null,
    percentage      TINYINT   not null,
    constraint users2publications_pk
        primary key (id),
    constraint users2publications_publications_null_fk
        foreign key (publications_id) references publications (id),
    constraint users2publications_users_null_fk
        foreign key (user_id) references users (id)
);

create or replace table employees
(
    employee_id         int       auto_increment,
    user_id             int       not null,
    employment_value    int       null,
    ATM                 char(255) null,
    level               char(255) null,
    birth_year          int       null,
    h_index             int       null,
    number_dissertations int       null,
    contract_start      DATE      null,
    contract_end        DATE      null,
    research_assistant  bool      null comment 'WiMi',
    constraint employee_pk
        primary key (employee_id),
    constraint employee_users_null_fk
        foreign key (user_id) references users (id)
);

create or replace table leader
(
    id            int auto_increment
        primary key,
    user_id             int       not null,
    function_unit char(255) null,
    constraint leader_users_code_fk
        foreign key (user_id) references users (id)
);

create or replace table management
(
    id            int auto_increment,
    user_id              int       not null,
    function_unit char(255) null,
    constraint management_pk
        primary key (id),
    constraint management_users_null_fk
        foreign key (user_id) references users (id)
);

create or replace table student_assistent
(
    id                   int auto_increment,
    user_id              int       not null,
    name                 char(255) not null,
    lastname             char(255) not null,
    contract_start       DATE      null,
    contract_end         DATE      null,
    monthly_hours        int       null,
    total_hours          int       null,
    expenditures         int       null,
    expenditures_j1      int       null,
    expenditures_j2      int       null,
    comment              char(255) null,
    date_form_submission DATE      null,
    birthday             DATE      null,
    task                 char(255) null,
    phone                char(255) null,
    email                char(255) null,
    constraint student_assistent_pk
        primary key (id),
    constraint student_assistent_users_null_fk
        foreign key (user_id) references users (id)
);

create or replace table project
(
    id                         int auto_increment,
    name                       char(255) null,
    funding_code               char(255) null,
    title                      char(255) not null,
    year                       int       null,
    cost_center                int       null,
    account_number             char(255) null,
    expiration_project_account DATE      null,
    term_start                 DATE      null,
    term_end                   DATE      null,
    funding_amount             int       null,
    grantor                    char(255) null,
    project_executer           char(255) null,
    contact_person_TuDa        int       null,
    constraint project_pk
        primary key (id)
);

create or replace table project2user_assistent
(
    student_id int not null,
    project_id int null,
    constraint project2user_assistent_project_null_fk
        foreign key (project_id) references project (id),
    constraint project2user_assistent_student_assistent_null_fk
        foreign key (student_id) references student_assistent (id)
);

create or replace table business_trips
(
    id                         int auto_increment,
    project_id                 int       not null,
    business_trip              char(255) not null,
    trip_strart                 DATE      not null,
    trip_end                   DATE      not null,
    date_trip_request          DATE      null,
    date_trip_report_submitted DATE      null,
    date_reimbursement         DATE      null,
    costs                      int       null,
    description                char(255) null,
    constraint business_trips_pk
        primary key (id),
    constraint business_trips_project_null_fk
        foreign key (project_id) references project (id)
);

create or replace table invest
(
    id                  int auto_increment,
    user_id             int                       not null,
    project_id          int                       not null,
    costs               int                       not null,
    date_administration DATE                      null,
    date_submit         DATE                      null,
    date_bill           DATE                      null,
    year                int                       null,
    payout              enum ('cash', 'cashless') null,
    item                char(255)                 null comment 'Posten',
    constraint invest_pk
        primary key (id),
    constraint invest_project_null_fk
        foreign key (project_id) references project (id),
    constraint invest_users_null_fk
        foreign key (user_id) references users (id)
);

create or replace table young_scientists
(
    id       int auto_increment,
    name     char(255) not null,
    lastname char(255) not null,
    topic    char(255) null comment 'Topic doctoral thesis habilitation',
    date     DATE      null comment 'of doctoral thesis / habilitation',
    year     int       null,
    constraint young_scientists_pk
        primary key (id)
);

create or replace table thesis
(
    id                      int auto_increment,
    user_id                 int          not null,
    name                    char(255)    not null,
    lastname                char(255)    not null,
    department              int          null,
    study_course            char(255)    null,
    matriculation_number    int          null,
    examination_regulations int          null,
    external                bool         null,
    date_preliminary_talk   DATE         null,
    title                   char(255)    null,
    date_start              DATE         null,
    date_end                DATE         null,
    date_signup             DATE         null,
    date_lectureship        DATE         null,
    date_presentation       DATE         null,
    date_grade_registration DATE         null,
    grade                   DOUBLE(2, 1) null, -- Using FLOAT might give you some unexpected problems because all calculations in MariaDB are done with double precision.
    constraint thesis_pk
        primary key (id)
);

create or replace table users2thesis
(
    supervisor    int not null,
    co_supervisor int not null,
    thesis_id     int not null,
    constraint users2thesis_pk
        primary key (thesis_id),
    constraint users2thesis_thesis_null_fk
        foreign key (thesis_id) references thesis (id),
    constraint users2thesis_users_null_fk1
        foreign key (supervisor) references users (id),
    constraint users2thesis_users_null_fk2
        foreign key (co_supervisor) references users (id)
);

create or replace table pando
(
    id                  int DEFAULT 1,
    date                DATE    null,
    year                int     null,
    third_party_funding double  null,
    promotion           double  null,
    teaching_service    double  null,
    theses              double  null,
    teaching_evaluation double  null,
    constraint pando_pk
        primary key (id)
);

create or replace table semester
(
    id       int        auto_increment,
    name     char(255)   not null,
    constraint semester_pk
        primary key (id),
    constraint semester_pk
        unique (name)
);

create or replace table teaching_services
(
    id           int auto_increment,
    module_title char(255) not null,
    module_number  char(255) not null,
    examiner     char(255) not null,
    sws          int       not null,
    internships  bool   not null,
    semester     char(255) not null,
    exams        int       not null,
    constraint teaching_performances_pk
        primary key (id),
    constraint teaching_services_semester_null_fk
        foreign key (semester) references semester (name)
);

create or replace table users2teaching_services
(
    id      int auto_increment,
    user_id int not null,
    t_s_id  int not null,
    exams   int null,
    constraint users2teaching_services_pk
        primary key (id),
    constraint users2teaching_services_teaching_services_null_fk
        foreign key (t_s_id) references teaching_services (id),
    constraint users2teaching_services_users_null_fk
        foreign key (user_id) references users (id)
);

create or replace table users2business_trips
(
    id                      int auto_increment,
    user_id                 int not null,
    business_trip_id        int not null,
    constraint users2business_trips_pk
        primary key (id),
    constraint users2business_trips_users_null_fk
        foreign key (user_id) references users (id),
    constraint users2business_trips_business_trips_null_fk
        foreign key (business_trip_id) references business_trips (id)
);

alter table employees
    change birth_year birthdate date null;
alter table employees
    add personal_number int null;
alter table employees
    modify ATM bool null;
rename table student_assistent to student_assistant;
alter table business_trips
    change costs costs double null;
alter table thesis
    add external_university char(255) null;
alter table thesis
    add external_supervisor char(255) null;
alter table business_trips
    change trip_strart trip_start date not null;
alter table thesis
    drop column user_id;
alter table thesis
    modify department int not null;
alter table thesis
    modify examination_regulations int null;
alter table business_trips
    drop column description;
rename table project2user_assistent to project2user_assistant;
alter table invest
    modify payout bool null;
alter table invest
    change payout cashless tinyint(1) null;