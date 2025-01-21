$(document).on('click', '.dynamic-img', function(){
    // Get the src of the clicked image
    // const src = $(this).attr('src');
    var src = $(this).attr('data-src');
    console.log(src);
    
    // Set the src in the modal image
    $('#modalImage').attr('src', src);

    // Show the modal
    $('#imageModal').modal('show');
});