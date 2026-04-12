CREATE TABLE table001 (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    age INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE visits (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES table001(id),
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE memberships (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES table001(id),
    type TEXT,
    start_date DATE,
    end_date DATE
);

CREATE TABLE qr_codes (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES table001(id),
    code TEXT UNIQUE
);














INSERT INTO table001 (name, email, password, age)
VALUES 
('Alex', 'alex@mail.com', '1234', 20),
('Mark', 'mark@mail.com', '5678', 25);

INSERT INTO memberships (user_id, type, start_date, end_date)
VALUES
(1, 'monthly', '2026-03-01', '2026-04-01'),
(2, 'monthly', '2026-01-01', '2026-02-01');

INSERT INTO qr_codes (user_id, code)
VALUES
(1, 'ABC123'),
(2, 'XYZ789');
