<?php

class ObraEntity extends EntityBase implements DBOCrud{

  var $obra_id='';
  var $obra_nombre='';
  var $obra_descripcion='';
  var $obra_fechareg='';
  var $obra_user='';
  var $obra_imagen='';
  var $obra_layout='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["obra_id"])) {
      if ($options["obra_id"] == "") {
        $options["obra_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($obra_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM obra WHERE obra_id=:obra_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':obra_id', $obra_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row){
        return new ObraEntity($row);
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

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM obra ' . $whereClause . $orderClause .' LIMIT :start, :limit';
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
      $obras = array();
      while($row = $stmt->fetch()){
        $obra = new ObraEntity($row);
        $obras[] = $obra;
      }
      return array("obras"=>$obras, "totalCount"=>$rowTotal["totalCount"]);
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
      $stmt = $pdo->prepare('DELETE FROM obra WHERE obra_id=:obra_id LIMIT 1');
      $stmt->bindParam(':obra_id', $this->obra_id, PDO::PARAM_INT);
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
          'INSERT INTO obra(
            obra_nombre , 
            obra_descripcion , 
            obra_fechareg , 
            obra_user , 
            obra_imagen , 
            obra_layout
        )
        VALUES(
            :obra_nombre , 
            :obra_descripcion , 
            :obra_fechareg , 
            :obra_user , 
            :obra_imagen , 
            :obra_layout
        )'
      );
      $stmt->bindParam(':obra_nombre', $this->obra_nombre, PDO::PARAM_STR);
      $stmt->bindParam(':obra_descripcion', $this->obra_descripcion, PDO::PARAM_STR);
      $stmt->bindParam(':obra_fechareg', $this->obra_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':obra_user', $this->obra_user, PDO::PARAM_INT);
      $stmt->bindParam(':obra_imagen', $this->obra_imagen, PDO::PARAM_STR);
      $stmt->bindParam(':obra_layout', $this->obra_layout, PDO::PARAM_INT);
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
          'UPDATE obra SET
          obra_nombre=:obra_nombre,
          obra_descripcion=:obra_descripcion,
          obra_fechareg=:obra_fechareg,
          obra_user=:obra_user,
          obra_imagen=:obra_imagen,
          obra_layout=:obra_layout
          WHERE obra_id=:obra_id
          LIMIT 1'
      );
      $stmt->bindParam(':obra_nombre', $this->obra_nombre, PDO::PARAM_STR);
      $stmt->bindParam(':obra_descripcion', $this->obra_descripcion, PDO::PARAM_STR);
      $stmt->bindParam(':obra_fechareg', $this->obra_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':obra_user', $this->obra_user, PDO::PARAM_INT);
      $stmt->bindParam(':obra_imagen', $this->obra_imagen, PDO::PARAM_STR);
      $stmt->bindParam(':obra_layout', $this->obra_layout, PDO::PARAM_INT);
      $stmt->bindParam(':obra_id', $this->obra_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}
        
