<?php include_once __DIR__ . '/../partials/header.php'; ?>

<h1 style="text-align:center;">📈 Marché des Crypto-Monnaies</h1>

<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; text-align: center;">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Symbole</th>
            <th>Prix actuel</th>
            <th>Variation 24h</th>
            <?php if (isset($_SESSION['user_id'])): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cryptos as $crypto): ?>
            <tr>
                <td><?= htmlspecialchars($crypto['name']) ?></td>
                <td><?= strtoupper(htmlspecialchars($crypto['symbol'])) ?></td>
                <td><?= number_format($crypto['price'], 4) ?> $</td>
                <td>
                    <?php
                    $variation = $crypto['variation'] ?? 0;
                    $color = $variation >= 0 ? 'green' : 'red';
                    echo "<span style='color: $color'>" . ($variation >= 0 ? '+' : '') . number_format($variation, 2) . "%</span>";
                    ?>
                </td>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <td>
                        <form method="post" action="/buy">
                            <input type="hidden" name="crypto_id" value="<?= $crypto['id'] ?>">
                            <button type="submit">Acheter</button>
                        </form>
                        <form method="post" action="/sell">
                            <input type="hidden" name="crypto_id" value="<?= $crypto['id'] ?>">
                            <button type="submit">Vendre</button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
