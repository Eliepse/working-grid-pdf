<svg version="1.1" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg">
	<g transform="scale(1, -1) translate(0, -900)">

        <?php if (isset($strokes)): ?>
            <?php foreach ($strokes as $stroke): ?>

				<path d="<?= $stroke ?>" fill="<?= $fill ?? '#333333' ?>"></path>

            <?php endforeach; ?>
        <?php endif; ?>

	</g>
</svg>