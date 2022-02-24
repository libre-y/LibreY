
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title> <?php echo $_REQUEST["q"]; ?> - LibreX</title>
        <meta http-equiv="Content-type" content="application/xhtml+xml;charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="A privacy respecting meta search engine."/>
        <meta name="referrer" content="no-referrer"/>
        <link rel="stylesheet" type="text/css" href="static/styles.css"/>
        <link title="LibreX search" type="application/opensearchdescription+xml" href="/opensearch.xml?method=POST" rel="search"/>
        <link rel="shortcut icon" href="static/librex.png" />
    </head>
    <body>
        <form class="sub-search-container" method="post" enctype="multipart/form-data" autocomplete="off">
            <a href="/"><img id="logo" src="static/librex.png" alt="librex"></a>
            <input type="text" name="q" 
                <?php
                    $query = trim($_REQUEST["q"]);

                    if (1 > strlen($query) || strlen($query) > 256)
                    {
                        header("Location: /");
                        die();
                    } 
 
                    echo "value=\"$query\"";
                ?>
            >
            <br>
            <?php
                $type = $_REQUEST["type"];
                echo "<input type=\"hidden\" name=\"type\" value=\"$type\"/>";
            ?>
            <button type="submit" style="display:none;"></button>
            <input type="hidden" name="p" value="0">
            <div class="sub-search-button-wrapper">
                <button name="type" value="0"><img src="static/text_result.png">Text</button>
                <button name="type" value="1"><img src="static/image_result.png">Images</button>
                <button name="type" value="2"><img src="static/video_result.png">Videos</button>
                <button name="type" value="3"><img src="static/torrent_result.png">Torrents</button>
            </div>
            
        <hr>
        </form>

        <?php

            require_once "engines/google.php";
            require_once "engines/special.php";
            require_once "misc/tools.php";
            require_once "engines/bittorrent.php";
            require_once "config.php";

            $page = isset($_REQUEST["p"]) ? (int) $_REQUEST["p"] : 0;
            $type = isset($_REQUEST["type"]) ? (int) $_REQUEST["type"] : 0;

            $start_time = microtime(true);
            $results = $type != 3 ? get_google_results($query, $page, $type) : get_bittorrent_results($query);
            $end_time = number_format(microtime(true) - $start_time, 2, '.', '');

            echo "<p id=\"time\">Fetched the results in $end_time seconds</p>";
               
            switch ($type)
            {
                case 0:
                    print_text_results($results);
                    break;
                case 1:
                    print_image_results($results);
                    break;
                case 2:
                    print_video_results($results);
                    break;
                case 3:
                    print_bittorrent_results($results);
                    break;
                default:
                    print_text_results($results);
                    break;
            }

            if ($type != 1 && $type != 3 )
            {
                echo "<div class=\"next-page-button-wrapper\">";

                    if ($page != 0) 
                    {
                        print_next_page_button(0, "&lt;&lt;", $query, $type); 
                        print_next_page_button($page - 10, "&lt;", $query, $type);
                    }
                    
                    for ($i=$page / 10; $page / 10 + 10 > $i; $i++)
                    {
                        $page_input = $i * 10;
                        $page_button = $i + 1;
                        
                        print_next_page_button($page_input, $page_button, $query, $type);
                    }

                    print_next_page_button($page + 10, "&gt;", $query, $type);

                echo "</div>";
            }
        ?>

        <div class="footer-container">
            <a href="/">LibreX</a>
            <a href="https://github.com/hnhx/librex/" target="_blank">Source &amp; Instance list</a>
            <a href="/api.php" target="_blank">API</a>
            <a href="/donate.xhtml" id="right">Donate ❤️</a>
        </div>
    </body>
</html>