<div style='text-align: center; font-size: 12px; line-height: 1.2; font-family: sans-serif; color: #333;'>
    <?php foreach ($pinyins ?? [] as $pinyin): ?>
        <?= $pinyin ?><br>
    <?php endforeach; ?>
</div>