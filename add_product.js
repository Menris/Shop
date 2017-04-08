$(document).ready(function () {

    $(document).ready(function showAddedProducts() {
        $.ajax({
            type: "POST",
            url: "add_product.php",
            data: {addProduct: 's'},
            dataType: "text",
            success: function (data) {
                $("#addProductsList").empty();
                $('#addProductsList').append(
                    '<caption>Таблица приходов</caption><tr>' +
                    '<th>Название</th>' +
                    '<th>Категория</th>' +
                    '<th>Количество </th>' +
                    '<th>Цена за 1 шт/кг </th>' +
                    '<th>Дата поступления </th>' +
                    '</tr>' +
                    '<tr>' + data + '</tr>'
                )
            }
        });
    });

    $("#submitDates").submit(function () {
        var startDate = document.getElementById('startDate');
        var endDate = document.getElementById('endDate');
        console.log(startDate.value);
        $.ajax({
            type: "POST",
            url: "add_product.php",
            data: {startDate: startDate.value, endDate: endDate.value},
            dataType: "text",
            success: function (data) {
                $("#addProductsList").empty();
                $('#addProductsList').append(
                    '<caption>Таблица приходов</caption><tr>' +
                    '<th>Название</th>' +
                    '<th>Категория</th>' +
                    '<th>Количество </th>' +
                    '<th>Цена за 1 шт/кг </th>' +
                    '<th>Дата поступления </th>' +
                    '</tr>' +
                    '<tr>' + data + '</tr>'
                )
            }
        });
    });
});
