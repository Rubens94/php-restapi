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

    $eyes = array();
    $mouths = array();
    $hats = array();
    $glasses = array();
    $clothing = array();
    $others = array();

    $queryHats = "";
    $queryEyes ="";
    $queryMouths = "";
    $queryGlasses = "";
    $queryClothing = "";
    $queryOthers = "";

    for($j = 0; $j <= count($data)-1; $j++){
        if(array_keys($data[$j]) == ["Eyes"]){
            $eyes[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Mouths"]){
            $mouths[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Hats"]){
            $hats[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Glasses"]){
            $glasses[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Clothing"]){
            $clothing[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Others"]){
            $others[] = array_keys($data[$j]);
        }
    }

    for($k = 0; $k <= count($data)-1; $k++){
        if(array_keys($data[$k]) == ["Eyes"]){
            if(count($eyes) == 1){
                $queryEyes .= " AND (a.Attributes->'$.Eyes' = '".$data[$k]['Eyes']. "')";
            } elseif(count($eyes) >= 2){
                $queryEyes .= " AND (a.Attributes->'$.Eyes' = '".$data[$k]['Eyes']. "') OR";
            }
            $sentence = $queryEyes;
            $search = ") OR AND (a.Attributes->'$.Eyes'";
            $replace = " OR a.Attributes->'$.Eyes'";
            $queryEyes = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Hats"]){
            if(count($hats) == 1){
                $queryHats .= " AND (a.Attributes->'$.Hats' = '".$data[$k]['Hats']. "')";
            } elseif(count($hats) >= 2){
                $queryHats .= " AND (a.Attributes->'$.Hats' = '".$data[$k]['Hats']. "') OR";
            }
            $sentence = $queryHats;
            $search = ") OR AND (a.Attributes->'$.Hats'";
            $replace = " OR a.Attributes->'$.Hats'";
            $queryHats = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Mouths"]){
            if(count($mouths) == 1){
                $queryMouths .= " AND (a.Attributes->'$.Mouths' = '".$data[$k]['Mouths']. "')";
            } elseif(count($mouths) >= 2){
                $queryMouths .= " AND (a.Attributes->'$.Mouths' = '".$data[$k]['Mouths']. "') OR";
            }
            $sentence = $queryMouths;
            $search = ") OR AND (a.Attributes->'$.Mouths'";
            $replace = " OR a.Attributes->'$.Mouths'";
            $queryMouths = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Glasses"]){
            if(count($glasses) == 1){
                $queryGlasses .= " AND (a.Attributes->'$.Glasses' = '".$data[$k]['Glasses']. "')";
            } elseif(count($glasses) >= 2){
                $queryGlasses .= " AND (a.Attributes->'$.Glasses' = '".$data[$k]['Glasses']. "') OR";
            }
            $sentence = $queryGlasses;
            $search = ") OR AND (a.Attributes->'$.Glasses'";
            $replace = " OR a.Attributes->'$.Glasses'";
            $queryGlasses = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Clothing"]){
            if(count($clothing) == 1){
                $queryClothing .= " AND (a.Attributes->'$.Clothing' = '".$data[$k]['Clothing']. "')";
            } elseif(count($clothing) >= 2){
                $queryClothing .= " AND (a.Attributes->'$.Clothing' = '".$data[$k]['Clothing']. "') OR";
            }
            $sentence = $queryClothing;
            $search = ") OR AND (a.Attributes->'$.Clothing'";
            $replace = " OR a.Attributes->'$.Clothing'";
            $queryClothing = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Others"]){
            if(count($others) == 1){
                $queryOthers .= " AND (a.Attributes->'$.Others' = '".$data[$k]['Others']. "')";
            } elseif(count($others) >= 2){
                $queryOthers .= " AND (a.Attributes->'$.Others' = '".$data[$k]['Others']. "') OR";
            }
            $sentence = $queryOthers;
            $search = ") OR AND (a.Attributes->'$.Others'";
            $replace = " OR a.Attributes->'$.Others'";
            $queryOthers = str_replace($search, $replace, $sentence);
        }
    }

    $query .= $queryHats;
    $query .= $queryEyes;
    $query .= $queryMouths;
    $query .= $queryGlasses;
    $query .= $queryClothing;
    $query .= $queryOthers;

    $query .= " AND a.Minted = 0 LIMIT $prdouctsPerPage OFFSET $ofset";

    $sentence = $query;
    $search = " WHERE  AND ";
    $replace = " WHERE ";
    $query = str_replace($search, $replace, $sentence);

    $sentence2 = $query;
    $search2 = "ORAND";
    $replace2 = "AND";
    $query = str_replace($search2, $replace2, $sentence2);

    $sentence3 = $query;
    $search3 = "OR AND";
    $replace3 = "AND";
    $query = str_replace($search3, $replace3, $sentence3);

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

    header("HTTP/1.1 200 OK");
    $array = array($pages, $total, $back, $next, $sql->fetchAll());
    echo json_encode($array);
}