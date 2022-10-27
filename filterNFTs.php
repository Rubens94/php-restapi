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
    $order = $_GET['order'];
    $ofset = ($page - 1) * $prdouctsPerPage;
    $start = $_GET['start'];
    $end = $_GET['end'];
    $query = "SELECT * FROM lazynfts a INNER JOIN collections b ON a.idcollection=b.ID WHERE ";

    $eyes = array();
    $mouth = array();
    $hat = array();
    $glasses = array();
    $clothing = array();
    $ears = array();
    $jacket = array();
    $rarity = array();
    $background = array();
    $accessories = array();

    $queryHat = "";
    $queryEyes ="";
    $queryMouth = "";
    $queryGlasses = "";
    $queryClothing = "";
    $queryEars = "";
    $queryJacket ="";
    $queryRarity ="";
    $queryBackground ="";
    $queryAccessories="";

    for($j = 0; $j <= count($data)-1; $j++){
        if(array_keys($data[$j]) == ["Eyes"]){
            $eyes[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Mouth"]){
            $mouth[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Hat"]){
            $hat[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Glasses"]){
            $glasses[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Clothing"]){
            $clothing[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Ears"]){
            $ears[] = array_keys($data[$j]);
        } elseif(array_keys($data[$j]) == ["Jacket"]){
            $jacket[] = array_keys($data[$j]); 
        } elseif(array_keys($data[$j]) == ["Rarity"]){
            $rarity[] = array_keys($data[$j]); 
        } elseif(array_keys($data[$j]) == ["Background"]){
            $background[] = array_keys($data[$j]); 
        } elseif(array_keys($data[$j]) == ["Accessories"]){
            $accessories[] = array_keys($data[$j]); 
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
        } elseif(array_keys($data[$k]) == ["Hat"]){
            if(count($hat) == 1){
                $queryHat .= " AND (a.Attributes->'$.Hat' = '".$data[$k]['Hat']. "')";
            } elseif(count($hat) >= 2){
                $queryHat .= " AND (a.Attributes->'$.Hat' = '".$data[$k]['Hat']. "') OR";
            }
            $sentence = $queryHat;
            $search = ") OR AND (a.Attributes->'$.Hat'";
            $replace = " OR a.Attributes->'$.Hat'";
            $queryHat = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Mouth"]){
            if(count($mouth) == 1){
                $queryMouth .= " AND (a.Attributes->'$.Mouth' = '".$data[$k]['Mouth']. "')";
            } elseif(count($mouth) >= 2){
                $queryMouth .= " AND (a.Attributes->'$.Mouth' = '".$data[$k]['Mouth']. "') OR";
            }
            $sentence = $queryMouth;
            $search = ") OR AND (a.Attributes->'$.Mouth'";
            $replace = " OR a.Attributes->'$.Mouth'";
            $queryMouth = str_replace($search, $replace, $sentence);
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
        } elseif(array_keys($data[$k]) == ["Ears"]){
            if(count($ears) == 1){
                $queryEars .= " AND (a.Attributes->'$.Ears' = '".$data[$k]['Ears']. "')";
            } elseif(count($ears) >= 2){
                $queryEars .= " AND (a.Attributes->'$.Ears' = '".$data[$k]['Ears']. "') OR";
            }
            $sentence = $queryEars;
            $search = ") OR AND (a.Attributes->'$.Ears'";
            $replace = " OR a.Attributes->'$.Ears'";
            $queryEars = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Jacket"]){
            if(count($jacket) == 1){
                $queryJacket .= " AND (a.Attributes->'$.Jacket' = '".$data[$k]['Jacket']. "')";
            } elseif(count($jacket) >= 2){
                $queryJacket .= " AND (a.Attributes->'$.Jacket' = '".$data[$k]['Jacket']. "') OR";
            }
            $sentence = $queryJacket;
            $search = ") OR AND (a.Attributes->'$.Jacket'";
            $replace = " OR a.Attributes->'$.Jacket'";
            $queryJacket = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Rarity"]){
            if(count($rarity) == 1){
                $queryRarity .= " AND (a.Attributes->'$.Rarity' = '".$data[$k]['Rarity']. "')";
            } elseif(count($rarity) >= 2){
                $queryRarity .= " AND (a.Attributes->'$.Rarity' = '".$data[$k]['Rarity']. "') OR";
            }
            $sentence = $queryRarity;
            $search = ") OR AND (a.Attributes->'$.Rarity'";
            $replace = " OR a.Attributes->'$.Rarity'";
            $queryRarity = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Background"]){
            if(count($background) == 1){
                $queryBackground .= " AND (a.Attributes->'$.Background' = '".$data[$k]['Background']. "')";
            } elseif(count($background) >= 2){
                $queryBackground .= " AND (a.Attributes->'$.Background' = '".$data[$k]['Background']. "') OR";
            }
            $sentence = $queryBackground;
            $search = ") OR AND (a.Attributes->'$.Background'";
            $replace = " OR a.Attributes->'$.Background'";
            $queryBackground = str_replace($search, $replace, $sentence);
        } elseif(array_keys($data[$k]) == ["Accessories"]){
            if(count($accessories) == 1){
                $queryAccessories .= " AND (a.Attributes->'$.Accessories' = '".$data[$k]['Accessories']. "')";
            } elseif(count($accessories) >= 2){
                $queryAccessories .= " AND (a.Attributes->'$.Accessories' = '".$data[$k]['Accessories']. "') OR";
            }
            $sentence = $queryAccessories;
            $search = ") OR AND (a.Attributes->'$.Accessories'";
            $replace = " OR a.Attributes->'$.Accessories'";
            $queryAccessories = str_replace($search, $replace, $sentence);
        }
    }

    $query .= $queryHat;
    $query .= $queryEyes;
    $query .= $queryMouth;
    $query .= $queryGlasses;
    $query .= $queryClothing;
    $query .= $queryEars;
    $query .= $queryJacket;
    $query .= $queryRarity;
    $query .= $queryBackground;
    $query .= $queryAccessories;

    $query .= " AND a.Minted = 0 ORDER BY a.TicketNumber $order LIMIT $prdouctsPerPage OFFSET $ofset";

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

    $sentence4 = $query;
    $search4 = "WHERE";
    $replace4 = "WHERE a.NFTid BETWEEN $start AND $end AND ";
    $query = str_replace($search4, $replace4, $sentence4);

    $sql = $dbConn->prepare($query);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    $sentence = $query;
    $search = "SELECT *";
    $replace = "SELECT count(*) AS results";
    $new_sentence = str_replace($search, $replace, $sentence);

    $new_sentence2 = "";
    if($page == 1) {
        $new_sentence2 = substr($new_sentence, 0, -19);
    } else {

        $new_sentence2 = substr($new_sentence, 0, -21);
    }


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
    $back['back'] = 'http://localhost/apirest/filterNFTs.php?page=' . $page - 1 . '&order=' . $order;
    $next['next'] = 'http://localhost/apirest/filterNFTs.php?page=' . $page + 1 . '&order=' . $order;

    if($page <= 1) {
        $back['back'] = 'http://localhost/apirest/filterNFTs.php?page=1&order=asc';
    }

    if($pages['pages'] == 0) {
        $pages['pages'] = 1;
    }

    if($page >= $pages['pages'] ) {
        $next['next'] = 'http://localhost/apirest/filterNFTs.php?page=' . $pages['pages'] . '&order=' . $order;
    }

    header("HTTP/1.1 200 OK");
    $array = array($pages, $total, $back, $next, $sql->fetchAll(PDO::FETCH_ASSOC));
    echo json_encode($array, JSON_UNESCAPED_SLASHES);
}
