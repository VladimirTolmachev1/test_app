<?php
class UsersModel{

    function UsersModel()
    {
        $this->table_name = 'users';
    }

    /**
     * Function get user by login
     *
     * @param $login
     * @return array|bool
     */
    function getUserByLogin($login){
        if(!$login)
            return false;

        // PDO connect
        $DB = new DB();
        $pdo = $DB->connect();

        // Generate SQL
        $sql = "SELECT *
				FROM `$this->table_name`
				WHERE `login` = :login
				AND `status` = 1";

        $query = $pdo->prepare($sql);
        $query->bindValue(':login', trim($login), PDO::PARAM_STR);
        $query->execute();

        //Get Data
        $row = $query->fetchAll(PDO::FETCH_ASSOC);

        if(empty($row))
            return false;

        return $row;
    }
}