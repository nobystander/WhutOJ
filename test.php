<?php 

    $pdo = null;
    try
    {
        $pdo = new PDO(
            "mysql:host=127.0.0.1;dbname=oj;port=3306;charset=utf8",
            'root',
            'msi'
        );
        
    }
    catch(PDOException $e)
    {
        echo 'ERROR';
        exit; 
    }

    $sql = "SELECT problem_id FROM oj_problem WHERE title = :title";
$statement = $pdo->prepare($sql);
    
$title = 'asd';

    $statement->bindValue(':title',$title);
$statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
echo $result[0]['problem_id'];


?>