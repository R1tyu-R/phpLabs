<?php  

$books = [];  

if (file_exists('../data.txt')) 
{
    $lines = file('../data.txt');  
    foreach ($lines as $line) 
    {
        $books[] = json_decode($line, true);  
    }
}

$sort = $_POST['sort'] ?? '';

if ($sort === 'title') 
{
    usort($books, 'sortByTitle');
}

if ($sort === 'rating') 
{
    usort($books, 'sortByRating');
}

if ($sort === 'year') 
{
    usort($books, 'sortByYear');
}

function sortByTitle($a, $b): int
{
    if ($a['title'] > $b['title']) 
    {
        return 1;
    } 
    elseif($b['title'] > $a['title']) 
    {
        return -1;
    }
    return 0;
}

function sortByRating($a, $b): int
{
    if ((int)$a['rating'] > (int)$b['rating']) 
    {
        return -1;
    } 
    elseif ((int)$b['rating'] > (int)$a['rating']) 
    {
        return 1;
    }
    return 0;
}

function sortByYear($a, $b): int
{
    if ($a['year'] > $b['year']) 
    {
        return 1;
    } 
    elseif ($b['year'] > $a['year']) 
    {
        return -1;
    }
    return 0;
}

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Моя библиотека</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="container">

    <div class="nav">
        <a href="../index.php">Главная</a>
        <a href="library.php">Моя библиотека</a>
        <a href="wishlist.php">Желаемое</a>
        <a href="form.php">Добавить</a>
    </div>

    <div class="content">
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="sort-form">
        <button type="submit" name="sort" value="title">По названию</button>
        <button type="submit" name="sort" value="rating">По оценке</button>
        <button type="submit" name="sort" value="year">По году</button>
    </form>

    <table>
        <tr>
            <th>Название</th>
            <th>Автор</th>
            <th>Год</th>
            <th>Жанр</th>
            <th>Оценка</th>
        </tr>

        <?php foreach ($books as $book){ ?>
            <tr>
                <td><?php echo htmlspecialchars($book['title'] ?? '') ?></td>
                <td><?php echo htmlspecialchars($book['author'] ?? '') ?></td>
                <td><?php echo htmlspecialchars($book['year'] ?? '') ?></td>
                <td><?php echo htmlspecialchars($book['genre'] ?? '') ?></td>
                <td><?php echo htmlspecialchars($book['rating'] ?? '') ?></td>
            </tr>
        <?php } ?>
    </table>
    
    </div>

</div>

</body>
</html>