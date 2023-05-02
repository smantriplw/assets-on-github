<?php
require_once '../lib/github.php';

$ref = @$_GET['ref'];
if (!isset($ref) || strcmp($ref, '/') == 0) {
    $ref = '.';
}

$items = GitHubLib::getContents($ref);
$outdir = realpath($ref . '..');

if (str_starts_with($outdir, realpath(''))) {
    $outdir = '.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= sprintf('%s/%s - %s', Config::$GITHUB_USERNAME, Config::$GITHUB_REPOSITORY, $ref) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        ul {
            margin-left: 30px;
        }
        ul li {
            margin-bottom: 5px;
            list-style: none;
        }

        textarea {
            width: 100vh;
            height: 50vh;
        }

        img {
            width: 300px;
        }
    </style>
</head>
<body>
        <h1>
            SMAN 3 Palu - "<?= $ref ?>"
        </h1>
        <?php
            if (isset($items) && is_array($items)) {
                echo "<pre><ul>";
                echo sprintf("<li><a href=\"index.php?ref=/%s\">..</a></li><br />", $outdir);
                foreach($items as $item) {
                    echo sprintf("<li><a href=\"index.php?ref=/%s\">%s</a> - SHA: %s (%d bytes)</li>", $item->path, $item->name, $item->sha, $item->size);
                }
                echo "</ul></pre>";
            } else if (is_object($items) && !isset($items->message)) {
        ?>
                SHA: <?= $items->sha ?> | Size: <?= $items->size ?> bytes | <a href="<?= $items->download_url ?>">RAW</a>
                <br /><br />
                <?php if ($items->encoding !== 'none') { ?>
                    <textarea>
                        <?= base64_decode($items->content); ?>
                    </textarea>
                <?php } else { ?>
                    <img src="<?= $items->download_url ?>" alt="img <?= $items->name ?>" />
                <?php } ?>
        <?php
            } else {
                echo "<a href='index.php?ref=.'>Empty</a>";
            }
        ?>
    <div>
        <!--
            RENDERED-DATA
            <?= json_encode($items); ?>
        -->
    </div>
</body>
</html>
