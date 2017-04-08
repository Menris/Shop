<?php
ob_start();
session_start();
$con = mysqli_connect('localhost', 'root', '', 'shop');
// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['btn-addProduct'])) {
    // prevent sql injections/ clear user invalid inputs

    $productCategory = trim($_POST['product_category']);

    $array = explode('-', $productCategory);
    $productCategory = $array[0];
    $productName = $array[1];
    $productCategory = strip_tags($productCategory);
    $productCategory = htmlspecialchars($productCategory);

    $productName = strip_tags($productName);
    $productName = htmlspecialchars($productName);

    print_r(explode('-', $productCategory));

    $productNumber = trim($_POST['product_number']);
    $productNumber = strip_tags($productNumber);
    $productNumber = htmlspecialchars($productNumber);

    $productPrice = trim($_POST['product_price']);
    $productPrice = strip_tags($productPrice);
    $productPrice = htmlspecialchars($productPrice);

    $productDate = trim($_POST['product_date']);
    $productDate = strip_tags($productDate);
    $productDate = htmlspecialchars($productDate);

    $check = mysqli_query($con, "SELECT * FROM product WHERE productName = '$productName' ");
    if (mysqli_num_rows($check) > 0) {
        echo "<script type='text/javascript'>alert(' Товар уже имеется в магазине ');</script>";
    } else {
        // if there's no error, continue to login
        $query = "INSERT INTO product(productName, productCategory, productNumber, productPrice, productArriveDate) 
              VALUES('$productName', '$productCategory', '$productNumber', '$productPrice', '$productDate')";

        $res = mysqli_query($con, $query);
        $message = "Продукт добавлен!";
        //echo "<script type='text/javascript'>callThis();</script>";

        echo "<script type='text/javascript'>alert('$message');</script>";
    }

}

if (isset($_POST['addProduct'])) {

    $query = "SELECT * FROM product ORDER BY productID DESC";

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
        echo "<tr><td>" . $name . "</td>";
        echo "<td>" . $category . "</td>";
        echo "<td>" . $number . "</td>";
        echo "<td>" . $price . "</td>";
        echo "<td>" . $date . "</td></tr>";
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
        echo "<tr><td>" . $name . "</td>";
        echo "<td>" . $category . "</td>";
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
        <meta http-equiv="Content-Type" content="text/html; charset=cp1251">
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

            <table border="1" style="width:100%;" id="addProductsList">

            </table>
            <hr>
            <hr>


            <div id="login-form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                      autocomplete="off">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="form-group">
                                <div class="input-group">
                                    <label>
                                        <select name="product_category" required>
                                            <option value="">Выберите товар</option>
                                            <optgroup label="Напитки">
                                                <option value="Напитки-Pepsi">Pepsi</option>
                                                <option value="Напитки-Cola">Cola</option>
                                                <option value="Напитки-Fanta">Fanta</option>
                                            </optgroup>
                                            <optgroup label="Фрукты">
                                                <option value="Фрукты-Яблоки">Яблоки</option>
                                                <option value="Фрукты-Груши">Груши</option>
                                            </optgroup>
                                            <optgroup label="Овощи">
                                                <option value="Овощи-Картофель">Картофель</option>
                                                <option value="Овощи-Лук">Лук</option>
                                            </optgroup>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" name="product_number"
                                           class="form-control"
                                           placeholder="Количество товара" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" name="product_price"
                                           class="form-control"
                                           placeholder="Цена товара за 1 шт/кг" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input id="addProductDate" type="date" name="product_date" class="form-control"
                                           required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <hr/>
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-block btn-primary"
                                        name="btn-addProduct">Добавить
                                    товар
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="dates.js"></script>
    <script src="add_product.js"></script>

    </body>
    </html>
<?php ob_end_flush(); ?>