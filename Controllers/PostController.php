<?php

class PostController
{

    public function index()
    {
        require __DIR__ . '/../vendor/autoload.php';

        // Get all Markdown files in the posts directory
        $markdownFiles = glob(__DIR__ . '/../static/posts/*.md');
    
        $posts = [];
    
        // Loop through all files to extract the metadata
        foreach ($markdownFiles as $markdownFile) {
            $content = file_get_contents($markdownFile);
    
            // Extract metadata from the top of the Markdown file
            preg_match('/author:\s*(.*\S)/', $content, $authorMatches);
            preg_match('/date:\s*(.*\S)/', $content, $dateMatches);
            preg_match('/url:\s*(.*\S)/', $content, $urlMatches);
            preg_match('/title:\s*(.*\S)/', $content, $titleMatches);
    
            $author = $authorMatches[1] ?? "Unknown";
            $date = $dateMatches[1] ?? '1970-01-01';
            $url = $urlMatches[1] ?? pathinfo($markdownFile, PATHINFO_FILENAME);
            $title = $titleMatches[1] ?? "No Title";
    
            // Convert the date string to a DateTime object
            $date = DateTime::createFromFormat('Y-m-d', $date);
    
            // Store the metadata in the posts array
            $posts[] = ['author' => $author, 'date' => $date, 'url' => $url, 'title' => $title];
        }
    
        // Sort the posts array by date
        usort($posts, function($a, $b) {
            return $b['date'] <=> $a['date'];
        });
    
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Graycens Diary</title>
            <!-- Darkly Bootstrap CSS -->
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/darkly/bootstrap.min.css'>
        </head>
        <body>
            <!-- Navbar -->
            <nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
                <a class='navbar-brand' href='/'>Graycens Diary</a>
            </nav>
            <!-- Post List -->
            <div class='container mt-4'>
                <div class='post-list'>";
        
                foreach ($posts as $post) {
                    echo "
                    
                        <div class='card mb-4'>
                            <div class='card-body'>
                                <h2 class='card-title'>{$post['title']}</h2>
                                <a href='/post/{$post['url']}' class='btn btn-primary'>Read More &rarr;</a>
                            </div>
                            <div class='card-footer text-muted'>
                                Posted on {$post['date']->format('Y-m-d')} by <a href='/post/{$post['url']}'>{$post['author']}</a>
                            </div>
                        </div>
                    ";
                }
    
        echo "
                </div>
            </div>
            <!-- Bootstrap JS and jQuery -->
            <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
        </body>
        </html>";
    }

    public function PostIndex($args)
    {
        require __DIR__ . '/../vendor/autoload.php';

        $parsedown = new Parsedown();

        // Get all Markdown files in the posts directory
        $markdownFiles = glob(__DIR__ . '/../static/posts/*.md');

        $markdownContent = '';
        $author = '';
        $date = '';
        $url = '';

        // Loop through all files to find the one with the matching URL
        foreach ($markdownFiles as $markdownFile) {
            $content = file_get_contents($markdownFile);

            // Extract author, date, and URL from the top of the Markdown file
            preg_match('/author:\s*(.*\S)/', $content, $authorMatches);
            preg_match('/date:\s*(.*\S)/', $content, $dateMatches);
            preg_match('/url:\s*(.*\S)/', $content, $urlMatches);
            preg_match('/title:\s*(.*\S)/', $content, $title);

            $url = $urlMatches[1] ?? pathinfo($markdownFile, PATHINFO_FILENAME); // Use file name without extension if no URL match


            if ($url === $args["post_name"]) {
                $author = $authorMatches[1] ?? "Unknown"; // Use file name without extension if no author match
                $date = $dateMatches[1] ?? '1970-01-01';
                $title = $title[1] ?? 'No Title';

                // Remove the author, date, and URL lines from the Markdown content
                $markdownContent = preg_replace('/author: .*\n/', '', $content);
                $markdownContent = preg_replace('/date: .*\n/', '', $markdownContent);
                $markdownContent = preg_replace('/url: .*\n/', '', $markdownContent);
                $markdownContent = preg_replace('/title: .*\n/', '', $markdownContent);
                break;
            }
        }

        // If no matching URL was found, use a default file
        if ($markdownContent === '') 
        {
            $defaultFile = __DIR__ . '/../static/posts/default.md';
            if (file_exists($defaultFile)) {
                $content = file_get_contents($defaultFile);
                $markdownContent = preg_replace('/author: .*\n/', '', $content);
                $markdownContent = preg_replace('/date: .*\n/', '', $markdownContent);
                $markdownContent = preg_replace('/url: .*\n/', '', $markdownContent);
                $markdownContent = preg_replace('/title: .*\n/', '', $markdownContent);
                $author = pathinfo($defaultFile, PATHINFO_FILENAME);
            } else {
                $htmlContent = "<p>Default Markdown file does not exist.</p>";
            }
        }

        if ($markdownContent !== '') {

            $date = DateTime::createFromFormat('Y-m-d', $date);
            $htmlContent = "<a href='/posts'>&larr; Back to Posts</a><hr>";
            $htmlContent .= "<h1>$title</h1>";
            $htmlContent .= "Posted on " . $date->format('Y-m-d') ." by <a href='#'>". $author ."</a><hr>";

            $htmlContent .= $parsedown->text($markdownContent);
        }

        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Graycens Diary</title>
            <!-- Darkly Bootstrap CSS -->
            <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootswatch/4.3.1/darkly/bootstrap.min.css'>
        </head>
        <body>
            <!-- Navbar -->
            <nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
                <a class='navbar-brand' href='/'>Graycens Diary</a>
            </nav>
            <!-- Post Content -->
            <div class='container mt-4'>
            <style>
            img[src*='#left'] {
                float: left;
            }
            img[src*='#right'] {
                float: right;
            }
            img[src*='#center'] {
                display: block;
                margin: auto;
            }
            </style>
                <div class='post-content'>
                    $htmlContent
                </div>
            </div>
            <!-- Bootstrap JS and jQuery -->
            <script src='https://code.jquery.com/jquery-3.3.1.slim.min.js'></script>
            <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>
        </body>
        </html>";
    }
}
