<?php

class ArticleEntity extends EntityBase implements DBOCrud{

  var $article_id='';
  var $article_title='';
  var $article_description='';
  var $article_user='';

  public function __construct($options = array()) {
    parent::__construct($options);
  }

  public function storeFormValues(&$options) {
    $pattern = "/[^\.\,\-\_'\"\@\?\!\:\$ a-zA-Z0-9()áéíóúÁÉÍÓÚüÜ]/";
    if (isset($options["article_id"])) {
      if ($options["article_id"] == "") {
        $options["article_id"] = null;
      }
    }
    //Add validation for other fields, specially STRINGS!
    $this->__construct($options);
  }

  public static function getById($article_id) {
    try{
      global $pdo;
      $sql = "SELECT * FROM article WHERE article_id=:article_id LIMIT 1";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row){
        return new ArticleEntity($row);
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

      $query = 'SELECT SQL_CALC_FOUND_ROWS * FROM article ' . $whereClause . $orderClause .' LIMIT :start, :limit';
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
      $articles = array();
      while($row = $stmt->fetch()){
        $article = new ArticleEntity($row);
        $articles[] = $article;
      }
      return array("articles"=>$articles, "totalCount"=>$rowTotal["totalCount"]);
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
      $stmt = $pdo->prepare('DELETE FROM article WHERE article_id=:article_id LIMIT 1');
      $stmt->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
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
          'INSERT INTO article(
            article_title , 
            article_description , 
            article_user
        )
        VALUES(
            :article_title , 
            :article_description , 
            :article_user
        )'
      );
      $stmt->bindParam(':article_title', $this->article_title, PDO::PARAM_STR);
      $stmt->bindParam(':article_description', $this->article_description, PDO::PARAM_STR);
      $stmt->bindParam(':article_user', $this->article_user, PDO::PARAM_INT);
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
          'UPDATE article SET
          article_title=:article_title,
          article_description=:article_description,
          article_user=:article_user
          WHERE article_id=:article_id
          LIMIT 1'
      );
      $stmt->bindParam(':article_title', $this->article_title, PDO::PARAM_STR);
      $stmt->bindParam(':article_description', $this->article_description, PDO::PARAM_STR);
      $stmt->bindParam(':article_user', $this->article_user, PDO::PARAM_INT);
      $stmt->bindParam(':article_id', $this->article_id, PDO::PARAM_INT);
      $stmt->execute();
      # Affected Rows?
      return $stmt->rowCount();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage();
    }
  }

}
        
