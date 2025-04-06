<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/crypto_trade/views/partials/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card bg-dark border-primary">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                        <h2 class="text-white">Connexion</h2>
                        <p class="text-muted">Connectez-vous à votre compte pour accéder à votre espace</p>
                    </div>
                    
                    <form action="" method="POST">
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

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label text-white" for="remember">Se souvenir de moi</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary button-85">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Pas encore de compte ? <a href="<?php echo BASE_URL; ?>/register" class="text-primary text-decoration-none">S'inscrire</a></p>
                        <a href="#" class="text-primary text-decoration-none mt-2 d-block">Mot de passe oublié ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/crypto_trade/views/partials/footer.php';
?>