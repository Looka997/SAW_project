<?php
require_once('../common/db_ops.php');
require_once('../common/utilities.php');
require_once('../common/error_codes.php');
require_once("../../db_connections/connections.php");
$link = my_oo_connect(HOST, DB_USER, DB_PASSWORD, DATABASE);
session_start();

const CART_PARAM = "cart";
const PROD_ID_PARAM = "prod_id";

function exitUsage() {
    echo "Usage\n".
        "Requires: Logged User\n".
        "Method: POST or GET\n".
        "POST Payload: " . CART_PARAM . "=[1,2,3,4,..]\n".
        "cart value must be JSON decodable\n\n".
        "GET Payload: ?" . PROD_ID_PARAM . "=<number>\n\n".
        "Returns:\n".
        "- 200 on successful POST\n".
        "- JSON `{\"confirmed\": <bool>}` on successful GET\n".
        "- HTTP code 500 on any failure\n";
    exit(200);
}

if (!isset($_POST[CART_PARAM]) && !isset($_GET[PROD_ID_PARAM])) {
    exitUsage();
}

if (!isset($_SESSION['email']) || !isset($_SESSION['userid'])) {
    exitUsage();
}

/**
 * GET request handler
 * Checks if the current user bought the given product
 * 
 * @param mysqli $link DB connection
 * @param int $prod_id User ID to check
 */
function handleGet(mysqli $link, int $prod_id) {
    $answer = array("confirmed" => false);

    $query = "SELECT * FROM orders WHERE user_id = ? AND prod_id = ?";
    $stmt = $link->prepare($query);
    if (!$stmt->bind_param("ii", $_SESSION['userid'], $prod_id)) {
        http_response_code(500);
        exit(500);
    }

    if (!$stmt->execute()) {
        http_response_code(500);
        exit(500);
    }

    if (!$stmt->store_result()) {
        http_response_code(500);
        exit(500);
    }

    if ($stmt->num_rows() > 0) {
        $answer["confirmed"] = true;
    }

    if (!($response = json_encode($answer))) {
        http_response_code(500);
        exit(500);
    }
    
    header("Content-Type: application/json");
    echo $response;
    return;
}

/**
 * POST request handler
 * Adds all the element in the $cart array to the orders table
 * 
 * @param mysqli $link DB connection
 * @param array $cart Cart array containing only cart IDs
 */
function handlePost(mysqli $link, array $cart) {
    $query = "INSERT INTO orders (user_id, prod_id) VALUES (?, ?)";
    $stmt = $link->prepare($query);
    $stmt->bind_param("ii", $_SESSION['userid'], $prod_id);

    $link->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
    foreach ($cart as $product) {
        $prod_id = $product;

        if (!$stmt->execute()) {
            $link->rollback();
            http_response_code(500);
            exit(500);
        }
    }
    $link->commit();

    return;
}

if (isset($_POST[CART_PARAM])) {
    $decoded_cart = json_decode($_POST[CART_PARAM]);
    if (is_null($decoded_cart) || !is_array($decoded_cart)) {
        http_response_code(500);
        exit(500);
    }
    handlePost($link, $decoded_cart);
    exit(200);
}
if (isset($_GET[PROD_ID_PARAM])) {
    handleGet($link, $_GET[PROD_ID_PARAM]);
    exit(200);
}

http_response_code(500);
exit(500);