<?php
 /**
 * Function that displays results to the html page
 */
function htmlDisplay()
{
    session_start();
    $array = $_SESSION['film_array'];
    $count = 1;


    if (empty($array)) {
        echo "No search results";
    } else {
        echo '<form action="OrderProcess.php" method="post">';
        foreach($array as $value) {
            echo '<INPUT TYPE="radio" 
            NAME="film_picked[]" id="film_picked" VALUE="'
            . $value["film_id"] . '">' . $value["title"] . '<br />';
            if ($count == 10) {
                $_SESSION['film_array'] = array_splice($array, 10);
                break;
            }

            $count++;
        }

        echo '<input type="submit" value="Rent Now" name="film_rent_request"
                    style = "font-size:150%"/>
                    </form>';
        next10();
    }

    if (!empty($_SESSION['error'])) {
        $errorMessage = $_SESSION['error']['message'];
        alertHtml("Error {$errorMessage}, please try again later");
        $_SESSION['error'] = NULL;
        echo "<br/>";
    }

    if (!empty($_SESSION['success'])) {
        if ($_SESSION['success']) {
            alertHtml("Your movie will be delivered soon");
        } 
        $_SESSION['success'] = NULL;
    }
}
/**
 * function to display sessioned information about rented out films 
 */
function displayAlreadyRented() 
{
    session_start();
    $array = $_SESSION['rented_films'];
    if (empty($array)) {
        echo "No rented movies";
    } else {
        echo '<form action="OrderProcess.php" method="post">';
        foreach($array as $value) {
            echo '<INPUT TYPE="radio" 
            NAME="film_to_return[]" id="film_to_return" VALUE="'
            . $value["film_id"] . '">' . $value["title"] . '<br />';
        }
        echo 'Amount in dollars: <input type = "text" value= "" name = "paid_amount" />';    
        echo '<input type="submit" value="Return Film" name="film_return_request"
                    style = "font-size:150%"/>
                    </form>';
        echo "Balance: {$_SESSION['balance']}";
    }
    $_SESSION['rented_films'] = NULL;
}    
/**
 * Display custom alert on html
 * @param string $message to alert
 */

function alertHtml($message)
{
    echo "<div class=\"alert\">
            <span class=\"closebtn\" 
            onclick=\"this.parentElement.style.display='none';\">
            &times;
            </span>
            {$message}
            </div>";
}

/**
 * Submit button to refresh page and display the next 10 movies
 */

function next10()
{
    echo '<form action="" method="post">
        <input type="submit" value="Next Ten"
         name="next10" id= "next10" 
         style = "font-size:100%""/>
        </form>';
}

?>
<html>
<!-- Home page for rental website -->

<head>
    <title>Rental Page</title>
    <style>
        h1 {
            font-size: 300%;
            text-align: center;
        }
        h2 {
            font-size: 100%;
            text-align: left;
        }
        #next10 {
            width: 200 em;
            height: 2 em;
        }
    </style>
</head>
<header>
    <h1>Welcome DVDS R US rental page</h1>
</header>

<body>
    <h2>
      <form action="OrderProcess.php" method="post">
        Film Title: <input type = "text" value= "" name = "film_title" />
            <br>
            OR
            <br>
        Film description: <input type = "text" value= "" name = "film_description" />
            <br>
            <input type="submit" value="View Movies"name="film_search"/>
            <br>       
      </form>
      <?php htmlDisplay();?>
      <form action="OrderProcess.php" method="post">
        Customer Id: <input type = "text" value= "" name = "customer_id" />
            <input type="submit" value="Check Movies you have"name="film_rented"/>       
      </form>
      <?php displayAlreadyRented();?>
    </h2>
</body>

</html>