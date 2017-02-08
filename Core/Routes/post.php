<?php
    use Core\Router;

    Router::route('/login', 'FrontpageController.login');  // Frontpage
    Router::route('/firstlogin', 'FrontpageController.firstlogin');
    Router::route('/controlpanel', 'UserController.save_settings'); //Save new account settings

    ?>