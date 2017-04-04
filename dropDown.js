$(document).ready(function () {

    /*// When the header for the custom drop-down is clicked
     $(".selectHeader").click(function() {

     // cache the actual dropdown scroll container
     var dropdown = $(this).parent().find(".drop_down_scroll_container");

     // Toggle the visibility on click
     if (dropdown.is(":visible")) {
     dropdown.slideUp();
     $(this).parent().find(".dropdown-subcategory").fadeOut();
     } else {
     dropdown.slideDown();
     }

     });*/


    // When a top-level menu item is hovered, decide if its
    // coorespnding submenu should be visible or hidden
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

    // When any menu item is hovered
    $("span").hover(
        function () {
            $(".hoveredOver").text($(this).text());
        },
        function () {
            $(".hoveredOver").text("");
        }
    );


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
            .html('<h2>' + name + '</h2><div id="showPHP"></div>')
            .end().modal('show');

        function showRoom() {
            $.ajax({
                type: "POST",
                url: "home.php",
                data: {action: name},
                dataType: "text",
                success: function (data) {
                    $('#showPHP').append('<h2>'+ data +'</h2>')
                }
            });
        }
        showRoom()
    }

    // When the modal "Accept" button is pressed
    $('.accept').on('click', function () {
        var modal_element = $('#modal_special');
        var name = modal_element.find("h2").text();
        var price = modal_element.find("span.price").text();
        var code = modal_element.find("span.code").text();
        $('#modal_special').modal('hide').end(alert(name + " was selected for a price of " + price));
    });

});
/**
 * Created by menri on 04.04.2017.
 */
