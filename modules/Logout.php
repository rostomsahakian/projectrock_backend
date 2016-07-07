<?php

/**
 * Description of Logout
 *
 * @author rostom
 */
class Logout {

    private $_mysqli;
    private $_db;

    public function __construct() {
        $this->_db = DB_Connect::getInstance();
        $this->_mysqli = $this->_db->getConnection();
    }

    public function DoLogOut($session_code) {
        if ($session_code != "") {
            $new_login_code = uniqid();
            $sql = "UPDATE `rock_users` SET `login_code` = '" . $new_login_code . "' WHERE `login_code` ='" . $session_code . "'";
            $result = $this->_mysqli->query($sql);
            if ($result) {
                unset($_SESSION);
                session_destroy();
                header("Location: rock_backend/admin/index.php");
            }
        }
    }

}
