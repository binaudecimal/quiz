CREATE TABLE users(
    user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    first varchar(255) not null,
    last varchar(255) not null,
    username varchar(255) not null unique,
    password varchar(255) not null,
    type varchar(25) not null,
    last_login datetime,
    session_id varchar(255)
);

CREATE TABLE issues(
	issue_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    issue_heading varchar(255),
    issue_body varchar(255),
    date_issued datetime,
    date_resolved datetime,
    issuant_id int(11) not null,
    FOREIGN KEY(issuant_id) REFERENCES users(user_id)
);

CREATE TABLE teachers(
	teacher_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    user_id int(11) not null,
    FOREIGN KEY(user_id) REFERENCES users(user_id)
);

CREATE TABLE class(
	class_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    section_name varchar(255) not null,
    teacher_id int(11) not null,
    FOREIGN KEY(teacher_id) REFERENCES teachers(teacher_id)
);

CREATE TABLE students(
	student_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    user_id int(11) not null,
    class_id int(11) not null,
    FOREIGN KEY(user_id) REFERENCES users(user_id),
    FOREIGN KEY(class_id) REFERENCES class(class_id)
);

CREATE TABLE questions(
	question_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    question varchar(255) not null,
    answer_correct varchar(255) not null,
    answer_wrong1 varchar(255) not null,
    answer_wrong2 varchar(255) not null,
    answer_wrong3 varchar(255) not null,
    region varchar(255) not null,
    status boolean not null
);

CREATE TABLE quiz_reports(
  qreport_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    student_id int(11) not null,
    FOREIGN KEY(student_id) REFERENCES users(user_id)
);

CREATE TABLE quiz_instance(
	qinstance_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    qreport_id int(11) not null,
    items int(10) not null,
    duration int(10) not null,
    region varchar(25) not null,
    total_score float,
    date_finished datetime
);

CREATE TABLE answer_instance(
	ainstance_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    qinstance_id Int(11) not null,
    question_id int(11) not null,
    answer varchar(255),
    weighted_score float
);
