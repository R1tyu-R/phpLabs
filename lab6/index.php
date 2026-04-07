<?php
$isFormOpen = isset($_GET['form']) && $_GET['form'] === 'open';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Books Catalog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <!-- Левая часть -->
    <div class="left">

        <div class="tabs">
            <a href="#" class="tab active">прочитала</a>
            <a href="#" class="tab">в библиотеке</a>
            <a href="#" class="tab">хочу купить</a>
        </div>

        <div class="table">
            <div class="row">Книга 1</div>
            <div class="row">Книга 2</div>
            <div class="row">Книга 3</div>
        </div>

    </div>

    <!-- Кнопка -->
    <a href="?form=open" class="add-button"></a>

    <!-- Форма -->
    <div class="form-panel <?php echo $isFormOpen ? 'open' : ''; ?>">
        <?php include 'form.php'; ?>
    </div>

</div>

</body>
</html>