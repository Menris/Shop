<?php
/*
 * Главная страница
 *
 *
 *
 *
 * */


ob_start();
session_start();
require_once 'dbconnect.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// select loggedin users detail
//$res = mysql_query("SELECT * FROM reg WHERE id=" . $_SESSION['user']);
//$userRow = mysql_fetch_array($res);


if ( isset($_POST['btn-addProduct']) ) {

    // prevent sql injections/ clear user invalid inputs
    $productName = trim($_POST['product_name']);
    $productName = strip_tags($productName);
    $productName = htmlspecialchars($productName);

    $productCategory = trim($_POST['product_category']);
    $productCategory = strip_tags($productCategory);
    $productCategory = htmlspecialchars($productCategory);

    $productNumber = trim($_POST['product_number']);
    $productNumber = strip_tags($productNumber);
    $productNumber = htmlspecialchars($productNumber);

    $productPrice = trim($_POST['product_price']);
    $productPrice = strip_tags($productPrice);
    $productPrice = htmlspecialchars($productPrice);

    $productDate = trim($_POST['product_date']);
    $productDate = strip_tags($productDate);
    $productDate = htmlspecialchars($productDate);

    // if there's no error, continue to login
    $query = "INSERT INTO product(productName, productCategory, productNumber, productPrice, productArriveDate) VALUES('$productName', '$productCategory', '$productNumber', '$productPrice', '$productDate')";
    mysql_query("SET CHARSET cp1251");
    $res = mysql_query($query);
    $message = "Продукт добавлен!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("Refresh:0");

}



function getProductDescrByName($name) {


    $query = "
          SELECT * 
          FROM   product 
          WHERE  productName = '$name'
    ";



    return $query;
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];


    // todo query возвращает что-то даже если ничего нет
    $query = getProductDescrByName($action);



    mysql_query("SET CHARSET cp1251");
    $show = mysql_query($query);



    // echo "<script type='text/javascript'>console.log('$action');</script>";

    if (!$show) { // add this check.
        die('Invalid query: ' . mysql_error());
    } else {
        while ($row = mysql_fetch_array($show, MYSQL_ASSOC)) {

            $category = $row['productCategory'];
            $category = htmlspecialchars($row['productCategory'], ENT_QUOTES);

            $number = $row['productNumber'];
            $number = htmlspecialchars($row['productNumber'], ENT_QUOTES);

            $price = $row['productPrice'];
            $price = htmlspecialchars($row['productPrice'], ENT_QUOTES);

            $date = $row['productArriveDate'];
            $date = htmlspecialchars($row['productArriveDate'], ENT_QUOTES);

            print "<h2>". $number ."</h2>";
            print "<h2>". $category ."</h2>";
            print "<h2>". $price ."тг за шт.</h2>";
            print "<h2>". $date ."</h2>";
            exit();
        }
    }
}



?>


    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Welcome - <?php echo $userRow['login']; ?></title>
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

        <div class="tabbable-panel">
            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_default_1" data-toggle="tab">
                            <h3> Список товаров </h3></a>
                    </li>
                    <li>
                        <a href="#tab_default_2" data-toggle="tab">
                            <h3> Добавить товар </h3></a>
                    </li>
                    <li>
                        <a href="#tab_default_3" data-toggle="tab">
                            <h3> Товары за день </h3></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">

                        You are hovered over: <span class="hoveredOver"></span><br/>
                        You have clicked on option: <span class="clickedOption"></span>

                        <br/><br/>

                        <!-- CUSTOM DROP DOWN EXAMPLE -->

                        <div id="dropdown" class="specialtyPlatesCategories">

                            <div class="selectHeader">Категории продуктов</div>

                            <!-- THIS IS WHERE YOU WILL PUT YOUR TOP-LEVEL OPTIONS -->
                            <div class="drop_down_scroll_container">
                                <span>Напитки</span>
                                <span>Фрукты</span>
                                <span>Овощи</span>
                                <span>Мясо</span>
                                <span>Молочные продукты</span>
                            </div>

                            <!-- THIS IS WHERE YOU WILL PUT YOUR SUB-LEVEL OPTIONS -->
                            <div id="Environment_subcategories" class="dropdown-subcategory">
                                <span data-code="ENV01" data-image="" data-price="31.00">Pepsi</span>
                                <span data-code="ENV02" data-image="" data-price="32.00">Fanta</span>
                                <span data-code="ENV03" data-image="" data-price="33.00">Cola</span>
                            </div>

                            <div id="Sports_subcategories" class="dropdown-subcategory">
                                <span data-code="SPRT01" data-image="" data-price="34.00">Яблоки</span>
                                <span data-code="SPRT02" data-image="" data-price="35.00">Бананы</span>
                                <span data-code="SPRT03" data-image="" data-price="36.00">Апельсины</span>
                            </div>

                            <div id="Colleges_subcategories" class="dropdown-subcategory">
                                <span data-code="COLL01" data-image="" data-price="37.00">Картофель</span>
                                <span data-code="COLL02" data-image="" data-price="38.00">Лук</span>
                                <span data-code="COLL03" data-image="" data-price="39.00">Морковь</span>
                            </div>


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
                                        <h4 class="modal-title" id="myModalLabel">Specialty Plate</h4>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                                        </button>
                                        <button type="button" class="btn btn-primary accept">Accept</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="tab-pane" id="tab_default_2">
                        <div class="form-style-3">

                            <div id="login-form">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                      autocomplete="off">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="product_name" class="form-control"
                                                           placeholder="Название товара" required/>
                                                    <span class="text-danger"><?php echo $nameError; ?></span>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <!--<input type="text" name="product_category" class="form-control"
                                                           placeholder="Категория товара" required/>-->
                                                    <select name="product_category" required>
                                                        <option value="">Выберите категорию</option>
                                                        <option value="Фрукты">Фрукты</option>
                                                        <option value="Овощи">Овощи</option>
                                                        <option value="Напитки">Напитки</option>
                                                    </select>
                                                </div>
                                                <span class="text-danger"><?php echo $categoryError; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" name="product_number" class="form-control"
                                                           placeholder="Количество товара" required/>
                                                </div>
                                                <span class="text-danger"><?php echo $numberError; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" name="product_price" class="form-control"
                                                           placeholder="Цена товара за 1 шт." required/>
                                                </div>
                                                <span class="text-danger"><?php echo $priceError; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="date" name="product_date" class="form-control"
                                                           required/>
                                                </div>
                                                <span class="text-danger"><?php echo $dateError; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <hr/>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-primary"
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
                    <div class="tab-pane" id="tab_default_3">
                        <div class="form-style-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">


    </div>

    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="dropDown.js"></script>

    </body>
    </html>
<?php ob_end_flush(); ?>