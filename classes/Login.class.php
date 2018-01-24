<?php

class Login{
    /**
     * Login constructor.
     */
    function Login(){
        if(isset($_SESSION['user'])){
            $this->is_logged = $_SESSION['user'];
            if(isset($_SESSION['user_name']))
                $this->user_name = $_SESSION['user_name'];
            if(isset($_SESSION['uid']))
                $this->uid = $_SESSION['uid'];

        }else{
            $this->is_logged = false;
        }

    }

    /**
     * Login function
     *
     * @return bool
     */
    function doLogin(){
        if(!isset($_POST['login']) || !isset($_POST['pass']))
            return false;

        // Check login
        if(empty($_POST['login']))
            $err[] = 'Login field is empty!';

        // Check password
        if(empty($_POST['pass']))
            $err[] = 'Password field is empty!';

        // Check if we have errors
        if(!empty($err)) {
            echo $this->showErrorMessage($err);
            return false;
        }
        else
        {
            $usersModel = new UsersModel();
            $user = $usersModel->getUserByLogin($_POST['login']);

            //Check if password is correct
            if(md5(md5($_POST['pass']).$user[0]['salt']) == $user[0]['pass'])
            {
                $_SESSION['user'] = true;
                $this->is_logged = true;
                $this->uid = $_SESSION['uid'] = $user[0]['id'];
                $this->user_name = $_SESSION['user_name'] = $user[0]['login'];

                header('Location:' . HOST . '?class=game&action=index' );
                exit;
            }
            else
                echo $this->showErrorMessage('Wrong password! Please try again!');
        }
    }

    /**
     * Logout and destroy session;
     */
    function doLogout(){
        $this->is_logged = false;
        session_destroy();
    }

    /**
     * Function to show error message
     *
     * @param $data
     * @return string
     */
    function showErrorMessage($data)
    {
        $err = '<ul>'."\n";

        if(is_array($data))
            foreach($data as $val)
                $err .= '<li style="color:red;">'. $val .'</li>'."\n";
        else
            $err .= '<li style="color:red;">'. $data .'</li>'."\n";

        $err .= '</ul>'."\n";

        return $err;
    }

}