
<section>
        <div class="box">
            <div class="container"> 
                <!-- Formulaire de Connexion -->
                <div class="form" id="login-form">
                    <h2>LOGIN</h2>
                    <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="error-message" style="color:white;">
                        <?php
                        echo htmlspecialchars($_SESSION['error_message']);
                        unset($_SESSION['error_message']);
                        ?>
                    </div>
                    <?php endif; ?>
                    <form action="connexion.php" method="post">
                        <div class="inputBx">
                            <input type="text" name="username" required="required" placeholder="Nom d'utilisateur">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="inputBx password">
                            <input id="password-input" type="password" name="password" required="required" placeholder="Mot de passe">
                            <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="inputBx">
                            <input type="submit" value="Login"> 
                        </div>
                    </form>
                    <p>Vous n'avez pas de compte? <a href="#" id="show-signup-form">Inscrivez-vous</a></p>
                </div>
                
                <!-- Formulaire d'Inscription -->
                <div class="form" id="signup-form" style="display: none;">
                    <h2>INSCRIPTION</h2>
                    <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="error-message">
                        <?php
                        echo htmlspecialchars($_SESSION['error_message']);
                        unset($_SESSION['error_message']);
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message">
                        <?php
                        echo htmlspecialchars($_SESSION['success_message']);
                        unset($_SESSION['success_message']);
                        ?>
                    </div>
                    <?php endif; ?>
                    <form action="inscription.php" method="post">
                        <div class="inputBx">
                            <input type="text" name="username" required="required" placeholder="Nom d'utilisateur">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="inputBx">
                            <input type="email" name="mail" required="required" placeholder="Email">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="inputBx password">
                            <input id="password-input-signup" type="password" name="password" required="required" placeholder="Mot de passe">
                            <a href="#" class="password-control" onclick="return show_hide_password(this);"></a>
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="inputBx">
                            <input type="submit" value="Sign up"> 
                        </div>
                    </form>
                    <p>Vous avez déjà un compte? <a href="#" id="show-login-form">Se connecter</a></p>
                </div>
            </div>
        </div>
    </section>
    <script>
        // JavaScript pour basculer entre les formulaires
        document.getElementById('show-signup-form').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('signup-form').style.display = 'block';
        });

        document.getElementById('show-login-form').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        });

        function show_hide_password(target) {
            var input = target.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                target.classList.add('view');
            } else {
                input.type = "password";
                target.classList.remove('view');
            }
            return false;
        }
    </script>