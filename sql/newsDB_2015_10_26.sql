CREATE TABLE ci_sessions
(
    id VARCHAR(40) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    timestamp INT UNSIGNED DEFAULT 0 NOT NULL,
    data LONGBLOB NOT NULL
);
CREATE INDEX ci_sessions_timestamp ON ci_sessions (timestamp);
CREATE TABLE groups
(
    id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(100) NOT NULL
);
CREATE TABLE login_attempts
(
    id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ip_address VARCHAR(15) NOT NULL,
    login VARCHAR(100) NOT NULL,
    time INT UNSIGNED
);
CREATE TABLE migrations
(
    version BIGINT NOT NULL
);
CREATE TABLE pages
(
    id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    `order` INT NOT NULL,
    body LONGTEXT
);
CREATE TABLE users
(
    id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    ip_address VARCHAR(15) NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salt VARCHAR(255),
    email VARCHAR(100) NOT NULL,
    activation_code VARCHAR(40),
    forgotten_password_code VARCHAR(40),
    forgotten_password_time INT UNSIGNED,
    remember_code VARCHAR(40),
    created_on INT UNSIGNED NOT NULL,
    last_login INT UNSIGNED,
    active TINYINT UNSIGNED,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    company VARCHAR(100),
    phone VARCHAR(20)
);
CREATE TABLE users_groups
(
    id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    group_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (group_id) REFERENCES groups (id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);
CREATE UNIQUE INDEX uc_users_groups ON users_groups (user_id, group_id);
CREATE INDEX fk_users_groups_groups1_idx ON users_groups (group_id);
CREATE INDEX fk_users_groups_users1_idx ON users_groups (user_id);
