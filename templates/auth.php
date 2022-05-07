<?php
/** @var string $error This is form error message. */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tasks app</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<div class="wrapper">
    <h1>Authentication</h1>
    <form class="auth-form" action="/auth.php" method="post">
        <label>
            Login:
            <input class="input auth-form__input" type="text" name="login">
        </label>

        <label>
            Password:
            <input class="input auth-form__input" type="password" name="password">
        </label>
        <?php if ($error): ?>
            <p class="auth-form__error"><?=$error?></p>
        <?php endif; ?>
        <button class="button auth-form__button">Login</button>
    </form>
</div>

</body>
</html>