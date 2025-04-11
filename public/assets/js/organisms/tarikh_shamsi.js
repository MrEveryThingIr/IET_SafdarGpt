$(document).ready(function () {
    // Get the current date in Farsi (Jalali) format
    const currentDate = moment().format('jYYYY/jMM/jDD'); // Format: 1403/11/30

    // Set the date value in the input field
    $('#date').val(currentDate);
  });