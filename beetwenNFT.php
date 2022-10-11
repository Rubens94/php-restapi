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
    if(isset($_GET['start']) and isset($_GET['end'])){ 
        $prdouctsPerPage = 100;
        $page = $_GET['page'];
        $ofset = ($page - 1) * $prdouctsPerPage;
        $start = $_GET['start'];
        $end = $_GET['end'];
        $sql = $dbConn->prepare("SELECT * FROM lazynfts a INNER JOIN collections b ON a.idcollection=b.ID WHERE a.NFTid BETWEEN $start AND $end AND a.Minted = 0 LIMIT $prdouctsPerPage OFFSET $ofset");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);

        $query = $dbConn->prepare("SELECT count(*) AS results FROM lazynfts WHERE NFTid BETWEEN $start AND $end AND Minted = 0");
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);

        $results = $dbConn->prepare("SELECT count(*) AS results FROM lazynfts WHERE NFTid BETWEEN $start AND $end AND Minted = 0");
        $results->execute();
        $results->setFetchMode(PDO::FETCH_ASSOC);

        header("HTTP/1.1 200 OK");
        $pages = array();
        $pages['pages']=round($query->fetchAll()[0]['results']/$prdouctsPerPage);
        $total = array();
        $total['results']=$results->fetchAll()[0]['results'];

        $back = array();
        $next = array();
        $back['back'] = 'http://localhost/apirest/beetwenNFT.php?start=' . $start . '&end=' . $end .'&page=' . $page - 1;
        $next['next'] = 'http://localhost/apirest/beetwenNFT.php?start=' . $start . '&end=' . $end .'&page=' . $page + 1;

        if($page <= 1) {
            $back['back'] = 'http://localhost/apirest/beetwenNFT.php?start=' . $start . '&end=' . $end .'&page=1';
        }

        if($pages['pages'] == 0) {
            $pages['pages'] = 1;
        }

        if($page >= $pages['pages'] ) {
            $next['next'] = 'http://localhost/apirest/beetwenNFT.php?start=' . $start . '&end=' . $end .'&page=' . $pages['pages'];
        }

        $array = array($pages, $total, $back, $next, $sql->fetchAll(PDO::FETCH_ASSOC));
        echo json_encode($array, JSON_UNESCAPED_SLASHES);
    }
}