document.getElementById('addImageButton').addEventListener('click', () => {
    const form = document.getElementById('jquery-val-form');
console.log('ok');

    // Create a wrapper for each image input
    const wrapper = document.createElement('div');
    wrapper.className = 'image-input-wrapper';
    wrapper.style.marginBottom = '10px';

    // Create an input field for image upload
    const imageInput = document.createElement('input');
    imageInput.type = 'file';
    imageInput.name = 'images[]'; // Use an array format to upload multiple images
    imageInput.accept = 'image/*'; // Restrict to image files

    // Add an event listener to preview selected images
    imageInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = () => {
                displayImagePreview(reader.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Add a remove button
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.textContent = 'Remove';
    removeButton.style.marginLeft = '10px';

    removeButton.addEventListener('click', () => {
        wrapper.remove();
    });

    // Append the input and remove button to the wrapper
    wrapper.appendChild(imageInput);
    wrapper.appendChild(removeButton);

    // Append the wrapper to the form
    form.insertBefore(wrapper, form.lastChild);
});

// Function to display image preview
function displayImagePreview(imageSrc) {
    const previewContainer = document.getElementById('imagePreview');
    const img = document.createElement('img');
    img.src = imageSrc;
    img.alt = 'Preview';
    img.style.maxWidth = '100px';
    img.style.marginRight = '10px';
    previewContainer.appendChild(img);
}
