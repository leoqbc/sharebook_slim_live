<?php

$pdo = new PDO(dsn: 'mysql:host=127.0.0.1;dbname=carapp;port=3300', username: 'root', password: 123456);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->query('
CREATE TABLE cars (
    `id`    int primary key auto_increment,
    `name`  varchar(300) not null,
    `model` varchar(300) not null,
    `brand` varchar(300) not null,
    `price` decimal(8,2) not null
)
');

$pdo->query(<<<SQL
INSERT INTO cars (`name`, `model`, `brand`, `price`)
VALUES
  ('Toyota Camry', '2023', 'Toyota', 25000),
  ('Honda Civic', '2022', 'Honda', 22000),
  ('Ford Mustang', '2023', 'Ford', 35000),
  ('Chevrolet Corvette', '2022', 'Chevrolet', 70000),
  ('BMW 3 Series', '2022', 'BMW', 40000),
  ('Mercedes-Benz C-Class', '2023', 'Mercedes-Benz', 45000),
  ('Audi A4', '2022', 'Audi', 38000),
  ('Nissan Altima', '2023', 'Nissan', 23000),
  ('Hyundai Sonata', '2022', 'Hyundai', 24000),
  ('Kia Optima', '2023', 'Kia', 22000);
SQL);

echo 'Dados gerados!!';