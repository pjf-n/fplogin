<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'header.php' ?>

<?php
if( isset( $viewData['error'] ) ) {
    echo '<p>' . $viewData['error'] . '</p>';
}
?>
<div class="container">
<form action="<?php echo $viewData['loginUrl'] ?>" method="post">

    <h1 class="page-header">Please sign in</h1>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="">

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    <button class="btn btn-primary" type="submit">Sign in</button>


</div>
</form>

<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'footer.php' ?>

<div class="container">

