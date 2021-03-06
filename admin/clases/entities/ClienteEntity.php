<?php

class ClienteEntity extends EntityBase implements DBOCrud{

  var $cliente_id='';
  var $cliente_razon='';
  var $cliente_fechareg='';
  var $cliente_user='';
  var $cliente_image='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["cliente_id"])) {
      if ($options["cliente_id"] == "") {
        $options["cliente_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($cliente_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM cliente WHERE cliente_id=:cliente_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row){
        return new ClienteEntity($row);
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

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM cliente ' . $whereClause . $orderClause .' LIMIT :start, :limit';
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
      $clientes = array();
      while($row = $stmt->fetch()){
        $cliente = new ClienteEntity($row);
        $clientes[] = $cliente;
      }
      return array("clientes"=>$clientes, "totalCount"=>$rowTotal["totalCount"]);
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
      $stmt = $pdo->prepare('DELETE FROM cliente WHERE cliente_id=:cliente_id LIMIT 1');
      $stmt->bindParam(':cliente_id', $this->cliente_id, PDO::PARAM_INT);
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
          'INSERT INTO cliente(
            cliente_razon , 
            cliente_fechareg , 
            cliente_user , 
            cliente_image
        )
        VALUES(
            :cliente_razon , 
            :cliente_fechareg , 
            :cliente_user , 
            :cliente_image
        )'
      );
      $stmt->bindParam(':cliente_razon', $this->cliente_razon, PDO::PARAM_STR);
      $stmt->bindParam(':cliente_fechareg', $this->cliente_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':cliente_user', $this->cliente_user, PDO::PARAM_INT);
      $stmt->bindParam(':cliente_image', $this->cliente_image, PDO::PARAM_STR);
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
          'UPDATE cliente SET
          cliente_razon=:cliente_razon,
          cliente_fechareg=:cliente_fechareg,
          cliente_user=:cliente_user,
          cliente_image=:cliente_image
          WHERE cliente_id=:cliente_id
          LIMIT 1'
      );
      $stmt->bindParam(':cliente_razon', $this->cliente_razon, PDO::PARAM_STR);
      $stmt->bindParam(':cliente_fechareg', $this->cliente_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':cliente_user', $this->cliente_user, PDO::PARAM_INT);
      $stmt->bindParam(':cliente_image', $this->cliente_image, PDO::PARAM_STR);
      $stmt->bindParam(':cliente_id', $this->cliente_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}
        
