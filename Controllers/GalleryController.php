<?php

class GalleryController
{
    public function index()
    {
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Graycen Jumpscare</title>
            <!-- Darkly Bootstrap CSS -->
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/darkly/bootstrap.min.css'>
        </head>
        <body>
            <!-- Navbar -->
            
            <div class='container'>
                <div class='post-content'>
                    
                    {$this->Gallery()}

                </div>
            </div>
            <!-- Bootstrap JS and jQuery -->
            <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
        </body>
        </html>";
    }

    public function Gallery()
    {
        return "<style>
        .containerImg {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
          }
          
          
        </style>

        <div class='containerImg'>

    
        <img src='/static/gallery/GraycenWide.png' width='100%'>
      

        </div>";
    }
}
