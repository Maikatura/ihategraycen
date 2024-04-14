<?php

class HomeController
{
    public function index()
    {
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>ihategraycen</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="i hate graycen">
            <meta name="keywords" content="graycen, hate, twitch">
            <meta property="og:image" content="https://ihategraycen.com/static/1.png">
          
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
            <style>
                body {
                    background-color: #000000;
                }
                #localVideo {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    display: none;
                }
            </style>
        </head>
        <body>
            <div class="d-flex justify-content-center align-items-center vh-100 flex-column">
                <img src="static/1.png" class="mb-3" alt="Your Image"><br>
                <div class="d-flex">
                    <a href="https://www.twitch.tv/graycen" id="twitchLink" class="btn btn-primary mr-2" target="_blank">
                        <i class="fab fa-twitch"></i> Twitch
                    </a>
                    <a href="https://www.linkedin.com/in/grayadams1/" id="linkedInLink" class="btn btn-primary mr-2" target="_blank">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                    <a href="/diary" id="blog" class="btn btn-primary">
                        <i class="fas fa-book"></i> Diary
                    </a>
                </div>
                
            
            </div>
        
            <video id="localVideo" width="100%">
                <source src="static/3.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        
            <script>
            window.addEventListener("pageshow", function (event) {
                var video = document.getElementById("localVideo");
                video.style.display = "none";
                video.pause();
                video.currentTime = 0;
            });
            
            document.getElementById("twitchLink").addEventListener("click", function(e) {
                e.preventDefault();
                var video = document.getElementById("localVideo");
                video.style.display = "block";
                video.play();
                setTimeout(function() {
                    window.location.href = e.target.href;
                }, 2000); // Redirect after 1.5 seconds
            });
            
            document.getElementById("linkedInLink").addEventListener("click", function(e) {
                e.preventDefault();
                var video = document.getElementById("localVideo");
                video.style.display = "block";
                video.play();
                setTimeout(function() {
                    window.location.href = e.target.href;
                }, 2000); // Redirect after 1.5 seconds
            });
            </script>
        </body>
        </html>';
        
    }
}
