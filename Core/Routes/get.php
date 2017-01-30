<?php
  use Core\Router;

  //echo "Test";
  Router::route('/settings/{user_id}', 'UserController.show_settings'); // User panel
  Router::route('/', 'FrontpageController.index');  // Frontpage
  Router::route('/asset/{file_name}', 'AssetController.asset');
?>
