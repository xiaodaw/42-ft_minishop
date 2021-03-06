#!/usr/bin/php
<?php
  $db_host = "localhost:1433";
  $db_user = "root";
  $db_pw = "root";
  $db_name = "db_minishop";
  $db_link = mysqli_connect($db_host, $db_user, $db_pw);

  function query_table($link, $table_name, $query)
  {
    if (mysqli_query($link, $query))
      echo "Table '$table_name' queried successfully.\n";
    else
      die("Error querying table '$table_name'\n" . mysqli_error($link));
  }

  if (!$db_link)
    die("Cannot connect: " . mysqli_connect_error());

  echo "Connected to MySQL server successfully"."\n";

  if (mysqli_select_db($db_link, $db_name))
  {
    echo "db_minishop already exisits"."\n";
    exit();
  }

  $db_create = "CREATE DATABASE $db_name";
  if (mysqli_query($db_link, $db_create))
    echo "Database '$db_name' created successfully\n";
  else
    throw_mysqli_error($db_link);

  mysqli_select_db($db_link, $db_name);

  $create_table_products = "CREATE TABLE products
    (product_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    product_cat INT, product_title VARCHAR(40) DEFAULT 'item' NOT NULL,
	  product_price INT NOT NULL, product_desc TEXT NOT NULL,
    product_image TEXT NOT NULL);";
  query_table($db_link, "products", $create_table_products);

  $create_table_categories = "CREATE TABLE categories
    (cat_id INT PRIMARY KEY NOT NULL,
    cat_title TEXT NOT NULL);";
  query_table($db_link, "categories", $create_table_categories);

  $insert_products = "INSERT INTO products (product_cat,
    product_title, product_price, product_desc, product_image) VALUES
    (0, 'Supreme Water Bottle', 50, 'A red water bottle with Supreme logo.',
    '/public/img/products/Supreme-Bottle.jpg'),
    (0, 'Supreme Teddy Bear', 75, 'A stuffed bear with Supreme logo.',
    '/public/img/products/Supreme-Bear.jpg'),
    (0, 'Supreme Soup Bowl', 50, 'A bowl and spoon with Supreme logo.',
    '/public/img/products/Supreme-Bowl.jpg'),
    (0, 'Supreme RC', 150, 'An RC car with Supreme logo.',
    '/public/img/products/Supreme-RC.jpg'),
    (0, 'Supreme Skateboard', 150, 'A skateboard with Supreme logo.',
    '/public/img/products/Supreme-Skateboard.jpeg');";
  query_table($db_link, "products", $insert_products);

  $insert_categories = "INSERT INTO categories (cat_id, cat_title) VALUES
    (0, 'accessories'), (1, 'clothing'), (2, 'footwear');";
  query_table($db_link, "categories", $insert_categories);
