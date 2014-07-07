<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'header.php' ?>

<?php if( isset( $viewData['username'] ) ): ?>
    <h1 class="page-header">Welcome back!<?php echo $viewData['username'] ?><h1>
    <p><a href="<?php echo $viewData['logoutUrl'] ?>" title="Logout">Logout</a></p>
<?php endif ?>

<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'footer.php' ?>