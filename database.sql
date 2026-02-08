CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  password VARCHAR(100),
  role ENUM('admin','user') DEFAULT 'user',
  status ENUM('Active','Inactive') DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  item_name VARCHAR(150),
  qty INT,
  price DECIMAL(10,2)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total DECIMAL(10,2),
  status ENUM('Preparing','Ready','Completed') DEFAULT 'Preparing',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE orders
MODIFY status ENUM('Preparing','Ready','Completed','Delivered')
DEFAULT 'Preparing';



CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    category ENUM('Main','Healthy','Drinks') NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    status ENUM('Available','Out of Stock') DEFAULT 'Available',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO users (name,email,password,role)
VALUES ('Admin','admin@canteen.com','admin123','admin');



























-- CREATE DATABASE canteen_db;
-- USE canteen_db;

-- -- USERS
-- -- CREATE TABLE users (
-- --   id INT AUTO_INCREMENT PRIMARY KEY,
-- --   name VARCHAR(100),
-- --   email VARCHAR(100),
-- --   password VARCHAR(100),
-- --   role ENUM('admin','user') DEFAULT 'user'
-- -- );

-- CREATE TABLE users (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   name VARCHAR(100),
--   email VARCHAR(100),
--   password VARCHAR(100),
--   role ENUM('admin','user') DEFAULT 'user',
--   status ENUM('Active','Inactive') DEFAULT 'Active',
--   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- -- CATEGORIES
-- CREATE TABLE categories (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   name VARCHAR(100)
-- );

-- -- FOOD ITEMS
-- CREATE TABLE items (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   category_id INT,
--   name VARCHAR(100),
--   price DECIMAL(10,2),
--   image VARCHAR(200),
--   FOREIGN KEY (category_id) REFERENCES categories(id)
-- );

-- -- ORDERS
-- CREATE TABLE orders (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   user_id INT,
--   total DECIMAL(10,2),
--   status VARCHAR(50) DEFAULT 'Pending',
--   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );

-- -- ORDER ITEMS
-- CREATE TABLE order_items (
--   id INT AUTO_INCREMENT PRIMARY KEY,
--   order_id INT,
--   item_id INT,
--   qty INT,
--   price DECIMAL(10,2)
-- );

-- -- ADMIN USER
-- INSERT INTO users (name,email,password,role)
-- VALUES ('Admin','admin@canteen.com','admin123','admin');
