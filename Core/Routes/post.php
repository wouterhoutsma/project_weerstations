<?php
    use Core\Router;

    Router::route('/login', 'FrontpageController.login');  // Frontpage
    Router::route('/firstlogin', 'FrontpageController.firstlogin');

    ?>