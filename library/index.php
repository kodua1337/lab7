<?php
require 'db.php';

// Отримуємо всі книги
$result = $conn->query("
    SELECT books.id, books.title, authors.name AS author, books.total_orders
    FROM books
    LEFT JOIN authors ON books.author_id = authors.id
");

// Отримуємо найпопулярніші книги
$report = $conn->query("
    SELECT books.title, authors.name AS author, COUNT(orders.id) AS order_count
    FROM orders
    JOIN books ON orders.book_id = books.id
    JOIN authors ON books.author_id = authors.id
    GROUP BY books.id
    ORDER BY order_count DESC
");

if (!$report) {
    die("Помилка при виконанні звіту: " . $conn->error);
}
?>

<h2>📚 Книги бібліотеки</h2>
<a href="add_book.php">+ Додати нову книгу</a>
<br><br>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Назва</th>
        <th>Автор</th>
        <th>Замовлення</th>
        <th>Дії</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= $row['total_orders'] ?></td>
            <td>
                <a href="edit_book.php?id=<?= $row['id'] ?>">Редагувати</a> |
                <a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Видалити цю книгу?')">Видалити</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<hr>
<h2>📊 Найпопулярніші книги</h2>

<?php if ($report->num_rows > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Назва книги</th>
            <th>Автор</th>
            <th>Кількість замовлень</th>
        </tr>
        <?php while($row = $report->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['author']) ?></td>
                <td><?= $row['order_count'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Наразі жодна книга не була замовлена.</p>
<?php endif; ?>
