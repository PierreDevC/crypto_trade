<!DOCTYPE html>
<html lang="fr">
<head>
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
    <!-- Main Container -->
    <div class="main-container mx-auto px-4">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark py-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="/crypto_trade">
                    <i class="fas fa-coins me-2"></i>CryptoTrade
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/crypto_trade">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/#crypto-table">Cryptomonnaies</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/crypto_trade/about">À propos</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a href="/crypto_trade/login" class="btn btn-link text-white text-decoration-none">Se connecter</a>
                        <a href="<?php echo BASE_URL; ?>/register" class="btn btn-primary ms-3">Commencer gratuitement</a>
                    </div>
                </div>
            </div>
        </nav>