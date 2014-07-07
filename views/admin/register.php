<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'header.php' ?>

<?php

if( isset( $viewData['error'] ) ) {
    echo $viewData['error'];
}
?>

<div class="container">
<form action="" method="post">

        <h1 class="page-header">Registration</h1>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <label for="email">Email</label>
        <input type="text" name="email" id="email">

    <input class="btn btn-primary" type="submit" value="Register" label>
</div>
</form>

<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'footer.php' ?>


