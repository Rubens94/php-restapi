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
    $body = json_decode(file_get_contents("php://input"), true);
    $data = $body['attributes'];
    $prdouctsPerPage = 100;
    $page = $_GET['page'];
    $ofset = ($page - 1) * $prdouctsPerPage;
    $query = "SELECT * FROM lazynfts a INNER JOIN collections b ON a.idcollection=b.ID WHERE ";

    header("HTTP/1.1 200 OK");

    for($i = 0; $i <= count($data)-1; $i++){
        if(array_keys($data[$i]) == ["filter"]){
            $query .= " ". $data[$i]['filter']." ";
        } elseif(array_keys($data[$i]) == ["Eyes"]){
            $query .= "a.Attributes->'$.Eyes' = '".$data[$i]['Eyes']. "'";
        } elseif(array_keys($data[$i]) == ["Hats"]){
            $query .= "a.Attributes->'$.Hats' = '".$data[$i]['Hats']. "'";
        } elseif(array_keys($data[$i]) == ["Mouths"]){
            $query .= "a.Attributes->'$.Mouths' = '".$data[$i]['Mouths']. "'";
        } elseif(array_keys($data[$i]) == ["Others"]){
            $query .= "a.Attributes->'$.Others' = '".$data[$i]['Others']. "'";
        } elseif(array_keys($data[$i]) == ["Glasses"]){
            $query .= "a.Attributes->'$.Glasses' = '".$data[$i]['Glasses']. "'";
        } elseif(array_keys($data[$i]) == ["Clothing"]){
            $query .= "a.Attributes->'$.Clothing' = '".$data[$i]['Clothing']. "'";
        }
    }

    $query .= " AND a.Minted = 0 LIMIT $prdouctsPerPage OFFSET $ofset";
    $sql = $dbConn->prepare($query);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    $sentence = $query;
    $search = "SELECT *";
    $replace = "SELECT count(*) AS results";
    $new_sentence = str_replace($search, $replace, $sentence);

    $new_sentence2 = substr($new_sentence, 0, -19);

    $results = $dbConn->prepare($new_sentence2);
    $results->execute();
    $results->setFetchMode(PDO::FETCH_ASSOC);

    $results2 = $dbConn->prepare($new_sentence2);
    $results2->execute();
    $results2->setFetchMode(PDO::FETCH_ASSOC);

    $pages = array();
    $pages['pages']=round($results->fetchAll()[0]['results']/$prdouctsPerPage);
    $total = array();
    $total['results']=$results2->fetchAll()[0]['results'];

    $back = array();
    $next = array();
    $back['back'] = 'http://localhost/apirest/filterNFTs.php?page=' . $page - 1;
    $next['next'] = 'http://localhost/apirest/filterNFTs.php?page=' . $page + 1;

    if($page <= 1) {
        $back['back'] = 'http://localhost/apirest/filterNFTs.php?page=1';
    }

    if($pages['pages'] == 0) {
        $pages['pages'] = 1;
    }

    if($page >= $pages['pages'] ) {
        $next['next'] = 'http://localhost/apirest/filterNFTs.php?page=' . $pages['pages'];
    }

    $array = array($query, $pages, $total, $back, $next, $sql->fetchAll());
    echo json_encode($array);
}