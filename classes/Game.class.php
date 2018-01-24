<?php

class Game{
    function __construct()
    {
        if(isset($_GET['action']))
            $action = $_GET['action'];

        switch ($action){
            case 'index':
                $this->indexAction();
                break;

            case 'savePresent':
                $this->savePresentAction();
                break;

            case 'saveMoney':
                $this->saveMoneyAction();
                break;

            case 'saveBonus':
                $this->saveBonusAction();
                break;
        }
    }

    function indexAction(){
        $login = new Login();
        $money_amount = (new MoneyModel())->getMoneyByUid($login->uid);
        $bonus_amount = (new BonusModel())->getBonusByUid($login->uid);

        include './view/game/game.html';
    }

    /**
     * Function to save present
     *
     * @return bool
     */
    function savePresentAction(){
        // Get login object
        $login = new Login();
        if(empty($login))
            return false;

        // Get present name from post
        $present_name = $_POST['present_name'];

        // Save present into DB
        $presentsModel = new PresentsModel();
        $save_res = $presentsModel->savePresent($login->uid, $present_name);

        if($save_res)
            return true;

        return false;
    }

    /**
     * Function to save money
     *
     * @return bool
     */
    function saveMoneyAction(){
        // Get login object
        $login = new Login();
        if(empty($login))
            return false;

        // Get money count from post
        $money_count = $_POST['money_count'];

        // Save present into DB
        $moneyModel = new MoneyModel();
        $save_res = $moneyModel->saveMoney($login->uid, $money_count);

        if($save_res)
            return true;

        return false;
    }

    /**
     * Function to save money
     *
     * @return bool
     */
    function saveBonusAction(){
        // Get login object
        $login = new Login();
        if(empty($login))
            return false;

        // Get bonus count from post
        $bonus_count = $_POST['bonus_count'];


        // Save present into DB
        $bonusModel = new BonusModel();
        $save_res = $bonusModel->saveBonus($login->uid, $bonus_count);

        if($save_res)
            return true;

        return false;
    }
}