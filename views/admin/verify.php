<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'header.php' ?>

<p>The account <?php echo $viewData['userData']['username'] ?> has been activated, thank you.</p>
    <p><a href="<?php echo $viewData['logoutUrl'] ?>" title="Logout">Logout</a></p>

<?php require_once ABS_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'general' . DIRECTORY_SEPARATOR . 'footer.php' ?>