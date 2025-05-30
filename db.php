<?php

// Database connection using PDO
function dbConn()
{
    try {
        // Set DSN (Data Source Name)
        $dsn = "mysql:host=" . HOST . ";dbname=" . DB . ";charset=utf8";
        // Create a new PDO instance
        $pdo = new PDO($dsn, USER, PWD);
        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Error in connecting database: " . $e->getMessage();
        exit();
    }
}

// Close the PDO connection (optional, as it closes automatically at the end of the script)
function dbClose($pdo)
{
    $pdo = null;
}

// Select a table from a database
function dbSelect($table, $column="*", $criteria="", $clause="")
{
    if(empty($table))
    {
        return false;
    }

    $sql = "SELECT " . $column . " FROM " . $table;
    if(!empty($criteria))
    {
        $sql .= " WHERE " . $criteria;
    }
    if(!empty($clause))
    {
        $sql .= " " . $clause;
    }

    $pdo = dbConn();
    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error in selecting data: " . $e->getMessage();
        return false;
    } finally {
        dbClose($pdo);
    }
}

// Insert a record into a database
function dbInsert($table, $data=array())
{
    if(empty($table) || empty($data))
    {
        return false;
    }

    $pdo = dbConn();
    $fields = implode(",", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO " . $table . " (" . $fields . ") VALUES (" . $placeholders . ")";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        return true;
    } catch (PDOException $e) {
        echo "Error description: " . $e->getMessage();
        return false;
    } finally {
        dbClose($pdo);
    }
}

// Update a record in a database
function dbUpdate($table, $data=array(), $criteria="")
{
    if(empty($table) || empty($data) || empty($criteria))
    {
        return false;
    }

    $pdo = dbConn();
    $setClause = "";
    foreach($data as $field => $value)
    {
        $setClause .= $field . " = :" . $field . ", ";
    }
    $setClause = rtrim($setClause, ", ");

    $sql = "UPDATE " . $table . " SET " . $setClause . " WHERE " . $criteria;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        return true;
    } catch (PDOException $e) {
        echo "Error description: " . $e->getMessage();
        return false;
    } finally {
        dbClose($pdo);
    }
}

// Delete a record from a database
function dbDelete($table, $criteria)
{
    if(empty($table) || empty($criteria))
    {
        return false;
    }

    $sql = "DELETE FROM " . $table . " WHERE " . $criteria;
    $pdo = dbConn();

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error description: " . $e->getMessage();
        return false;
    } finally {
        dbClose($pdo);
    }
}

// Count records in a database
function dbCount($table="", $criteria="")
{
    if (empty($table))
    {
        return false;
    }

    $sql = "SELECT COUNT(*) FROM " . $table;
    if(!empty($criteria)){
        $sql .= " WHERE " . $criteria;
    }

    $pdo = dbConn();
    try {
        $stmt = $pdo->query($sql);
        $count = $stmt->fetchColumn();
        return $count;
    } catch (PDOException $e) {
        echo "Error description: " . $e->getMessage();
        return false;
    } finally {
        dbClose($pdo);
    }
}
?>
