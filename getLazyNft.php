<?php
include "config.php";
include "utils.php";
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD']; 


$dbConn =  connect($db);

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    if (isset($_GET['id']))
    {
      $sql = $dbConn->prepare("SELECT * FROM lazynfts a INNER JOIN collections b ON a.idcollection=b.ID where NFTid=:id AND a.Minted = 0");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
    elseif (isset($_GET['page'])) {
      $prdouctsPerPage = 100;
      $page = $_GET['page'];
      $ofset = ($page - 1) * $prdouctsPerPage;

      $query = $dbConn->prepare("SELECT count(*) AS results FROM lazynfts WHERE Minted = 0");
      $query->execute();
      $query->setFetchMode(PDO::FETCH_ASSOC);

      $results = $dbConn->prepare("SELECT count(*) AS results FROM lazynfts WHERE Minted = 0");
      $results->execute();
      $results->setFetchMode(PDO::FETCH_ASSOC);

      $sql = $dbConn->prepare("SELECT * FROM lazynfts a INNER JOIN collections b ON a.idcollection=b.ID AND a.Minted = 0 LIMIT $prdouctsPerPage OFFSET $ofset");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);

      $pages = array();
      $pages['pages']=round($query->fetchAll()[0]['results']/$prdouctsPerPage);
      $total = array();
      $total['results']=$results->fetchAll()[0]['results'];

      $back = array();
      $next = array();
      $back['back'] = 'http://localhost/apirest/getLazyNft.php?page=' . $page - 1;
      $next['next'] = 'http://localhost/apirest/getLazyNft.php?page=' . $page + 1;

    if($page <= 1) {
      $back['back'] = 'http://localhost/apirest/getLazyNft.php?page=1';
    }

    if($pages['pages'] == 0) {
        $pages['pages'] = 1;
    }

    if($page >= $pages['pages'] ) {
        $next['next'] = 'http://localhost/apirest/getLazyNft.php?page=' . $pages['pages'];
    }

    header("HTTP/1.1 200 OK");
    $array = array($pages, $total, $back, $next, $sql->fetchAll());
    echo json_encode($array);

    exit();
	}
}

?>