CREATE USER 'MattJerry0025'@'localhost' IDENTIFIED BY 'H009JBCASR76KL1998';
GRANT ALL PRIVILEGES ON mattjerry0025.* TO 'MattJerry0025'@'localhost';
FLUSH PRIVILEGES;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    is_subscribed BOOLEAN DEFAULT FALSE,
    subscription_date DATETIME,
    INDEX(username)
);

CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    subscription_type VARCHAR(255) NOT NULL,
    start_date DATETIME,
    end_date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    message_date DATETIME DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE tutorials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    video_url VARCHAR(255),
    access_level ENUM('free', 'basic', 'premium') NOT NULL DEFAULT 'free'
);

INSERT INTO tutorials (title, description, access_level) VALUES
('Introduction to Programming', 'Learn the basics of programming and how to get started.', 'free'),
('Python', 'Learn the basics and advanced concepts of Python programming.', 'basic'),
('HTML', 'Learn the basics and advanced concepts of HTML.', 'free'),
('CSS', 'Learn the basics and advanced concepts of CSS.', 'free'),
('JavaScript', 'Learn the basics and advanced concepts of JavaScript programming.', 'basic'),
('PHP', 'Learn the basics and advanced concepts of PHP programming.', 'premium'),
('Java', 'Learn the basics and advanced concepts of Java programming.', 'premium'),
('C and C++', 'Learn the basics and advanced concepts of C and C++ programming.', 'premium'),
('Data Structures & Algorithms', 'Learn about various data structures and algorithms used in computer science.', 'basic'),
('Software Engineering and Optimized SE Practices', 'Learn about software engineering principles and best practices for optimized development.', 'premium'),
('Linear Algebra', 'Explore vector spaces, linear transformations, eigenvalues, and eigenvectors.', 'basic'),
('Calculus I, II, III, and IV', 'Explore the fundamental concepts of Calculus in this engaging tutorial.', 'basic'),
('Ordinary Differential Equations', 'Learn to solve differential equations that model real-world phenomena.', 'premium'),
('Partial Differential Equations', 'Understand the techniques to solve PDEs, crucial for modeling multi-variable systems.', 'premium');
