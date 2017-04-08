$(document).ready(function () {

    $(document).ready(function showProductsList() {
        $.ajax({
            type: "POST",
            url: "home.php",
            data: {productsList: 'list'},
            dataType: "text",
            success: function (data) {
                $("#productsTable").empty();
                $('#productsTable').append(
                    '<table style="width:100%;" id="tableIDStat" cellspacing="5" border="1"><caption>Таблица товаров</caption><tr>' +
                    '<th>Категория товара' +
                    '<br><select id="sort" onchange="sortList(this);"><option value="">Отсортировать по категории</option>' +
                    '<option value="Напитки">Напитки</option>' +
                    '<option value="Фрукты">Фрукты</option>' +
                    '<option value="Овощи">Овощи</option>' +
                    '</select>' +
                    '</th>' +
                    '<th>Название товара</th>' +
                    '<th>Количество в магазине</th>' +
                    '<th>Цена за 1шт/кг</th>' +
                    '<th>Дата поступления</th>' +
                    '<th></th>' +
                    '</tr>' +
                    '<tr>' + data + '</tr></table>'
                )
                console.log(data)
            }
        });
        $("#productsList").click(function () {
            showProductsList();
        });
    });

    $("#submitDates").submit(function () {
        var startDate = document.getElementById('startDate');
        var endDate = document.getElementById('endDate');
        console.log(startDate.value);
        $.ajax({
            type: "POST",
            url: "home.php",
            data: {startDate: startDate.value, endDate: endDate.value},
            dataType: "text",
            success: function (data) {
                $("#productsTable").empty();
                $('#productsTable').append(
                    '<table style="width:100%;" id="tableIDStat" cellspacing="5" border="1"><caption>Таблица товаров</caption><tr>' +
                    '<th>Категория</th>' +
                    '<th>Название</th>' +
                    '<th>Количество </th>' +
                    '<th>Цена за 1 шт/кг </th>' +
                    '<th>Дата поступления </th>' +
                    '<th></th>' +
                    '</tr>' +
                    '<tr>' + data + '</tr></table>'
                )
            }
        });
    });



    // When the modal "Accept" button is pressed
    $('.accept').on('click', function () {
        var modal_element = $('#modal_special');
        var number = document.getElementById('input_number');
        var price = document.getElementById('input_price');
        console.log(number);
        var storeNumber = $("#currentNumber").text();
        var name = $("#productName").text();
        console.log("NAME " + name);
        if (parseInt(number.value) > parseInt(storeNumber)) {
            console.log("FULL")
            alert("Вы не можете продать больше чем у вас есть")
        } else if (number.value == "" || price.value == "") {
            alert("Заполните все данные по продаже");
        } else if (number.value < 1 || price.value <1)  {
            alert("Цена и количество товара должны быть больше 0");
        } else {

            var code = modal_element.find("span.code").text();

            function sellPriduct() {
                $.ajax({
                    type: "POST",
                    url: "home.php",
                    data: {number: number.value, name: name, newNumber: parseInt(storeNumber), price: price.value},
                    dataType: "text",
                    success: function (data) {
                        console.log(number.value, name, parseInt(storeNumber));
                    }
                });
            }

            sellPriduct();
            location.reload();
            alert("Товар добавлен в таблицу проданных продуктов");
            $('#modal_special').modal('hide').end();

        }
    });
});

function sortList(text) {
    $.ajax({
        type: "POST",
        url: "home.php",
        data: {sortValue: text.value},
        dataType: "text",
        success: function (data) {
            $("#productsTable").empty();
            $('#productsTable').append(
                '<table style="width:100%;" id="tableIDStat" cellspacing="5" border="1"><caption>Таблица товаров</caption><tr>' +
                '<th>Категория товара' +
                '<br><select id="sort" onchange="sortList(this);"><option value="">Отсортировать по категории</option>' +
                '<option value="Напитки">Напитки</option>' +
                '<option value="Фрукты">Фрукты</option>' +
                '<option value="Овощи">Овощи</option>' +
                '</select>' +
                '</th>' +
                '<th>Название товара</th>' +
                '<th>Количество в магазине</th>' +
                '<th>Цена за 1шт/кг</th>' +
                '<th>Дата поступления</th>' +
                '<th></th>' +
                '</tr>' +
                '<tr>' + data + '</tr></table>'
            )
            console.log(data)
        }
    });
}
function showSpecialPlateModal(name, number) {
    $('#modal_special').find('.modal-body')
        .html('<h2 id="productName">' + name + '</h2>' +
            '<h4>Доступное количество товара(шт/кг): </h4><h2 id="currentNumber">' + number + '</h2>' +
            '<div id="showPHP"></div><br>' +
            '<label for="input_number">Количество</label><br><input type="number" min="1" id="input_number" placeholder="Количество на продажу" required /><br><br>' +
            '<label for="input_price">Цена</label><br><input type="number" min="1" id="input_price" placeholder="Цена продажи за 1шт." required />' +
            '' +
            '')
        .end().modal('show');
}

