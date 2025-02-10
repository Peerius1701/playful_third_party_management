-- Test data for users
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('ais', 'uglygrip19', 'Isobella', 'Anderson', null, 'Anderson@example.com', '+49 1596 5153942', null, true, 'leader');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('dfg', 'flatcougar96', 'Cynthia ', 'Cline', 'Dr.', 'Cline@example.com', '+49 175 39141874', '+49 1593 1675929', true, 'employee');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('asd', 'bestmetal47', 'Krystal ', 'Thompson', 'Prof. Dr.', 'Thompson@example.com', null, '+49 175 39141874', false, 'management');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('shl', 'ultraclam24', 'Helena ', 'Horton', null, 'Horton@example.com', null, '+49 1593 1675929', false, 'management');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('sgo', 'luckyjoke65', 'Stefan', 'Göbel', null, null, '+49 15526 990110', '+49 15526 990110', true, 'leader');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('öpu', 'funnyhorn17', 'Lennon', 'Hunter', null, null, null, null, true, 'management');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('ppe', 'firstsalt37', 'Panagiotis', 'Petridis', null, 'ppe@example.com', '+49 160 7993054', '0151/51780948', 0, 'employee');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('mas', 'b@dWhale97', 'Maria', 'Saridaki', null, 'Saridaki@example.com', '+49 171 9265984', '0162/34456366', 1, 'employee');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('col', ')izzyKoala13', 'Conor', 'Linehan', null, 'Linehan@example.com', '+4915816669417', '0155/36859533', 1, 'employee');
INSERT INTO users (code, password, name, lastname, title, email, phone, mobile, temporary_basis, user_type) VALUES ('reg', 'meg@Drum77', 'René', 'Gökmen', null, 'Goekmen@example.com', '+49 15029 193595', '0170/88832540', 1, 'employee');

-- Test data for employee
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (2, null, null, null, '1965-3-15', null, null, '2019-03-01','2023-03-09', null, 1603328);
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (7, 100, 0, null, '1994-02-16', 89, 11, '2022-01-01', '2026-01-01', 1, 4497912);
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (8, 75, 1, null, '1991-04-10', 224, 12, '2021-01-01', '2023-01-01', 1, 1198408);
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (9, 50, 1, null, '1984-05-10', 197, 16, '2020-01-31', '2023-01-31', 1, 4303020);
INSERT INTO employees (user_id, employment_value, ATM, level, birthdate, h_index, number_dissertations, contract_start, contract_end, research_assistant, personal_number) VALUES (10, 100, 0, null, '1983-10-22', 61, 8, '2023-01-01', '2023-01-01', 1, 8781176);

-- Test data for leader
INSERT INTO leader (user_id, function_unit) VALUES (5, 'Funktionseinheit');
INSERT INTO leader (user_id, contract_start, contract_end) VALUES (1, '2015-03-04','2029-03-01');

-- Test data for management
INSERT INTO management (user_id, function_unit) VALUES (3, null);
INSERT INTO management (user_id, function_unit) VALUES (6, null);
INSERT INTO management (user_id, function_unit) VALUES (4, null);

-- Test data for conference_impact
INSERT INTO conference_impact (name, impact_factor) VALUES ('Conference on Games and Virtual Worlds for Serious Applications, VS-GAMES', 90);
INSERT INTO conference_impact (name, impact_factor) VALUES ('2011 Third International Conference on Games and Virtual Worlds for Serious Applications', 95);
INSERT INTO conference_impact (name, impact_factor) VALUES ('2009 Conference in Games and Virtual Worlds for Serious Applications', 75);
INSERT INTO conference_impact (name, impact_factor) VALUES ('2021 IEEE Conference on Games (CoG)', 75);
INSERT INTO conference_impact (name, impact_factor) VALUES ('2010 Second International Conference on Games and Virtual Worlds for Serious Applications', 61);
INSERT INTO conference_impact (name, impact_factor) VALUES ('2011 Third International Conference on Intelligent Networking and Collaborative Systems', 93);
INSERT INTO conference_impact (name, impact_factor) VALUES ('DevDays & DevOps Pro Europe 2023', 65);
INSERT INTO conference_impact (name, impact_factor) VALUES ('GraphQL Galaxy', 45);
INSERT INTO conference_impact (name, impact_factor) VALUES ('BASTA! Spring', 81);
INSERT INTO conference_impact (name, impact_factor) VALUES ('Nullcon International Security Conference & Training - Berlin', 12);

-- Test data for journals_impact
INSERT INTO journal_impact (name, impact_factor) VALUES ('WIRED', 89);
INSERT INTO journal_impact (name, impact_factor) VALUES ('Tech Journal', 45);
INSERT INTO journal_impact (name, impact_factor) VALUES ('Computer World', 83);

