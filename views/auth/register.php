<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark border-primary">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Créer un compte</h2>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="/crypto_trade/register" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control bg-dark text-white" id="username" name="username" required>
                            <div class="invalid-feedback">
                                Veuillez choisir un nom d'utilisateur.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control bg-dark text-white" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Veuillez entrer une adresse email valide.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control bg-dark text-white" id="password" name="password" required>
                            <div class="invalid-feedback">
                                Veuillez entrer un mot de passe.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control bg-dark text-white" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">
                                Les mots de passe ne correspondent pas.
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">J'accepte les conditions d'utilisation</label>
                            <div class="invalid-feedback">
                                Vous devez accepter les conditions d'utilisation.
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">S'inscrire</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p>Déjà un compte ? <a href="/crypto_trade/login" class="text-primary">Se connecter</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation du formulaire
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()

// Vérification de la correspondance des mots de passe
document.getElementById('confirm_password').addEventListener('input', function() {
    var password = document.getElementById('password').value;
    var confirmPassword = this.value;
    if (password !== confirmPassword) {
        this.setCustomValidity('Les mots de passe ne correspondent pas');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
