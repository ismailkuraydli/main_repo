
<?php
require_once "MySQLWrap.php";
require_once "Config.php";

/**
 * Check for errors in the databse connection
 * Returns to hompage with error details
 * @param MySQLWrap $mysqliObject
 */
function errorHandling ($mysqliObject) 
{
    if ($mysqliObject->error()) {
        $_SESSION['error'] = $mysqliObject->error();
    } else {
        return FALSE;
    }
}
/**
 * Returns to homepage
 */
function backToWebsite() 
{
    header(Config::HOME_PAGE);
}
/**
 * function to check if $_POST isset and is not empty
 * @param array $_POST[]
 * @return bool
 */
function checkPost($postArray) {
    if (isset($postArray) && $postArray!= NULL) {
        return TRUE;
    } else {
        return FAlSE;
    }
}
/**
 * Main executable opens connection with SQL server and does necesary bussiness logic
 */
$mysqliWrap = new MySQLWrap();
$mysqliWrap->connectToDB(Config::DB_CONNECT_ARRAY);
errorHandling($mysqliWrap);
session_start();
if(checkPost($_POST['film_title'])) {
    
    $searchString = $_POST['film_title'];
    $filmList = $mysqliWrap->getAvailableFilms($searchString, "title");
    $_SESSION['film_array'] =  $filmList;
    
}
if(checkPost($_POST['film_description'])) {
    $searchString = $_POST['film_description'];
    $filmList = $mysqliWrap->getAvailableFilms($searchString, "description");
    $_SESSION['film_array'] =  $filmList;
}
if(checkPost($_POST['film_picked'])) {
    $filmPicked = $_POST['film_picked'];
    $inventoryAvai = $mysqliWrap->checkFilmIfAvailable((int)$filmPicked[0]);
    if($inventoryAvai == NULL) {
        $_SESSION['error']['number'] = 500;
        $_SESSION['error']['message'] = "This movie is no longer available";
    } else {
        $rentalId = $mysqliWrap->insertRentInfo($inventoryAvai);
        $paymentId = $mysqliWrap->insertPaymentInfo($rentalId);
        
        $_SESSION['success'] = TRUE;
    }
    errorHandling($mysqliWrap);
}
if(checkPost($_POST['customer_id'])) {
    $customerId = $_POST['customer_id'];
    $customerId = (int)$customerId;
    $_SESSION['rented_films'] = $mysqliWrap->showRentedFilms($customerId);
    $_SESSION['balance'] = $mysqliWrap->getBalance($customerId);
}
if(checkPost($_POST['film_to_return'])) {
    $filmId = (int)$_POST['film_to_return'][0];
    $paidAmount = (float)$_POST['paid_amount'];
    $mysqliWrap->returnFilm($filmId, $paidAmount);
    errorHandling($mysqliWrap);
}
errorHandling($mysqliWrap);
$mysqliWrap->close();
backToWebsite();
?>