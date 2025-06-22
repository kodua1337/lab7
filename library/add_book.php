<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $conn->query("INSERT INTO books (title, author_id) VALUES ('$title', $author_id)");
    header("Location: index.php");
    exit;
}

$authors = $conn->query("SELECT * FROM authors");
?>

<h2>Додати книгу</h2>
<form method="post">
    Назва: <input type="text" name="title" required><br><br>
    Автор:
    <select name="author_id" required>
        <?php while ($row = $authors->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
    </select><br><br>
    <button type="submit">Додати</button>
</form>
<a href="index.php">← Назад</a>
