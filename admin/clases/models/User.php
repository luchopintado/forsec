<?php

class User extends UserEntity {
	public static function checkLogin($user, $pass){
        try {
            global $pdo;
            $sql = "SELECT *
                    FROM user u
                    WHERE user_nick=:usuario_user and user_pass=sha1(:usuario_pass) LIMIT 1";
            $stmt = $pdo->prepare($sql);
            //$pass = md5($pass);
            $stmt->bindParam(':usuario_user', $user, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_pass', $pass, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if($row){
                return new User($row);
            }else{
                return NULL;
            }

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
