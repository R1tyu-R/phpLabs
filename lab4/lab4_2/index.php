<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>My Image Gallery</h1>
    </header>

    <nav>
        <a href="#">Home</a>
        <a href="#">Gallery</a>
        <a href="#">Contacts</a>
    </nav>
    <?php
    $dir = 'image/';
    $files = scandir($dir);

    if ($files === false) {
        return;
    }
    $count = 0;
    ?>
    <table border='1'>
        <?php
        foreach ($files as $file) {

            if ($file != "." && $file != "..") {

                if ($count % 5 == 0) { ?>
                    <tr>
                    <?php
                }
                    ?>
                    <td>
                        <img src="image/<?php echo $file; ?>" width="150">
                    </td>
                    <?php
                    $count++;
                    if ($count % 5 == 0) {
                    ?>
                    </tr>
        <?php
                    }
                }
            }
        ?>
    </table>


    <footer>
        <p>Gallery footer</p>
    </footer>

</body>

</html>