<?php 
$root = $_SERVER['DOCUMENT_ROOT'];
include $root . '/crypto_trade/views/partials/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head> <!--En tete -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CryptoTrade - Your Premium Trading Platform</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link href="/crypto_trade/public/css/style.css" rel="stylesheet">
</head>
<body class="bg-black text-white">
        <!-- Hero Section -->
        <section class="hero py-5">
            <div class="container text-center py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h1 class="display-3 fw-bold mb-4">Simulez vos investissements en cryptomonnaies</h1>
                        <p class="lead mb-4">Découvrez le monde des cryptomonnaies sans risque financier. Suivez les cours en temps réel, achetez et vendez virtuellement, et affinez vos stratégies d'investissement.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="<?php echo BASE_URL; ?>/register" class="btn btn-primary button-85">
                                <i class="fas fa-rocket me-2"></i>Commencer gratuitement
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-shield-alt feature-icon"></i>
                            <h3>Plateforme sécurisée</h3>
                            <p>Mesures de sécurité de pointe pour protéger vos actifs 24/7</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-bolt feature-icon"></i>
                            <h3>Trades instantanés</h3>
                            <p>Exécutez des transactions instantanément avec notre moteur de performance élevée</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h3>Outils avancés</h3>
                            <p>Outils de trading professionnels et analyse du marché en temps réel</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Crypto Table Section -->
        <section id="crypto-table" class="crypto-table py-5">
            <div class="container">
                <h2 class="text-center mb-4">Cryptomonnaies les plus populaires</h2>
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Crypto-monnaie</th>
                                <th>Prix</th>
                                <th>Changement (24h)</th>
                                <th>Capitalisation de marché</th>
                                <th>Volume (24h)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><i class="fab fa-bitcoin me-2 text-warning"></i>Bitcoin (BTC)</td>
                                <td id="bitcoin-price">$43,250.65</td>
                                <td id="bitcoin-change" class="text-success">+2.34%</td>
                                <td id="bitcoin-marketcap">$825.6B</td>
                                <td id="bitcoin-volume">$28.1B</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><i class="fab fa-ethereum me-2 text-info"></i>Ethereum (ETH)</td>
                                <td id="ethereum-price">$2,285.42</td>
                                <td id="ethereum-change" class="text-danger">-1.25%</td>
                                <td id="ethereum-marketcap">$275.2B</td>
                                <td id="ethereum-volume">$15.4B</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><i class="fas fa-circle me-2 text-success"></i>USDT</td>
                                <td id="tether-price">$1.00</td>
                                <td id="tether-change" class="text-success">+0.01%</td>
                                <td id="tether-marketcap">$83.2B</td>
                                <td id="tether-volume">$62.5B</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><i class="fas fa-circle me-2 text-warning"></i>BNB</td>
                                <td id="binancecoin-price">$312.45</td>
                                <td id="binancecoin-change" class="text-success">+3.15%</td>
                                <td id="binancecoin-marketcap">$48.2B</td>
                                <td id="binancecoin-volume">$1.8B</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><i class="fas fa-circle me-2 text-primary"></i>XRP</td>
                                <td id="ripple-price">$0.5642</td>
                                <td id="ripple-change" class="text-danger">-0.85%</td>
                                <td id="ripple-marketcap">$29.8B</td>
                                <td id="ripple-volume">$1.2B</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><i class="fas fa-circle me-2 text-info"></i>Cardano (ADA)</td>
                                <td id="cardano-price">$0.4823</td>
                                <td id="cardano-change" class="text-success">+1.56%</td>
                                <td id="cardano-marketcap">$16.9B</td>
                                <td id="cardano-volume">$845.2M</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><i class="fas fa-circle me-2 text-secondary"></i>Solana (SOL)</td>
                                <td id="solana-price">$98.76</td>
                                <td id="solana-change" class="text-success">+5.23%</td>
                                <td id="solana-marketcap">$41.2B</td>
                                <td id="solana-volume">$2.1B</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td><i class="fas fa-circle me-2 text-warning"></i>Dogecoin (DOGE)</td>
                                <td id="dogecoin-price">$0.0856</td>
                                <td id="dogecoin-change" class="text-danger">-2.34%</td>
                                <td id="dogecoin-marketcap">$11.5B</td>
                                <td id="dogecoin-volume">$523.4M</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td><i class="fas fa-circle me-2 text-danger"></i>Polkadot (DOT)</td>
                                <td id="polkadot-price">$6.45</td>
                                <td id="polkadot-change" class="text-success">+0.95%</td>
                                <td id="polkadot-marketcap">$8.2B</td>
                                <td id="polkadot-volume">$312.6M</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td><i class="fas fa-circle me-2 text-primary"></i>Polygon (MATIC)</td>
                                <td id="matic-network-price">$0.892</td>
                                <td id="matic-network-change" class="text-danger">-1.12%</td>
                                <td id="matic-network-marketcap">$8.1B</td>
                                <td id="matic-network-volume">$285.3M</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Crypto Updates Script -->
    <script src="/crypto_trade/public/js/crypto-updates.js"></script>
</body>
</html>

<?php 
include $root . '/crypto_trade/views/partials/footer.php'; 
?>