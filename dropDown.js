$(document).ready(function () {
    // When a top-level menu item is hovered, decide if its
    // coorespnding submenu should be visible or hidden

    $( "#dailyStatistic" ).click(function() {
        function showRoom() {

            $.ajax({
                type: "POST",
                url: "home.php",
                data: {addDailyStat: 'stat'},
                dataType: "text",
                success: function (data) {
                    $( "#divDailyStatistic" ).empty();
                    $('#divDailyStatistic').append('<table id="tableIDStat" cellspacing="5" border="1">' +
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
        }

        showRoom()
    });

    $(".drop_down_scroll_container span").hover(
        // hover on
        function () {
            // Remove the "highlighted class from all other options
            $(this).parent().find("span").removeClass("highlighted").removeClass("selected");
            $(this).addClass("highlighted").addClass("selected");

            // Get the index of the hovered span
            var index = $(this).index();

            // Use the hovered index to reveal the
            // dropdown-subcategory of the same index
            var subcategorydiv = $(this).parent().parent().find(".dropdown-subcategory").eq(index);
            hideallSubmenusExceptMenuAtIndex($(this).parent().parent(), index);
            subcategorydiv.slideDown();
        },

        // hover off
        function () {
            if (!$(this).hasClass("highlighted")) {
                var index = $(this).index();
                var subcategorydiv = $(this).parent().parent().find(".dropdown-subcategory").eq(index);
                subcategorydiv.slideUp();
            }
        });


    // Hide all submenu items except for the submenu item at _index
    // This will hide any of the previously opened submenu items
    function hideallSubmenusExceptMenuAtIndex(formElement, _index) {
        formElement.find(".dropdown-subcategory").each(
            function (index) {
                if (_index != index) {
                    $(this).hide();
                }
            }
        );
    }




    // When a sub-menu option is clicked
    $(".dropdown-subcategory span").click(function () {
        $(".dropdown-subcategory span").removeClass("selected");
        $(".clickedOption").text($(this).text());
        $(this).addClass("selected");
        $(this).parent().parent().find(".selectHeader").text($(this).text());
        //closeDropDown($(this).parent().parent());
        showSpecialPlateModal($(this).text());
    });

    // Close the dropdowns contained in divToSearch
    function closeDropDown(divToSearch) {
        divToSearch.find(".drop_down_scroll_container").fadeOut();
        divToSearch.find(".dropdown-subcategory").fadeOut();
    };

    // Populate and Launch the bootstrap Modal Dialog Specialty Plates
    function showSpecialPlateModal(name) {
        $('#modal_special').find('.modal-body')
            .html('<h2 id="productName">' + name + '</h2>' +
                '<div id="showPHP"></div><br>' +
                '<h2 id="modalWaitText">Подождите...</h2>' +
                '<input type="number" min="0" style="visibility: hidden;" id="input_number" placeholder="Количество на продажу" required />' +
                '<input type="number" min="0" style="visibility: hidden;" id="input_price" placeholder="Цена продажи за 1шт." required />' +
                '' +
                '')
            .end().modal('show');

        function showRoom() {
            $( "#showPHP" ).empty();
            $.ajax({
                type: "POST",
                url: "home.php",
                data: {action: name},
                dataType: "text",
                success: function (data) {
                    $('#showPHP').append('<table style="visibility: hidden;" id="tableID" cellspacing="5" border="1">' +
                        '<tr>' +
                        '<th>Количество </th>' +
                        '<th>Цена за 1шт. </th>' +
                        '<th>Дата поступления </th>' +
                        '</tr>' +
                        '<tr>' + data + '</tr>' +
                        '</table>'
                    )
                    console.log(data)
                }
            });
        }

        showRoom()
        setTimeout(function () {
            checkFunction();
        }, 3000);
        function checkFunction() {
            var check = $("#currentNumber").text();
            var inputNumber = document.getElementById('input_number');
            var inputPrice = document.getElementById('input_price');
            var tableID = document.getElementById('tableID');
            var modalWaitText = document.getElementById('modalWaitText');
            if (check.length == 0) {
                var text = "Товара нет в магазине";
                $('#showPHP').append('<h2>'+ text + '</h2>')
                modalWaitText.style.display = 'none';
                inputNumber.style.display = 'none';
                inputPrice.style.display = 'none';
                tableID.style.display = 'none';
                console.log(check)
            } else {
                console.log(check)
                modalWaitText.style.display = 'none';
                inputNumber.style.visibility = 'visible';
                inputPrice.style.visibility = 'visible';
                tableID.style.visibility = 'visible';
            }
        }

    }

    // When the modal "Accept" button is pressed
    $('.accept').on('click', function () {
        var modal_element = $('#modal_special');
        var number = document.getElementById('input_number');
        var price = document.getElementById('input_price');
        console.log(number);
        var storeNumber = $("#currentNumber").text();
        console.log(storeNumber);
        var name = $("#productName").text();
        if (parseInt(number.value) > parseInt(storeNumber)) {
            console.log("FULL")
            alert("Вы не можете продать больше чем у вас есть")
        } else if (number.value == "" || price.value == "") {
            alert("Заполните все данные по продаже");
        } else {

            var code = modal_element.find("span.code").text();

            function sellPriduct() {
                $.ajax({
                    type: "POST",
                    url: "home.php",
                    data: {number: number.value, name: name, newNumber: parseInt(storeNumber), price: price.value},
                    dataType: "text",
                    success: function (data) {
                        console.log(data)
                    }
                });
            }

            sellPriduct()

            $('#modal_special').modal('hide').end();
        }
    });

});
/**
 * Created by menri on 04.04.2017.
 */
