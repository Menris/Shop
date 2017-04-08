<?php
ob_start();
session_start();
$con = mysqli_connect('localhost', 'root', '', 'shop');
// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['addDailyStat'])) {
    $query = "SELECT * FROM dailyNumber";

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

        $date = $row['productDate'];
        $date = htmlspecialchars($row['productDate'], ENT_QUOTES);
        $date = date('d.m.Y', strtotime($date));
        print "<tr><td>" . $name . "</td>";
        print "<td>" . $number . "</td>";
        print "<td>" . $price . "</td>";
        print "<td>" . $date . "</td></tr>";
        $i++;
    }
    exit();
}

if (isset($_POST['startDate'])) {

    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $query = "SELECT * FROM dailynumber WHERE productDate BETWEEN '$startDate' AND '$endDate'";

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

        $date = $row['productDate'];
        $date = htmlspecialchars($row['productDate'], ENT_QUOTES);
        $date = date('d.m.Y', strtotime($date));
        echo "<tr><td>" . $name . "</td>";
        echo "<td>" . $number . "</td>";
        echo "<td>" . $price . "</td>";
        echo "<td>" . $date . "</td></tr>";
        $i++;
    }
    exit();
}

?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
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
                    <li><a id="home" href="home.php">Список товаров</a></li>
                    <li><a id="addProduct" href="add_product.php">Добавить продукт</a></li>
                    <li><a id="dailyProduct" href="daily_products.php">Проданные продукты</a></li>
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
    <br>
    <div id="wrapper">
        <div class="tab-pane" id="tab_default_3">
            <div class="form-style-3">

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

                <div id="divDailyStatistic">
                    <h2>Подождите...</h2>
                </div>
            </div>
        </div>

    </div>
    <div class="container">
    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="daily_products.js"></script>


    </body>
    </html>
<?php ob_end_flush(); ?>