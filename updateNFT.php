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

if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $id = $_GET['id'];
    $body = json_decode(file_get_contents("php://input"), true);
    $data = $body;
    $OwnerAddress = filter_var($data['OwnerAddress'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $TxnHash = filter_var($data['TxnHash'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $TimeStampMinted = filter_var($data['TimeStampMinted'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "UPDATE lazynfts SET Minted = 1, OwnerAddress=" . "'" . $OwnerAddress . "', TxnHash=" . "'" .$TxnHash . "', TimeStampMinted=" . "'" . $TimeStampMinted . "' WHERE NFTid=$id AND Minted = 0";
    
    $sql = $dbConn->prepare($query);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);

    if($sql->rowCount() == 1) {
        header("HTTP/1.1 200 OK");
        $msg = "Field updated";
        $array = array($msg);
        echo json_encode($array, JSON_UNESCAPED_SLASHES);
    } else {
        header("HTTP/1.1 400 OK");
        $msg = "Field don´t updated or not exists";
        $array = array($msg);
        echo json_encode($array, JSON_UNESCAPED_SLASHES);
    }
}