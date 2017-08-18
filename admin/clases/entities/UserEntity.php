<?php

class UserEntity extends EntityBase implements DBOCrud{

  var $user_id='';
  var $user_nick='';
  var $user_pass='';
  var $user_email='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["user_id"])) {
      if ($options["user_id"] == "") {
        $options["user_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($user_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM user WHERE user_id=:user_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row){
        return new UserEntity($row);
      }else{
        return false;
      }
    } catch (Exception $exc) {
      echo $exc->getTraceAsString();
    }
  }

  public static function getByFields($whereParams = array(), $orderParams = array(), $start = 0, $limit = LIMIT_RESULT) {
    try {
      global $pdo;

      $orderClause = '';
      if(count($orderParams)>0){
        $arrOrderParams = array();
        foreach ($orderParams as $op){
          $arrOrderParams[] = sprintf("%s %s", $op["field"], $op["order"]);
        }
        $orderClause = ' ORDER by '. join(', ', $arrOrderParams);
      }

      $whereClause = '';
      if(count($whereParams)>0){
          $cadWhere = '';
          $i=1;
          foreach($whereParams as $wp){
              $cadWhere .= sprintf("%s %s :%s", $wp["field"], $wp["operator"], preg_replace('/[^a-zA-Z0-9]+/', '_', $wp["field"]));
              if($i<(count($whereParams))){
                  $cadWhere .= ' ' . $wp["conjunction"] . ' ';
              }
              $i++;
          }
          $whereClause = ' WHERE ' . $cadWhere;
      }

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM user ' . $whereClause . $orderClause .' LIMIT :start, :limit';
      $stmt = $pdo->prepare($query);
      if(count($whereParams)>0){
        foreach($whereParams as $wp){
          if($wp["operator"] == "="){
            $stmt->bindParam(':' . $wp["field"], $wp["value"]);
          }else{
            $wc_value = '%'.$wp["value"].'%';           //wildcards value
            $stmt->bindParam(':' . $wp["field"], $wc_value);
          }
          //$stmt->bindParam(':'.preg_replace('/[^a-zA-Z0-9]+/', '_', $wp["field"]), $wp["value"]);
        }
      }
      $stmt->bindParam(':start', $start, PDO::PARAM_INT);
      $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $pdo->query("SELECT FOUND_ROWS() AS totalCount");
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $rowTotal = $result->fetch();
      $useres = array();
      while($row = $stmt->fetch()){
        $user = new UserEntity($row);
        $user->user_pass = '';
        $useres[] = $user;
      }
      return array("useres"=>$useres, "totalCount"=>$rowTotal["totalCount"]);
    } catch (Exception $exc) {
      echo $exc->getTraceAsString();
    }
  }

  public static function getList($orderParams = array(), $start = 0, $limit = LIMIT_RESULT) {
    return self::getByFields(array(), $orderParams, $start, $limit);
  }

  public function delete() {
    try {
      global $pdo;
      $stmt = $pdo->prepare('DELETE FROM user WHERE user_id=:user_id LIMIT 1');
      $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
      $stmt->execute();
      if($stmt->rowCount() === 1){
        return true;
      }else{
        return false;
      }
    } catch (Exception $exc) {
      echo $exc->getTraceAsString();
    }
  }

  public function insert() {
    try {
      global $pdo;
      $stmt = $pdo->prepare(
          'INSERT INTO user(
            user_nick ,
            user_pass ,
            user_email
        )
        VALUES(
            :user_nick ,
            :user_pass ,
            :user_email
        )'
      );
      $stmt->bindParam(':user_nick', $this->user_nick, PDO::PARAM_STR);
      $stmt->bindParam(':user_pass', $this->user_pass, PDO::PARAM_STR);
      $stmt->bindParam(':user_email', $this->user_email, PDO::PARAM_STR);
      $stmt->execute();

      # Affected Rows?
      if($stmt->rowCount() === 1){
        return $pdo->lastInsertId();
      }else{
        return false;
      }
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage() . '\n '. $e->getTraceAsString();
    }
  }

  public function update() {
    try {
      global $pdo;
      $stmt = $pdo->prepare(
          'UPDATE user SET
          user_nick=:user_nick,
          user_pass=:user_pass,
          user_email=:user_email
          WHERE user_id=:user_id
          LIMIT 1'
      );
      $stmt->bindParam(':user_nick', $this->user_nick, PDO::PARAM_STR);
      $stmt->bindParam(':user_pass', $this->user_pass, PDO::PARAM_STR);
      $stmt->bindParam(':user_email', $this->user_email, PDO::PARAM_STR);
      $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}
