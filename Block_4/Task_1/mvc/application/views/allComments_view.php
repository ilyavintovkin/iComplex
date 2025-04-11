<h1>Отзывы</h1>

<?php foreach($data as $row): ?>
    <div class="review">
        <p>
            <strong>
                <?= htmlspecialchars($row['author'])  ?>
            </strong>
            <?= ': ' . nl2br(htmlspecialchars($row['message'])) ?>
        </p>
        <br>
    </div>
<?php endforeach; ?>