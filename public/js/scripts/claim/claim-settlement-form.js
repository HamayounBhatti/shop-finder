function printElement(selector) {
    var element = $(selector); // Get the jQuery element
    if (element.length === 0) {
        console.error('No element found for the selector:', selector);
        return; // Exit the function if the element is not found
    }

    var elementHtml = element.html(); // Get the HTML content of the element
    var originalContents = $('body').html(); // Store the original page content

    $('body').html(elementHtml); // Replace the body content with the element's content
    window.print(); // Trigger the print dialog
    $('body').html(originalContents); // Restore the original content
    location.reload(); // Reload the page to restore scripts and events
}

// Attach click event to the print button
$('.print-button').on('click', function () {
    printElement('.form-container'); // Call the print function with the form's ID
})