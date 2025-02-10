<!DOCTYPE html>
<html lang="de">
<head>
    <title>Login</title>
    <?= view('head') ?>
    <?php
    if(!isset($show_alert))
        $show_alert = false;
    ?>
</head>
<body>

<!-- Header -->
<header class="w3-container w3-red w3-center" style="padding:50px 16px">
    <h1 class="w3-margin w3-jumbo">PTPM</h1>
    <p class="w3-xlarge">Playful Third Party Management</p>
</header>

<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container">
    <div class="w3-content">
            <h1 style="text-align: center">Anmelden</h1>

        <form action="<?= base_url('/login') ?>" method="post">
                <div class="col-5" style="margin: auto">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control <?= $show_alert ? 'is-invalid' : '' ?> " id="username" maxlength="3" required>
                </div>
                <div class="col-5" style="margin: auto">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control <?= $show_alert ? 'is-invalid' : '' ?> " required>
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="pwEyeDiv" style="display: block">
                                <i  class="fa-solid fa-eye-slash" id="passwordEye"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            if ($show_alert)
                echo '<div  class="alert ptpm-alert high" style="max-width:410px; margin:auto; padding-top: 5px; padding-bottom: 5px; margin-top: 10px">
                <span id="fadeout-button" class="closebtn-red" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                <em> Ungültige Anmeldedaten! </em> </div>';
            ?>
                <div class="col-5" style="margin: 10px auto"><input type="submit" class="form-control" value="einloggen"></div>

            </form>
        </div>
</div>

<?= view('footer') ?>

</body>
</html>

<script>
    var closeButton = document.getElementById("fadeout-button");

    if(closeButton !== null) {
        closeButton.onclick = function () {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function () {
                div.style.display = "none";
            }, 600);
        }
    }

    function showPassword() {
        let eyeIcon = document.getElementById('passwordEye');
        let pwField = document.getElementById('password');
        pwField.type = 'text';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }

    function hidePassword() {
        let eyeIcon = document.getElementById('passwordEye');
        let pwField = document.getElementById('password');
        pwField.type = 'password';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    }

    document.getElementById('pwEyeDiv').addEventListener('mousedown', showPassword);
    document.addEventListener('mouseup', hidePassword);

</script>
