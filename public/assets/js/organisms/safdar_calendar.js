
$(document).ready(function () {
    var modal = $("#optionsModal");

    // Open modal on clicking any .trigger cell
    $(document).on("click", ".trigger", function () {
        var cellOffset = $(this).offset();
        var cellWidth = $(this).outerWidth();
        var cellHeight = $(this).outerHeight();

        // Position the modal beside the clicked cell
        modal.css({
            top: cellOffset.top + (cellHeight / 2) - (modal.outerHeight() / 2),
            left: cellOffset.left + cellWidth + 10
        }).fadeIn(200);
    });

    // Close modal when clicking the close button
    $("#closeModal").click(function () {
        modal.fadeOut(200);
    });

    // Close modal when clicking outside
    $(document).click(function (event) {
        if (!$(event.target).closest("#optionsModal, .trigger").length) {
            modal.fadeOut(200);
        }
    });
});


