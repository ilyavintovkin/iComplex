<h2>Форма отправки отзыва</h2>
<form action="../submit_comment.php" method="POST">

    <label for="author">Автор:</label>
    <input type="text" id="author" name="author" required>

    <label for="message">Комментарий:</label>
    <textarea id="message" name="message" required></textarea>

    <button type="submit">Отправить</button>
</form>
