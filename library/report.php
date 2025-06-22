<?php
require 'db.php';

$result = $conn->query("
    SELECT books.title, authors.name AS author, COUNT(orders.id) AS order_count
    FROM orders
    JOIN books ON orders.book_id = books.id
    JOIN authors ON books.author_id = authors.id
    GROUP BY books.id
    ORDER BY order_count DESC
");

?>

<h2>Найпопулярніші книги</h2>
<a href="index.php">← Назад</a>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Назва книги</th>
        <th>Автор</th>
        <th>Кількість замовлень</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= $row['order_count'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
