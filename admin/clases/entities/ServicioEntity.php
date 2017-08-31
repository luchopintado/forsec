<?php

class ServicioEntity extends EntityBase implements DBOCrud{

  var $servicio_id='';
  var $servicio_nombre='';
  var $servicio_descripcion='';
  var $servicio_fechareg='';
  var $servicio_user='';
  var $servicio_image='';
  var $servicio_thumb='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["servicio_id"])) {
      if ($options["servicio_id"] == "") {
        $options["servicio_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($servicio_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM servicio WHERE servicio_id=:servicio_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':servicio_id', $servicio_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row){
        return new ServicioEntity($row);
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

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM servicio ' . $whereClause . $orderClause .' LIMIT :start, :limit';
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
      $servicios = array();
      while($row = $stmt->fetch()){
        $servicio = new ServicioEntity($row);
        $servicios[] = $servicio;
      }
      return array("servicios"=>$servicios, "totalCount"=>$rowTotal["totalCount"]);
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
      $stmt = $pdo->prepare('DELETE FROM servicio WHERE servicio_id=:servicio_id LIMIT 1');
      $stmt->bindParam(':servicio_id', $this->servicio_id, PDO::PARAM_INT);
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
          'INSERT INTO servicio(
            servicio_nombre , 
            servicio_descripcion , 
            servicio_fechareg , 
            servicio_user , 
            servicio_image , 
            servicio_thumb
        )
        VALUES(
            :servicio_nombre , 
            :servicio_descripcion , 
            :servicio_fechareg , 
            :servicio_user , 
            :servicio_image , 
            :servicio_thumb
        )'
      );
      $stmt->bindParam(':servicio_nombre', $this->servicio_nombre, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_descripcion', $this->servicio_descripcion, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_fechareg', $this->servicio_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_user', $this->servicio_user, PDO::PARAM_INT);
      $stmt->bindParam(':servicio_image', $this->servicio_image, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_thumb', $this->servicio_thumb, PDO::PARAM_STR);
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
          'UPDATE servicio SET
          servicio_nombre=:servicio_nombre,
          servicio_descripcion=:servicio_descripcion,
          servicio_fechareg=:servicio_fechareg,
          servicio_user=:servicio_user,
          servicio_image=:servicio_image,
          servicio_thumb=:servicio_thumb
          WHERE servicio_id=:servicio_id
          LIMIT 1'
      );
      $stmt->bindParam(':servicio_nombre', $this->servicio_nombre, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_descripcion', $this->servicio_descripcion, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_fechareg', $this->servicio_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_user', $this->servicio_user, PDO::PARAM_INT);
      $stmt->bindParam(':servicio_image', $this->servicio_image, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_thumb', $this->servicio_thumb, PDO::PARAM_STR);
      $stmt->bindParam(':servicio_id', $this->servicio_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}