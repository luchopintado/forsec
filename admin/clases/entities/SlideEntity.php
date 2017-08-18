<?php

class SlideEntity extends EntityBase implements DBOCrud{

  var $slide_id='';
  var $slide_name='';
  var $slide_image='';
  var $slide_section='';
  var $slide_user='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["slide_id"])) {
      if ($options["slide_id"] == "") {
        $options["slide_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($slide_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM slide WHERE slide_id=:slide_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':slide_id', $slide_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row){
        return new SlideEntity($row);
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

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM slide ' . $whereClause . $orderClause .' LIMIT :start, :limit';
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
      $slides = array();
      while($row = $stmt->fetch()){
        $slide = new SlideEntity($row);
        $slides[] = $slide;
      }
      return array("slides"=>$slides, "totalCount"=>$rowTotal["totalCount"]);
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
      $stmt = $pdo->prepare('DELETE FROM slide WHERE slide_id=:slide_id LIMIT 1');
      $stmt->bindParam(':slide_id', $this->slide_id, PDO::PARAM_INT);
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
          'INSERT INTO slide(
            slide_name ,
            slide_image ,
            slide_section ,
            slide_user
        )
        VALUES(
            :slide_name ,
            :slide_image ,
            :slide_section ,
            :slide_user
        )'
      );
      $stmt->bindParam(':slide_name', $this->slide_name, PDO::PARAM_STR);
      $stmt->bindParam(':slide_image', $this->slide_image, PDO::PARAM_STR);
      $stmt->bindParam(':slide_section', $this->slide_section, PDO::PARAM_STR);
      $stmt->bindParam(':slide_user', $this->slide_user, PDO::PARAM_INT);
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
          'UPDATE slide SET
          slide_name=:slide_name,
          slide_image=:slide_image,
          slide_section=:slide_section,
          slide_user=:slide_user
          WHERE slide_id=:slide_id
          LIMIT 1'
      );
      $stmt->bindParam(':slide_name', $this->slide_name, PDO::PARAM_STR);
      $stmt->bindParam(':slide_image', $this->slide_image, PDO::PARAM_STR);
      $stmt->bindParam(':slide_section', $this->slide_section, PDO::PARAM_STR);
      $stmt->bindParam(':slide_user', $this->slide_user, PDO::PARAM_INT);
      $stmt->bindParam(':slide_id', $this->slide_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}

