create or replace table conference_impact
(
    id            int auto_increment
        primary key
        unique,
    name    char(255) not null,
    impact_factor double not null
);

create or replace table journal_impact
(
    id            int auto_increment
        primary key
        unique,
    name       char(255) not null,
    impact_factor double not null
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
    temporary_basis tinyint(1)                                      null,
    user_type       enum ('leader', 'employee', 'management') not null,
	profile_picture char(255) default null null comment 'file path and name of profile picture (typically stored in public/images/profile)',
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
    percentage      int(4)   not null,
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
    personal_number int null,
    employment_value    int       null,
    ATM                 tinyint(1) null,
    level               char(255) null,
    birthdate           DATE       null,
    h_index             int       null,
    number_dissertations int       null,
    contract_start      DATE      null,
    contract_end        DATE      null,
    research_assistant  tinyint(1)      null comment 'WiMi',
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
    level char(255) null,
    contract_start date null,
    contract_end date null,
    h_index int null,
    number_dissertations int null,
    number_promotions int null,
    personal_number int null,
    birthdate date null,
    employment_value int null,
    third_party_funds double null,
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

create table grantor
(
    id               int auto_increment,
    name             char(255) not null,
    constraint total_financing_pk
        primary key (id)
);

create or replace table project
(
    id                         int auto_increment,
    name                       char(255) null,
    funding_code               char(255) null,
    title                      char(255) not null,
    cost_center                int       null,
    account_number             char(255) null,
    expiration_project_account DATE      null,
    term_start                 DATE      null,
    term_end                   DATE      null,
    funding_amount             int       null,
    grantor                    int       null,
    grantor_others             char(255) null,
    project_executer           char(255) null,
    contact_person_TuDa        int       null,

    constraint project_pk
        primary key (id),
    constraint project_grantor_id_fk
        foreign key (grantor) references grantor (id)
            on DELETE set null
);

create or replace table student_assistant
(
    id                   int auto_increment,
    user_id              int       not null,
    project_id int null,
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
    constraint student_assistant_pk
        primary key (id),
    constraint student_assistant_users_null_fk
        foreign key (user_id) references users (id),
    constraint student_assistant_project_id_fk
        foreign key (project_id) references project (id)
);



create or replace table project2student_assistant
(
    student_id int not null,
    project_id int null,
    constraint project2student_assistant_project_null_fk
        foreign key (project_id) references project (id),
    constraint project2student_assistant_student_assistant_null_fk
        foreign key (student_id) references student_assistant (id)
);

create or replace table business_trips
(
    id                         int auto_increment,
    project_id                 int       not null,
    business_trip              char(255) not null,
    trip_start                 DATE      not null,
    trip_end                   DATE      not null,
    date_trip_request          DATE      null,
    date_trip_report_submitted DATE      null,
    date_reimbursement         DATE      null,
    costs                      double       null,
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
    costs               double                    not null,
    date_administration DATE                      null,
    date_submit         DATE                      null,
    date_bill           DATE                      null,
    year                int                       null,
    cashless            tinyint(1)				  null,
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
    name                    char(255)    not null,
    lastname                char(255)    not null,
    department              int          not null,
    study_course            char(255)    null,
    matriculation_number    int          null,
    examination_regulations int          null,
    external                tinyint(1)   null,
	external_university     char(255) 	 null,
	external_supervisor 	char(255) 	 null,
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
    id                  int auto_increment,
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
    name     char(128)   not null,
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
    internships  tinyint(1)   not null,
    semester     char(128) not null,
    exams        int       not null,
    cp int not null,
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



create table finance_type
(
    id                           int auto_increment,
    staff_e12_e15                double                                 null,
    staff_e11                    double                                 null,
    total_staff_expenses         double                                 null,
    student_assistant         int                                    null,
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
    project_id                   int                                    null,
    type                         enum ('allocation', 'remedy', 'total') null,
    constraint finance_type_pk
        primary key (id),
    constraint finance_type_project_id_fk
        foreign(project_id) references project (id)
            on delete set null
);

create table remedy_retrieval
(
    id               int auto_increment,
    finance_type_id  int  not null,
    submission_date  DATE null,
    number_retrieval int  null,
    money_receipt_date date null,
    project_id int null,
    year int null,
    number_retrieval_of_year int null,
    constraint remedy_retrieval_pk
        primary key (id),
    constraint remedy_retrieval_finance_type_id_fk
        foreign key (finance_type_id) references finance_type (id),
    constraint remedy_retrieval_project_id_fk
        foreign key (project_id) references project (id)
            on delete set null
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


