<?php
ob_start();
session_start();
$con = mysqli_connect('localhost', 'root', '', 'shop');
// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
sleep(1);
function getProductDescrByName($name)
{
    $query = "
          SELECT * 
          FROM   product 
          WHERE  productName = '$name'
          ORDER BY productArriveDate
    ";
    return $query;
}

if (isset($_POST["number"])) {

    $number = $_POST["number"];
    $name = $_POST["name"];
    $newNumber = $_POST["newNumber"];
    $price = $_POST["price"];

    date_default_timezone_set('Kazakhstan/Astana');
    $date = date('Y-m-d');
    $query = "
          INSERT INTO dailynumber(productName, productNumber, productPrice, productDate) 
          VALUES ('$name','$number', '$price', '$date')
    ";

    $updatedNumber = $newNumber - $number;
    $take = "UPDATE product 
              SET productNumber = '$updatedNumber' 
              WHERE productName = '$name' ";

    $show = mysqli_query($con, $query);

    $minus = mysqli_query($con, $take);
}

if (isset($_POST['productsList'])) {

    $delete = "DELETE FROM product 
                WHERE productNumber <= 0";
    $gg = mysqli_query($con, $delete);

    $query = "SELECT * FROM product ORDER BY productCategory";

    $show = mysqli_query($con, $query);
    $i = 0;
    //print_r(mysql_num_rows($show));
    while ($i < mysqli_num_rows($show)) {

        $row = mysqli_fetch_array($show);
        $name = $row['productName'];
        $name = htmlspecialchars($row['productName'], ENT_QUOTES);

        $category = $row['productCategory'];
        $category = htmlspecialchars($row['productCategory'], ENT_QUOTES);

        $number = $row['productNumber'];
        $number = htmlspecialchars($row['productNumber'], ENT_QUOTES);

        $price = $row['productPrice'];
        $price = htmlspecialchars($row['productPrice'], ENT_QUOTES);

        $date = $row['productArriveDate'];
        $date = htmlspecialchars($row['productArriveDate'], ENT_QUOTES);
        $date = date('d.m.Y', strtotime($date));
        echo "<tr><td>" . $category . "</td>";
        echo "<td>" . $name . "</td>";
        echo "<td id='currentNumberStat'>" . $number . "</td>";
        echo "<td>" . $price . "</td>";
        echo "<td>" . $date . "</td>";
        echo "<td><button onclick='showSpecialPlateModal(\"$name\",\"$number\");' id='btnSell' class='btnSell'>Продать</button></td></tr>";
        $i++;
    }
    exit();
}

if (isset($_POST['sortValue'])) {

    $value = $_POST["sortValue"];
    $query = "SELECT * FROM product WHERE productCategory = '$value'";

    $show = mysqli_query($con, $query);
    $i = 0;
    //print_r(mysql_num_rows($show));
    while ($i < mysqli_num_rows($show)) {

        $row = mysqli_fetch_array($show);
        $name = $row['productName'];
        $name = htmlspecialchars($row['productName'], ENT_QUOTES);

        $category = $row['productCategory'];
        $category = htmlspecialchars($row['productCategory'], ENT_QUOTES);

        $number = $row['productNumber'];
        $number = htmlspecialchars($row['productNumber'], ENT_QUOTES);

        $price = $row['productPrice'];
        $price = htmlspecialchars($row['productPrice'], ENT_QUOTES);

        $date = $row['productArriveDate'];
        $date = htmlspecialchars($row['productArriveDate'], ENT_QUOTES);
        $date = date('d.m.Y', strtotime($date));
        echo "<tr><td>" . $category . "</td>";
        echo "<td>" . $name . "</td>";
        echo "<td id='currentNumberStat'>" . $number . "</td>";
        echo "<td>" . $price . "</td>";
        echo "<td>" . $date . "</td>";
        echo "<td><button onclick='showSpecialPlateModal(\"$name\",\"$number\");' id='btnSell' class='btnSell'>Продать</button></td></tr>";
        $i++;
    }
    exit();
}

if (isset($_POST['startDate'])) {

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $query = "SELECT * FROM product WHERE productArriveDate BETWEEN '$startDate' AND '$endDate' ORDER BY productArriveDate";

    $show = mysqli_query($con, $query);
    $i = 0;
    while ($i < mysqli_num_rows($show)) {
        $row = mysqli_fetch_array($show);
        $name = $row['productName'];
        $name = htmlspecialchars($row['productName'], ENT_QUOTES);

        $category = $row['productCategory'];
        $category = htmlspecialchars($row['productCategory'], ENT_QUOTES);

        $number = $row['productNumber'];
        $number = htmlspecialchars($row['productNumber'], ENT_QUOTES);

        $price = $row['productPrice'];
        $price = htmlspecialchars($row['productPrice'], ENT_QUOTES);

        $date = $row['productArriveDate'];
        $date = htmlspecialchars($row['productArriveDate'], ENT_QUOTES);
        $date = date('d.m.Y', strtotime($date));
        echo "<tr><td>" . $category . "</td>";
        echo "<td>" . $name . "</td>";
        echo "<td>" . $number . "</td>";
        echo "<td>" . $price . "</td>";
        echo "<td>" . $date . "</td>";
        echo "<td><button onclick='showSpecialPlateModal(\"$name\",\"$number\");' id='btnSell' class='btnSell'>Продать</button></td></tr>";
        $i++;
    }
    exit();
}


?>


    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Welcome - <?php echo $userRow['email']; ?></title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="style.css" type="text/css"/>
    </head>
    <body>


    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <h3>Магазин</h3>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul style="padding-left: 30px;" class="nav navbar-nav">
                    <li><a href="home.php">Список товаров</a></li>
                    <li><a href="add_product.php">Добавить продукт</a></li>
                    <li><a href="daily_products.php">Проданные продукты</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">
                            <span class="glyphicon glyphicon-user"></span>&nbsp;Hi <?php echo $userRow['login']; ?>
                            &nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign
                                    Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br>
    <div id="wrapper">

        <br/><br/>

        <form id="submitDates" method="post" onsubmit="return false;" style="text-align: center;">
            <label for="startDate">С</label>
            <input type="date" id="startDate" required/>

            <label for="endDate">По</label>
            <input type="date" id="endDate" required/>
            <br>
            <button type="submit">Сортировать по дате</button>
        </form>

        <br>
        <br>

        <div id="productsTable">
            <h2>Подождите...</h2>
        </div>

        <!-- BOOTSTRAP MODAL FOR SPECIAL PLATES -->
        <div class="modal fade" id="modal_special" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Товар</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена
                        </button>
                        <button type="button" name="addDailyStat" class="btn btn-primary accept">
                            Принять
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="home.js"></script>

    </body>
    </html>
<?php ob_end_flush(); ?>