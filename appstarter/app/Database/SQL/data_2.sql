-- Data from Stefan Göbel

-- users
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('sgo','luckyjoke65','Stefan','Göbel','Dr.','stefan_peter.goebel@tu-darmstadt.de','1620390','',1,'leader');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('PC','pco','Polona','Caserman','Dr.','polona.caserman@tu-darmstadt.de','1612345','',0,'employee');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('PNM','pnmo','Philipp','Müller','MSc Inf','philipp.mueller1@tu-darmstadt.de','1633333','',0,'employee');

-- employees
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (2,100,0,'A13','3333-02-01',10,20,'2018-01-01','2024-04-30',1,222222);
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (3,100,0,'A13','3333-03-03',5,20,'2018-02-01','2023-07-31',1,333333);

-- leader
INSERT INTO leader (user_id, function_unit, level, contract_start, contract_end, h_index, number_dissertations, number_promotions, personal_number, birthdate, employment_value, third_party_funds) VALUES (1,'Funktionseinheit', 'Axy', '2012-12-01', '2025-03-18', 28, 200, 0, 111111, '1971-05-28',100, 0);

-- management

-- conference_impact
INSERT INTO conference_impact (name, impact_factor) VALUES ('JCSG',2);
INSERT INTO conference_impact (name, impact_factor) VALUES ('ECGBL',1);
INSERT INTO conference_impact (name, impact_factor) VALUES ('ACM CHI',3);

-- journal_impact
INSERT INTO journal_impact (name, impact_factor) VALUES ('Entcom',2);
INSERT INTO journal_impact (name, impact_factor) VALUES ('G4H',4);

-- pando
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2023,0.05,8699.79,26.41,0,1596.56);
# needed for report
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2021,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2022,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2024,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2025,0.05,8699.79,26.41,0,1596.56);

-- grantor
INSERT INTO grantor (name) VALUES ('DFG');
INSERT INTO grantor (name) VALUES ('EU');
INSERT INTO grantor (name) VALUES ('BMBF');
INSERT INTO grantor (name) VALUES ('BMWK');
INSERT INTO grantor (name) VALUES ('Land Hessen');
INSERT INTO grantor (name) VALUES ('Industrie');
INSERT INTO grantor (name) VALUES ('Stiftung');
INSERT INTO grantor (name) VALUES ('Sonstiges');

-- project
INSERT INTO project (name, funding_code, title, cost_center, account_number, expiration_project_account, term_start, term_end, funding_amount, grantor, project_executer, contact_person_TuDa, grantor_others) VALUES ('KITE','KITE123','KITE',180050,'111111111','2024-12-31','2021-05-01','2024-04-30',360000,3,'VDE',1,'');

-- business_trips
INSERT INTO business_trips (project_id, business_trip, trip_start, trip_end, date_trip_request, date_trip_report_submitted, date_reimbursement, costs) VALUES (1,'Berlin','2022-10-10','2022-10-10','2022-09-09','2022-09-09','2022-12-12',500);

-- finance_type
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (300000,0,350000,50000,0,5000,0,2000,3000,360000,72000,20,432000,10000,1,'allocation');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (60000,0,70000,10000,0,4000,0,100,0,74100,14820,20,88920,4100,1,'total');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (100000,0,115000,15000,0,800,0,100,1000,116100,23000,20,140000,1100,1,'total');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (100000,0,115000,15000,0,1000,0,1000,1000,117100,23000,20,140000,2100,1,'total');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (40000,0,50000,10000,0,1000,500,500,2000,54000,11000,20,65000,4000,1,'total');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (50000,0,60000,10000,0,2000,0,200,0,62200,12000,20,65000,2200,1,'remedy');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (50000,0,57500,7500,0,800,0,0,0,57500,11000,20,69000,0,1,'remedy');
INSERT INTO finance_type (staff_e12_e15, staff_e11, total_staff_expenses, student_assistant, external_orders, invest, small_devices, business_trips_national, business_trips_international, total_expenses, project_lump_sum, project_lump_sum_percentage, total_funding, material_expenses, project_id, type)
    VALUES (50000,0,58000,8000,0,800,0,1000,1000,60800,13600,20,74400,2800,1,'remedy');

