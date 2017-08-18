<?php

class ServicioEntity extends EntityBase implements DBOCrud{

  var $servicios_id='';
  var $servicios_nombre='';
  var $servicios_descripcion='';
  var $servicios_fechareg='';
  var $servicios_user='';
  var $servicios_image='';
  var $servicios_thumb='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["servicios_id"])) {
      if ($options["servicios_id"] == "") {
        $options["servicios_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($servicios_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM servicios WHERE servicios_id=:servicios_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':servicios_id', $servicios_id, PDO::PARAM_INT);
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

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM servicios ' . $whereClause . $orderClause .' LIMIT :start, :limit';
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
      $stmt = $pdo->prepare('DELETE FROM servicios WHERE servicios_id=:servicios_id LIMIT 1');
      $stmt->bindParam(':servicios_id', $this->servicios_id, PDO::PARAM_INT);
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
          'INSERT INTO servicios(
            servicios_nombre , 
            servicios_descripcion , 
            servicios_fechareg , 
            servicios_user , 
            servicios_image , 
            servicios_thumb
        )
        VALUES(
            :servicios_nombre , 
            :servicios_descripcion , 
            :servicios_fechareg , 
            :servicios_user , 
            :servicios_image , 
            :servicios_thumb
        )'
      );
      $stmt->bindParam(':servicios_nombre', $this->servicios_nombre, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_descripcion', $this->servicios_descripcion, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_fechareg', $this->servicios_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_user', $this->servicios_user, PDO::PARAM_INT);
      $stmt->bindParam(':servicios_image', $this->servicios_image, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_thumb', $this->servicios_thumb, PDO::PARAM_STR);
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
          'UPDATE servicios SET
          servicios_nombre=:servicios_nombre,
          servicios_descripcion=:servicios_descripcion,
          servicios_fechareg=:servicios_fechareg,
          servicios_user=:servicios_user,
          servicios_image=:servicios_image,
          servicios_thumb=:servicios_thumb
          WHERE servicios_id=:servicios_id
          LIMIT 1'
      );
      $stmt->bindParam(':servicios_nombre', $this->servicios_nombre, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_descripcion', $this->servicios_descripcion, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_fechareg', $this->servicios_fechareg, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_user', $this->servicios_user, PDO::PARAM_INT);
      $stmt->bindParam(':servicios_image', $this->servicios_image, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_thumb', $this->servicios_thumb, PDO::PARAM_STR);
      $stmt->bindParam(':servicios_id', $this->servicios_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}
        
