<?php
ob_start();
session_start();
$con=mysqli_connect('localhost','root','','shop');
// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['btn-addProduct'])) {
    // prevent sql injections/ clear user invalid inputs

    $productCategory = trim($_POST['product_category']);

    $array = explode('-', $productCategory);
    echo "<script>console.log( 'Debug Objects: " . $array[0] . "' );</script>";
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

    if(mysqli_num_rows($check) > 0){

        echo "<script type='text/javascript'>alert(' Товар уже имеется в магазине ');</script>";
        header("Refresh:0");
    }else{

        // if there's no error, continue to login
        $query = "INSERT INTO product(productName, productCategory, productNumber, productPrice, productArriveDate) 
              VALUES('$productName', '$productCategory', '$productNumber', '$productPrice', '$productDate')";
        mysqli_query($con,"SET CHARSET cp1251");
        $res = mysqli_query($con,$query);
        $message = "Продукт добавлен!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        header("Refresh:0");
    }

}

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


function minusFromShop($name, $number)
{
    $take = "UPDATE product 
              SET productNumber = '$number' 
              WHERE productName = '$name' ";
    return $take;
}

if (isset($_POST["action"])) {
    $action = $_POST["action"];
    $query = getProductDescrByName($action);

    mysqli_query($con,"SET CHARSET cp1251");
    $show = mysqli_query($con,$query);

    if (!$show) { // add this check.
        die('Invalid query: ' . mysqli_error());
    } else {
        $i = 0;
        //print_r(mysql_num_rows($show));
        while ($i < mysqli_num_rows($show)) {

            $row = mysqli_fetch_array($show);
            $category = $row['productCategory'];
            $category = htmlspecialchars($row['productCategory'], ENT_QUOTES);

            $number = $row['productNumber'];
            $number = htmlspecialchars($row['productNumber'], ENT_QUOTES);

            $price = $row['productPrice'];
            $price = htmlspecialchars($row['productPrice'], ENT_QUOTES);

            $date = $row['productArriveDate'];
            $date = htmlspecialchars($row['productArriveDate'], ENT_QUOTES);

            print "<tr><td id='currentNumber'>" . $number . "</td>";
            print "<td>" . $price . "</td>";
            print "<td>" . $date . "</td></tr>";
            $i++;
        }
        exit();
    }
}

if (isset($_POST["number"])) {
    $number = $_POST["number"];
    $name = $_POST["name"];
    $newNumber = $_POST["newNumber"];
    $price = $_POST["price"];
    print_r($name, $number);
    $query = setDailySell($name, $number, $price);
    $newNumber = $newNumber - $number;;
    $take = minusFromShop($name, $newNumber);
    mysqli_query($con,"SET CHARSET cp1251");
    $show = mysqli_query($con,$query);
    mysqli_query($con,"SET CHARSET cp1251");
    $minus = mysqli_query($con,$take);
}

function setDailySell($name, $number, $price)
{
    date_default_timezone_set('Kazakhstan/Astana');
    $date = date('Y-m-d', time());
    $query = "
          INSERT INTO dailyNumber(productName, productNumber, productPrice, productDate) 
          VALUES ('$name','$number', '$price', '$date')
    ";
    return $query;
}

if (isset($_POST['addDailyStat'])) {
    $query = "SELECT * FROM dailyNumber";

    mysqli_query($con,"SET CHARSET cp1251");
    $show = mysqli_query($con,$query);
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

        print "<tr><td>" . $name . "</td>";
        print "<td id='currentNumberStat'>" . $number . "</td>";
        print "<td>" . $price . "</td>";
        print "<td>" . $date . "</td></tr>";
        $i++;
    }
    exit();
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
                        <a href="#tab_default_3" data-toggle="tab" id="dailyStatistic">
                            <h3> Товары за день </h3></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_default_1">

                        <br/><br/>

                        <!-- CUSTOM DROP DOWN EXAMPLE -->

                        <div id="dropdown" class="specialtyPlatesCategories">

                            <div class="selectHeader">Категории товаров</div>

                            <!-- THIS IS WHERE YOU WILL PUT YOUR TOP-LEVEL OPTIONS -->
                            <div class="drop_down_scroll_container">
                                <span>Напитки</span>
                                <span>Фрукты</span>
                                <span>Овощи</span>
                                <!--<span>Мясо</span>
                                <span>Молочные продукты</span>-->
                            </div>

                            <!-- THIS IS WHERE YOU WILL PUT YOUR SUB-LEVEL OPTIONS -->
                            <div class="dropdown-subcategory">
                                <span>Pepsi</span>
                                <span>Fanta</span>
                                <span>Cola</span>
                            </div>

                            <div style="padding-top: 20px;" id="Sports_subcategories" class="dropdown-subcategory">
                                <span>Яблоки</span>
                                <span>Бананы</span>
                                <span>Апельсины</span>
                            </div>

                            <div style="padding-top: 40px;" id="Colleges_subcategories" class="dropdown-subcategory">
                                <span>Картофель</span>
                                <span>Лук</span>
                                <span>Морковь</span>
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

                    <div class="tab-pane" id="tab_default_2">
                        <div class="form-style-3">

                            <div id="login-form">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                                      autocomplete="off">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="form-group">
                                                <div class="input-group">
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
                                                </div>
                                                <span class="text-danger"><?php echo $categoryError; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="product_number"
                                                           class="form-control"
                                                           placeholder="Количество товара" required/>
                                                </div>
                                                <span class="text-danger"><?php echo $numberError; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" min="0" name="product_price"
                                                           class="form-control"
                                                           placeholder="Цена товара за 1 шт/кг" required/>
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

                            <div id="divDailyStatistic">

                            </div>
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