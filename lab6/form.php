<form method="POST" action="">

    <h2>Добавить книгу</h2>

    <input type="text" name="title" placeholder="Название" required>
    <input type="text" name="author" placeholder="Автор">

    <label>Год издания:</label>
    <input type="date" name="year">

    <input type="text" name="genre" placeholder="Жанр">
    <input type="text" name="publisher" placeholder="Издательство">

    <label>Тип обложки:</label>
    <select name="cover">
        <option>Твердая</option>
        <option>Мягкая</option>
    </select>

    <input type="number" name="pages" placeholder="Количество страниц">
    <input type="number" name="isbn" placeholder="ISBN">
    <input type="number" name="rating" placeholder="Оценка">

    <textarea name="note" placeholder="Примечание"></textarea>

    <label>Куда добавить:</label>
    <select name="status">
        <option>прочитано</option>
        <option>в библиотеке</option>
        <option>хочу купить</option>
    </select>

    <button type="submit">Сохранить</button>

    <!-- кнопка закрытия -->
    <a href="index.php" class="close-btn">Закрыть</a>

</form>