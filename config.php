<?php
define("HOST", "127.0.0.1");
define("USER", "root");
define("PWD", "");
define("DB", "ecommerce");

try {
    
    // Set DSN (Data Source Name) for PDO
    $dsn = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8";

    // Create a PDO instance
    $pdo = new PDO($dsn, USER, PWD);

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        SET @num := 0;
        UPDATE products SET id = @num := (@num + 1);
        ALTER TABLE products AUTO_INCREMENT = 1;
    ";
    

    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
