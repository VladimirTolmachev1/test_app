<?php
class PresentsModel {

    function PresentsModel()
    {
        $this->table_name = 'presents';
    }

    function savePresent($uid, $present_name, $status = 'in_progress'){
        if(!$uid)
            return false;

        // PDO connect
        $DB = new DB();
        $pdo = $DB->connect();

        // Insert SQL
        $insert_sql = "INSERT INTO `$this->table_name` (`uid`, `present_name`, `status`) VALUES (:uid, :present_name, :status)";
        $insert_query = $pdo->prepare($insert_sql);

        try{
            $insert_query->execute([
                ':uid' => $uid,
                ':present_name' => $present_name,
                ':status' => $status
            ]);

            return true;
        }catch (PDOException $ex){
            echo $ex->getMessage();
            return false;
        }
    }
}