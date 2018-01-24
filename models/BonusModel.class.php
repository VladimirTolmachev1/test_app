<?php
class BonusModel {

    function BonusModel()
    {
        $this->table_name = 'bonus';
    }

    function saveBonus($uid, $amount){
        if(!$uid)
            return false;

        // PDO connect
        $DB = new DB();
        $pdo = $DB->connect();

        // Check if we have record with the same user
        $select_sql = "SELECT *
				FROM `$this->table_name`
				WHERE `uid` = :uid";

        $select_query = $pdo->prepare($select_sql);
        $select_query->execute([
            ':uid' => $uid
        ]);

        $row = $select_query->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($row)){
            // Update SQL
            $update_sql = "UPDATE `$this->table_name` SET `amount` = :amount WHERE `uid` = :uid";

            $update_sql = $pdo->prepare($update_sql);
            try {
                $update_sql->execute([
                    ':amount' => $amount,
                    ':uid' => $uid,
                ]);

                return true;
            }catch (PDOException $ex){
                echo $ex->getMessage();
                return false;
            }
        }else{
            // Insert SQL
            $insert_sql = "INSERT INTO `$this->table_name` (`uid`, `amount`) VALUES (:uid, :amount)";
            $insert_query = $pdo->prepare($insert_sql);
            try{
                $insert_query->execute([
                    ':uid' => $uid,
                    ':amount' => $amount
                ]);

                return true;
            }catch (PDOException $ex){
                echo $ex->getMessage();
                return false;
            }
        }
    }

    /**
     * Function to get bonus amount by UID
     *
     * @param $uid
     * @return int
     */
    function getBonusByUid($uid){
        if(!$uid)
            return 0;

        // PDO connect
        $DB = new DB();
        $pdo = $DB->connect();

        // Generate select sql
        $select_sql = "SELECT *
				FROM `$this->table_name`
				WHERE `uid` = :uid";

        $select_query = $pdo->prepare($select_sql);
        $select_query->execute([
            ':uid' => $uid
        ]);

        $row = $select_query->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($row))
            return $row[0]['amount'];

        return 0;
    }
}