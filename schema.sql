DROP DATABASE IF EXISTS task_force;

CREATE DATABASE task_force
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE task_force;

CREATE TABLE cities(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  latitude DECIMAL(9,7) NOT NULL,
  longitude DECIMAL(10,7) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE categories(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  icon VARCHAR(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE users(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password_hash CHAR(60) NOT NULL,
  city_id INT UNSIGNED NOT NULL,
  role ENUM('customer', 'contractor') DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_contacts_hidden BOOLEAN DEFAULT false,
  birthdate TIMESTAMP,
  phone_number CHAR(11),
  telegram VARCHAR(64),
  description VARCHAR(1000),
  avatar_url VARCHAR(255),
  FOREIGN KEY (city_id) REFERENCES cities(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE users_categories(
  PRIMARY KEY (user_id, category_id),
  user_id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE tasks(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  customer_id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  status ENUM('new', 'cancelled', 'in_progress', 'completed', 'failed') DEFAULT 'new',
  title VARCHAR(255) NOT NULL,
  description VARCHAR(1000) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  contractor_id INT UNSIGNED,
  latitude DECIMAL(9,7) NOT NULL,
  longitude DECIMAL(10,7) NOT NULL,
  budget INT UNSIGNED,
  files JSON,
  term TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
  FOREIGN KEY (category_id) REFERENCES categories(id)
      ON UPDATE CASCADE
      ON DELETE RESTRICT,
  FOREIGN KEY (contractor_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE responses(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  task_id INT UNSIGNED NOT NULL,
  contractor_id INT UNSIGNED NULL,
  status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  comment VARCHAR(1000),
  price INT UNSIGNED,
  FOREIGN KEY (task_id) REFERENCES tasks(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (contractor_id) REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE = InnoDB;

CREATE TABLE reviews(
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  task_id INT UNSIGNED NOT NULL,
  rate TINYINT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  comment VARCHAR(1000),
  FOREIGN KEY (task_id) REFERENCES tasks(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE = InnoDB;
