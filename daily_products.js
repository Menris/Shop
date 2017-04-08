$(document).ready(function () {
    $(document).ready(function showDailyProducts() {
        $.ajax({
            type: "POST",
            url: "daily_products.php",
            data: {addDailyStat: 'stat'},
            dataType: "text",
            success: function (data) {
                $("#divDailyStatistic").empty();
                $('#divDailyStatistic').append('' +
                    '<br><table style="width:100%;" id="tableIDStat" cellspacing="5" border="1"><caption>Таблица проданных продуктов</caption>' +
                    '<tr>' +
                    '<th>Название</th>' +
                    '<th>Количество </th>' +
                    '<th>Цена за 1 шт/кг </th>' +
                    '<th>Дата продажи </th>' +
                    '</tr>' +
                    '<tr>' + data + '</tr>' +
                    '</table>'
                )
                console.log(data)
            }
        });

        $("#dailyStatistic").click(function () {
            showDailyProducts();
        });
    });

    $("#submitDates").submit(function () {
        var startDate = document.getElementById('startDate');
        var endDate = document.getElementById('endDate');
        $.ajax({
            type: "POST",
            url: "daily_products.php",
            data: {startDate: startDate.value, endDate: endDate.value},
            dataType: "text",
            success: function (data) {
                $("#divDailyStatistic").empty();
                $('#divDailyStatistic').append(
                    '<table style="width:100%;" id="tableIDStat" cellspacing="5" border="1"><caption>Таблица проданных продуктов</caption><tr>' +
                    '<th>Название</th>' +
                    '<th>Количество </th>' +
                    '<th>Цена за 1 шт/кг </th>' +
                    '<th>Дата поступления </th>' +
                    '</tr>' +
                    '<tr>' + data + '</tr></table>'
                )
            }
        });
    });
});
