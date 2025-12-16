<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/viewerjs/dist/viewer.min.css">
    <!-- <link rel="stylesheet" href="css.css"> -->
    <title>Image Gallery</title>
    <style>
        /* .viewer-canvas {
            position: fixed;
        }
        .viewer-transition{
            transform: none !important;
        }
        .viewer-list{
            transform:none !important;
            width: 200px !important;
            display: flex;
            flex-direction: column;
            padding-left: 10px;
            height: 100%;
            position: relative;
        }
        .viewer-navbar{
            width: 200px;
            padding-left: 40px;
        
        }
        .viewer-toolbar{
            position: fixed;
            z-index: 1;
        }
        .viewer-footer{
            position: relative;
            width: 200px;
            height: 100%;

        }
        .viewer-list li {
            width: 200px;
            height: 200px;
            margin-top: 10px;
        }
        .viewer-list li img{
            width: 200px;
            height: 200px;
        }
        .viewer-prev{
            -webkit-transform: rotate(90deg);
            border: 1px solid red;
            padding: 10px;
        } */
        .gallery_image{ 
            width: 24.7%;
            height: 350px;
            border-radius: 10px;
        }
        .viewer-canvas{
            background-color: black;
        }
        @media (max-width: 1033px) {
            .gallery_image{
                width: 33%;
            }
        }
        @media (max-width: 820px) {
            .gallery_image{
                width: 49%;
            }
        }
        @media (max-width: 500px) {
            .gallery_image{
                height: 300px;
            }
        }
        .gallery_heading{
            font-size: 40px;
        }
        .gallry_sub_heading{
            font-size: 20px;
        }
        </style>
</head>
<body style="background-color: black !important;">
    <div class="text-white mb-3">
        <div class="gallery_heading fw-bold text-center">
            MOMENTS THAT MATTER
        </div>
        <div class="gallery_sub_heading text-center">
            A glimpse into our students' journey, achievements, and unforgettable memories.
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="nav nav-pills mb-3 px-4 py-2 fw-bold" id="pills-tab" role="tablist" style="background-color: lightgrey; border-radius: 5px;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">IMAGES</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">VIDEOS</button>
            </li>
        </ul>
    </div>
    <?php
        include "config/db.php";
        $result = mysqli_query($conn, "SELECT * FROM gallery_images ORDER BY id DESC");
        ?>

        <div class="gallery px-4">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <img class="gallery_image my-2 img-thumbnail"
            src="assets/gallery/<?= $row['image'] ?>">
    <?php } ?>
    </div>

    <script src="https://unpkg.com/viewerjs/dist/viewer.min.js"></script>
    <script>
        const gallery = document.querySelector('.gallery');
        const viewer = new Viewer(gallery, {
            // Options for the viewer
            inline: false,
            button: true,
            navbar: true,
            title: true,
            toolbar: true,
            movable: true,
            rotatable: true,
            zoomable: true,
            scalable: true,
            transition: true,
            fullscreen: true,
            // Add more options as needed
        });
    </script>
</body>
</html>