<?php

//Returns the specified table in the html format
//based on https://www.php-einfach.de/mysql-tutorial/
function getHTMLTable($tableName)
{

    $pdo = getConnection();
    $statement = $pdo->prepare("SELECT * FROM $tableName");
    $statement->execute();
    $table = "<table>";
    while ($row = $statement->fetch()) {
        $table.="<tr>";
         for($i = 0; $i < count($row); $i++){
            if(array_key_exists($i, $row)){
                $table.="<td>";
                $table.=($row[$i]);
                $table.="</td>";
            }
           
        }
        $table.="</tr>";
    }
    $table.="</table>";
    return $table;
}

//Insert a row ny specifying the table name, the columns (array) and corresponding values (array)
//based on https://www.php-einfach.de/mysql-tutorial/
function insertValues($tableName, $columns, $values){
    if(count($columns) != count($values)){
        die("Number of column elements and values must be equal!");
    }
    $pdo = getConnection();
    $n =  count($columns);
    $sql = "INSERT INTO $tableName (". implode(",", $columns) . ") VALUES (". str_repeat("?,", $n-1) . "?)";
    echo $sql;
    $statement = $pdo->prepare($sql);
    $statement->execute($values);
}

//Returns a mysql database connection for db elgadb (user root)
//based on https://www.w3schools.com/php/php_mysql_connect.asp
function getConnection()
{

    $servername = "localhost";
    $dbname = "elgadb";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=" . $dbname, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
    return $conn;
}