-- Test data for publications
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Incorporating Serious Games in the Classroom of Students with Intellectual Disabilities and the Role of the Educator', 'M. Saridaki and C. Mourlas', 2011, 2, null, 'https://ieeexplore.ieee.org/document/5962086', '10.1109/VS-GAMES.2011.35');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Tabletop Prototyping of Serious Games for \'Soft Skills\' Training', 'C. Linehan, S. Lawson and M. Doughty', 2009, 3, null, 'https://ieeexplore.ieee.org/document/5116571', '10.1109/VS-GAMES.2009.9');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Stereotypes as Design Patterns for Serious Games to Enhance Software Comprehension', 'R. Gökmen, D. Heidrich, A. Schreiber and C. Bichlmeier', 2021, 4, null, 'https://ieeexplore.ieee.org/document/9619060', '10.1109/CoG52621.2021.9619060');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('An Engine Selection Methodology for High Fidelity Serious Games', 'P. Petridis, I. Dunwell, S. de Freitas and D. Panzoli', 2010, 5, null, 'https://ieeexplore.ieee.org/document/5460160', '10.1109/VS-GAMES.2010.26');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Blended Game-Based Learning Environments: Extending a Serious Game into a Learning Content Management System', 'I. Dunwell, P. Petridis, S. Arnab, A. Protopsaltis, M. Hendrix and S. de Freitas', 2011, 6, null, 'https://ieeexplore.ieee.org/document/6132917', '10.1109/INCoS.2011.58');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('KITE: AI-supported VR tactics training for police forces', 'I. Anderson, C. Cline', 2016, 1, null, 'example.com', null);
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('ABC4Jobs', 'C. Cline, D. Crookall', 2017, 2, null, 'example.com', null);
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Serious games for vocational training', 'I. Anderson', 2010, 3, null, null, 'example.com');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Serious Games Information Center', 'I. Anderson', 2013, 4, null, null, 'example.com');
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Serious games, debriefing, and simulation/gaming as a discipline', 'C. Cline', 2005, null, 1, null, null);
INSERT INTO publications (title, authors, release_year, conference_id, journal_id, download, doi) VALUES ('Serious games for health', 'I. Anderson, C. Cline', 2011, null, 2, null, null);

-- Test data for users2publications
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (1, 6, null, null, 70);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (2, 6, null, null, 30);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (2, 7, null, null, 50);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (1, 8, null, null, 100);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (1, 9, null, null, 100);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (1, 10, null, null, 100);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (1, 11, null, null, 80);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (2, 11, null, null, 20);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 7, 'David', 'Crookall', 50);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (8, 1, null, null, 60);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 1, 'Constantinos', 'Mourlas', 40);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (9, 2, null, null, 50);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 2, 'Shaun', 'Lawson', 40);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 2, 'Mark', 'Doughty', 10);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (10, 3, null, null, 40);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 3, 'David', 'Heidrich', 30);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 3, 'Andreas', 'Schreiber', 30);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (7, 4, null, null, 50);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 4, 'Ian', 'Dunwell', 50);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (null, 5, 'Ian', 'Dunwell', 50);
INSERT INTO users2publications (user_id, publications_id, name_extern, lastname_extern, percentage) VALUES (7, 5, null, null, 50);

-- Test data for grantor
INSERT INTO grantor (name) VALUES ('DFG');
INSERT INTO grantor (name) VALUES ('EU');
INSERT INTO grantor (name) VALUES ('BMBF');
INSERT INTO grantor (name) VALUES ('BMWK');
INSERT INTO grantor (name) VALUES ('Land Hessen');
INSERT INTO grantor (name) VALUES ('Industrie');
INSERT INTO grantor (name) VALUES ('Stiftung');
INSERT INTO grantor (name) VALUES ('Sonstiges');
-- Test data for project
INSERT INTO project (name, funding_code, title, cost_center, account_number, expiration_project_account, term_start, term_end, funding_amount, grantor, project_executer, contact_person_TuDa) VALUES ('Spielerische Drittmittelverwaltung', 'a123', 'Bachelor Praktikum WISE22/23', 123, 123, '2023-02-12', '2022-10-01', '2023-02-10', 1000, 1, 'Isobella Anderson', 5);
INSERT INTO project (name, funding_code, title, cost_center, account_number, expiration_project_account, term_start, term_end, funding_amount, grantor, project_executer, contact_person_TuDa) VALUES ('Serious Games Praktikum WiSe22/23', 'b456', 'Serious Games Praktikum', 456, 456, '2023-02-12', '2022-10-01', '2023-02-10', 1500, 2, 'Conor Linehan', 5);

-- Test data for business_trips
INSERT INTO business_trips (project_id, business_trip, trip_start, trip_end, date_trip_request, date_trip_report_submitted, date_reimbursement, costs) VALUES (1, 'Vancouver', '2022-12-30', '2023-01-09', null, null, null, null);

-- Test data for users2business_trips
INSERT INTO users2business_trips (user_id, business_trip_id) VALUES (4, 1);

-- Test data for pando
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2023,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2021,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2022,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2024,0.05,8699.79,26.41,0,1596.56);
INSERT INTO pando (date, year, third_party_funding, promotion, teaching_service, theses, teaching_evaluation) VALUES (NULL,2025,0.05,8699.79,26.41,0,1596.56);