-- total_financing
INSERT INTO total_financing (finance_type_id, project_id, year) VALUES (2,1,2021);
INSERT INTO total_financing (finance_type_id, project_id, year) VALUES (3,1,2022);
INSERT INTO total_financing (finance_type_id, project_id, year) VALUES (4,1,2023);
INSERT INTO total_financing (finance_type_id, project_id, year) VALUES (5,1,2024);

-- remedy_retrieval
INSERT INTO remedy_retrieval (finance_type_id, submission_date, number_retrieval, money_receipt_date, project_id, year, number_retrieval_of_year) VALUES (6,'2022-01-01',1,'2022-02-02',1,2021,1);
INSERT INTO remedy_retrieval (finance_type_id, submission_date, number_retrieval, money_receipt_date, project_id, year, number_retrieval_of_year) VALUES (7,'2022-07-07',2,'2022-08-08',1,2022,1);
INSERT INTO remedy_retrieval (finance_type_id, submission_date, number_retrieval, money_receipt_date, project_id, year, number_retrieval_of_year) VALUES (8,'2023-01-01',3,'2023-02-02',1,2022,2);

-- publications
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('paper im G4H Journal','Polona Caserman, Stefan Göbel',2022,NULL,2,'','');

-- semester
INSERT INTO semester (name) VALUES ('SoSe 20');
INSERT INTO semester (name) VALUES ('SoSe 21');
INSERT INTO semester (name) VALUES ('SoSe 22');
INSERT INTO semester (name) VALUES ('SoSe 23');
INSERT INTO semester (name) VALUES ('SoSe 24');
INSERT INTO semester (name) VALUES ('WiSe 20/21');
INSERT INTO semester (name) VALUES ('WiSe 21/22');
INSERT INTO semester (name) VALUES ('WiSe 22/23');
INSERT INTO semester (name) VALUES ('WiSe 23/24');
INSERT INTO semester (name) VALUES ('WiSe 24/25');

-- student_assistant
INSERT INTO student_assistant (user_id, name, lastname, contract_start, contract_end, monthly_hours, total_hours, expenditures, expenditures_j1, expenditures_j2, comment, date_form_submission, birthday, task, phone, email, project_id) VALUES (2,'Burak','Dogan','2021-01-01','2023-12-31',40,NULL,15000,7500,7500,'','2020-12-01','2000-02-01','Programmierung','0176/123456','burak.dogan@tu-darmstadt.de',1);

-- teaching_services
INSERT INTO teaching_services (module_title, module_number, examiner, sws, internships, semester, exams, cp) VALUES ('Serious Games V2+Ü2','20-0366','Stefan Göbel',4,0,'SoSe 23',100, 0);
INSERT INTO teaching_services (module_title, module_number, examiner, sws, internships, semester, exams, cp) VALUES ('SG Seminar','20-0344','Stefan Göbel',2,2,'SoSe 23',20, 0);
INSERT INTO teaching_services (module_title, module_number, examiner, sws, internships, semester, exams, cp) VALUES ('SG Praktikum','20-4444','Stefan Göbel',6,1,'SoSe 23',40, 0);

-- thesis
INSERT INTO thesis (name, lastname, department, study_course, matriculation_number, examination_regulations, external, external_university, external_supervisor, date_preliminary_talk, title, date_start, date_end, date_signup, date_lectureship, date_presentation, date_grade_registration, grade) VALUES ('Peer','Weidner',20,'BSc Inf',9238909,2015,0,NULL,'','2023-01-01','langer Titel','2023-04-01','2023-09-30','2023-03-01','2023-04-01','2023-10-10','2023-10-20',1.7);

-- users2business_trips
INSERT INTO users2business_trips (user_id, business_trip_id) VALUES (2,1);
INSERT INTO users2business_trips (user_id, business_trip_id) VALUES (1,1);

-- users2publications
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (2,1,NULL,NULL,90);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (1,1,NULL,NULL,10);

-- users2teaching_services
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (1,1,100);
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (2,2,6);
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (3,2,4);
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (1,2,10);
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (1,3,20);
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (2,3,10);
INSERT INTO users2teaching_services (user_id, t_s_id, exams) VALUES (3,3,10);

-- users2thesis
INSERT INTO users2thesis (supervisor, co_supervisor, thesis_id) VALUES (1,3,1);

-- young_scientists
INSERT INTO young_scientists (name, lastname, topic, date, year) VALUES ('Polona', 'Caserman', 'VR', '2021-01-01', 2021);
