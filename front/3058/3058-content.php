<?php
$url_host = $_SERVER['HTTP_HOST'];

$pattern_document_root = addcslashes(realpath($_SERVER['DOCUMENT_ROOT']), '\\');

$pattern_uri = '/' . $pattern_document_root . '(.*)$/';

preg_match_all($pattern_uri, __DIR__, $matches);

$url_path = $url_host . $matches[1][0];

$url_path = str_replace('\\', '/', $url_path);
?>

</div>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <section class="repair-section">
        <div class="container">
            <div class="faq-section">
                <h1>FAQ</h1>
                <table>
                    <tr>
                        <td>
                            <h3> &nbsp; — &nbsp; Duis ac massa vehicula, cursus nibh id?</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Pellentesque dignissim elit nec sagittis dignissim. Curabitur at massa pulvinar, ornare enim volutpat, ultricies augue. Nam rutrum mi non elit bibendum faucibus. Quisque sem massa, semper aliquet ligula non, venenatis semper lectus. Aenean ut posuere sapien. Quisque fringilla diam nec magna semper, vitae imperdiet purus ornare. Cras a justo sed arcu euismod euismod. Maecenas blandit turpis at sem malesuada lobortis.</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h3>&nbsp; + &nbsp;Praesent rhoncus euismod nisl?</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>&nbsp; + &nbsp;Donec quis luctus erat?</h4>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="input-content">
                <h2>...or ask your question</h2>
                <form>
                    <input type="text" placeholder="Enter your name">
                    <input type="email" placeholder="Enter your email">
                    <textarea rows="4" placeholder="Enter your question"></textarea>
                    <button type="submit">ASK</button>
                </form>
            </div>
        </div>
    </section>

</body>

</html>
</div>