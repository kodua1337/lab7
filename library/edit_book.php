<?php
require 'db.php';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $conn->query("UPDATE books SET title='$title', author_id=$author_id WHERE id=$id");
    header("Location: index.php");
    exit;
}

$book = $conn->query("SELECT * FROM books WHERE id=$id")->fetch_assoc();
$authors = $conn->query("SELECT * FROM authors");
?>

<h2>Редагувати книгу</h2>
<form method="post">
    Назва: <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required><br><br>
    Автор:
    <select name="author_id" required>
        <?php while ($row = $authors->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $book['author_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['name']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>
    <button type="submit">Зберегти</button>
</form>
<a href="index.php">← Назад</a>
