<?php 
    
function validateFormData(array $data): array
{
    $errors = [];

    if ($data['title'] === '') 
    {
        $errors['title'][] = "Не указано название";
    }
    if ($data['author'] === '') 
    {
        $errors['author'][] = "Не указан автор";
    }
    $date = DateTime::createFromFormat('Y-m-d', $data['year']);

    if (!$date || $date->format('Y-m-d') !== $data['year']) 
    {
        $errors['year'][] = "Дата указана неверно";
    } 
    else 
    {
        $yearValue = (int)$date->format('Y');
        $currentYear = (int)date('Y');

        if ($yearValue <= 0 || $yearValue > $currentYear) 
        {
            $errors['year'][] = "Год должен быть от 1 до $currentYear";
        }
    }
    if ($data['pages'] !== '' && (!is_numeric($data['pages']) || $data['pages'] <= 0)) 
    {
        $errors['pages'][] = "Количество страниц должно быть положительным";
    }

    if ($data['rating'] !== '' && (!is_numeric($data['rating']) || $data['rating'] < 1 || $data['rating'] > 10)) 
    {
        $errors['rating'][] = "Оценка должна быть от 1 до 10";
    }
    if ($data['isbn'] !== '' && !preg_match('/^[0-9\-]+$/', $data['isbn'])) 
    {
        $errors['isbn'][] = "ISBN не подходит";
    }
    return $errors;
}

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $data = [
            'title' => trim($_POST["title"] ?? ''),
            'author' => trim($_POST["author"] ?? ''),
            'year'=> $_POST['year'] ?? '',
            'genre'=> trim($_POST['genre'] ?? ''),
            'publisher' => trim($_POST['publisher'] ?? ''),
            'coverType' => $_POST['coverType'] ?? '',
            'pages'=> $_POST['pages'] ?? '',
            'isbn' => trim($_POST['isbn'] ?? ''),
            'rating' => $_POST['rating'] ?? '',
            'note'=> trim($_POST['note'] ?? '')

        ];

        session_start();
        $errors = validateFormData($data);
        if (empty($errors)) 
        {
            $_SESSION['success'] = "Нет ошибок";
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            file_put_contents('../data.txt', $json . PHP_EOL, FILE_APPEND);
        } 
        else 
        {
            $_SESSION['errors'] = $errors;
        }
        header('Location: form.php');
        exit;
    }


?>
