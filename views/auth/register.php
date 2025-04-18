<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/crypto_trade/views/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark border-primary">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                        <h2 class="text-white">Créer un compte</h2>
                        <p class="text-muted">Rejoignez notre plateforme de trading de cryptomonnaies</p>
                    </div>
                    
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label text-white">Nom d'utilisateur</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-primary text-primary">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control bg-dark text-white border-primary" id="username" name="username" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-white">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-primary text-primary">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control bg-dark text-white border-primary" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-white">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-primary text-primary">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control bg-dark text-white border-primary" id="password" name="password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label text-white">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-dark border-primary text-primary">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control bg-dark text-white border-primary" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary button-85">
                                <i class="fas fa-rocket me-2"></i>S'inscrire
                            </button>
                        </div>
                    </form>
                    <!--
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Déjà un compte ? <a href="/crypto_trade/login" class="text-primary text-decoration-none">Se connecter</a></p>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/crypto_trade/views/partials/footer.php';
?>