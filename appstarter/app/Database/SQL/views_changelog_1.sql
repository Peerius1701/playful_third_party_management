create or replace view vw_publications as
SELECT pub.id           as id,
       title,
       authors,
       release_year,
       conference_id,
       download,
       journal_id,
       doi,
       ci.name          as conference,
       ci.impact_factor as conference_impact_factor,
       ji.name          as journal,
       ji.impact_factor as journal_impact_factor,
       COALESCE(ji.impact_factor, ci.impact_factor)  as impact_factor,
       COALESCE(ji.name, ci.name)    as journal_conference_name
FROM publications as pub
         LEFT JOIN journal_impact ji on ji.id = pub.journal_id
         Left JOIN conference_impact ci on pub.conference_id = ci.id;


create or replace view vw_users2publications as
SELECT `u2p`.`user_id`               as `user_id`,
       `u2p`.`publications_id`       as `publications_id`,
       `u2p`.`name_extern`           as `name_extern`,
       `u2p`.`lastname_extern`       as `lastname_extern`,
       `u2p`.`percentage`            as `percentage`,
       `users`.`name`                as `name`,
       `users`.`lastname`            as `lastname`,
       `users`.`code`                as `code`,
       `publications`.`release_year` as `release_year`,
       COALESCE(ji.impact_factor, ci.impact_factor)  as impact_factor,
       COALESCE(ji.name, ci.name)    as journal_conference_name
FROM `users2publications` as u2p
         LEFT JOIN `users` ON `u2p`.`user_id` = `users`.`id`
         LEFT JOIN publications ON `u2p`.`publications_id` = `publications`.`id`
         LEFT JOIN conference_impact ci on publications.conference_id = ci.id
         LEFT JOIN journal_impact ji on publications.journal_id = ji.id;

create or replace view vw_employees as
SELECT u.id as user_id,
       u.code,
       name,
       lastname,
       title,
       email,
       phone,
       mobile,
       temporary_basis,
       employee_id,
       employment_value,
       ATM,
       level,
       birthdate,
       h_index,
       number_dissertations,
       contract_start,
       contract_end,
       research_assistant,
       personal_number,
       profile_picture
FROM users as u
         JOIN employees e on u.id = e.user_id;


create or replace view vw_leader as
SELECT u.id as user_id,
       l.id as leader_id,
       u.code,
       name,
       lastname,
       title,
       email,
       phone,
       mobile,
       temporary_basis,
       function_unit,
       level,
       contract_start,
       contract_end,
       h_index,
       number_dissertations,
       number_promotions,
       personal_number,
       birthdate,
       employment_value,
       third_party_funds,
       profile_picture
FROM users as u
         JOIN leader l on u.id = l.user_id;


create or replace view vw_management as
SELECT u.id as user_id,
       u.code,
       name,
       lastname,
       title,
       email,
       phone,
       mobile,
       temporary_basis,
       m.id as management_id,
       function_unit
FROM users as u
         JOIN management m on u.id = m.user_id;

create or replace view vw_business_trips as
SELECT b.id   as id,
       business_trip,
       trip_start,
       trip_end,
       date_trip_request,
       date_trip_report_submitted,
       date_reimbursement,
       costs,
       p.id   as project_id,
       p.name as project
FROM business_trips as b
         JOIN project p on b.project_id = p.id;

create or replace view vw_users2business_trips as
SELECT `users2business_trips`.`user_id`          as `user_id`,
       `users2business_trips`.`business_trip_id` as `business_trip_id`,
       `users`.`code`                            as `code`,
       `users`.`name`                            as `name`,
       `users`.`lastname`                        as `lastname`
FROM `users2business_trips`
         LEFT JOIN `users` ON `users2business_trips`.`user_id` = `users`.`id`;

create or replace view vw_invest as
SELECT `invest`.`id`                  AS `id`,
       `invest`.`costs`               AS `costs`,
       `invest`.`date_administration` AS `date_administration`,
       `invest`.`date_submit`         AS `date_submit`,
       `invest`.`date_bill`           AS `date_bill`,
       `invest`.`year`                AS `year`,
       `invest`.`cashless`            AS `cashless`,
       `invest`.`item`                AS `item`,
       `invest`.`project_id`          AS `project_id`,
       `invest`.`user_id`             AS `user_id`,
       `users`.`code`                 AS `user_code`,
       `users`.`name`                 AS `user_name`,
       `users`.`lastname`             AS `user_lastname`,
       `project`.`name`               AS `project_name`,
       `project`.`account_number`     AS `account_number`
FROM `invest`
         LEFT JOIN `users` ON `invest`.`user_id` = `users`.`id`
         LEFT JOIN `project` ON `invest`.`project_id` = `project`.`id`;

create or replace view vw_projects as
SELECT p.id       as id,
       p.name,
       funding_code,
       p.title,
       cost_center,
       account_number,
       expiration_project_account,
       term_start,
       term_end,
       funding_amount,
       g.name     as grantor,
       project_executer,
       contact_person_TuDa,
       u.code     as contact_person_TuDa_code,
       u.name     as contact_person_TuDa_name,
       u.lastname as contact_person_TuDa_lastname,
       p.grantor_others
FROM project as p
         JOIN users u on p.contact_person_TuDa = u.id
         LEFT JOIN grantor g on p.grantor = g.id;

Create or replace view vw_finance_type as
select rr.id                      as remedy_retrieval_id,
       rr.submission_date,
       rr.number_retrieval,
       rr.money_receipt_date,
       rr.number_retrieval_of_year,
       ft.id,
       ft.staff_e12_e15,
       ft.staff_e11,
       ft.total_staff_expenses,
       ft.student_assistant,
       ft.external_orders,
       ft.invest,
       ft.small_devices,
       ft.business_trips_national,
       ft.business_trips_international,
       ft.total_expenses,
       ft.project_lump_sum,
       ft.project_lump_sum_percentage,
       ft.total_funding,
       ft.material_expenses,
       coalesce(rr.year, tf.year) as year,
       ft.project_id,
       ft.type,
       tf.id                      as total_financing_id
from finance_type as ft
         left join remedy_retrieval as rr on ft.id = rr.finance_type_id
         left join total_financing as tf on ft.id = tf.finance_type_id;

Create or replace view vw_student_assistant as
select s.id   as id,
       user_id,
       s.name as name,
       lastname,
       contract_start,
       contract_end,
       monthly_hours,
       total_hours,
       expenditures,
       expenditures_j1,
       expenditures_j2,
       comment,
       date_form_submission,
       birthday,
       task,
       phone,
       email,
       project_id,
       p.name as project_name
from student_assistant as s
         left join project as p on project_id = p.id;

create or replace view vw_thesis as
select *
from thesis as t
         join users2thesis u2t on t.id = u2t.thesis_id;

create or replace view vw_users2teaching_services as
select u2ts.user_id,
       u2ts.exams as individual_exams,
       ts.*
from users2teaching_services as u2ts
    left join teaching_services ts on ts.id = u2ts.t_s_id;
