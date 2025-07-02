<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urbansole-Defected Shoes Image Gallery</title>
	<link rel="shortcut icon" href="{{asset('images/icons/urbansole_icon.png')}}" type="image/png">
    <!-- Add Bootstrap for styling (Optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Gallery Overlay with White Opacity */
        .gallery-container {
            position: relative;
        }
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6); /* White with 60% opacity */
            z-index: 1; /* Ensures the overlay is above the background image but below the content */
        }
        /* Gallery Content */
        .gallery {
            position: relative;
            z-index: 2; /* Ensures images are above the overlay */
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .gallery-item {
            position: relative;
            width: calc(33% - 10px); /* 3 items per row with some margin */
            box-sizing: border-box;
        }
        .gallery-item h3 {
            margin-bottom: 10px;
        }
        .gallery-image {
            width: 100%; /* Makes the image fill the width of the container */
            height: auto;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Adds a subtle shadow to the images */
            transition: transform 0.3s ease; /* Adds a transition for hover effect */
        }
		 .image-gallery-heading {
            background-color: rgba(255, 255, 255, 0.7); /* White background with 70% opacity */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Adds shadow around the heading */
            display: flex; /* Makes the heading fit content */
			justify-content:center;
        }
        .gallery-image:hover {
            transform: scale(1.05); /* Slight zoom effect on hover */
        }
    </style>
</head>
<body style="background-image: url(https://www.urbansole.com.pk/cdn/shop/files/Water_Resistant_4_v2_1880x.jpg?v=1733924785); background-size: cover; background-repeat: no-repeat; background-position: center;">
    <div class="container mt-4">
       <h1 class="text-black image-gallery-heading">Image Gallery</h1>
        <!-- Gallery Section with White Opacity Background -->
        <div class="gallery-container" style="position: relative;">

            <!-- White Overlay -->
            <div class="gallery-overlay"></div>
            <div class="gallery">
                @foreach ($defect_images as $key => $image)
                    <div class="gallery-item">
                        <h3 class="text-black">Defect Image {{$key+1}}</h3>
                        <img src="{{ asset('storage/' . $image->defect_image) }}" alt="Gallery Image" class="gallery-image">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
