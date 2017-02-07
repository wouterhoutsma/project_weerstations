<?php
  use Core\Router;

  //echo "Test";
  Router::route('/settings/{user_id}', 'UserController.show_settings'); // User panel
  Router::route('/', 'FrontpageController.index');  // Frontpage

  Router::route('/station/{station_number}', 'StationController.index');
  
  Router::route('/createNewAccount', 'NewAccount.index'); # Stijn view test
  Router::route('/assets/{file_name}', 'AssetController.asset');
?>
