<?php
  use Core\Router;

  //echo "Test";
  Router::route('/settings/{user_id}', 'UserController.show_settings'); // User panel
  Router::route('/', 'FrontpageController.index');  // Frontpage
  Router::route('/FirstLogin', 'Firstlogin.index');
  Router::route('/station/{station_number}', 'StationController.index');
  Router::route('/UserConfiguration', 'UserConfiguration.index');
  Router::route('/createNewAccount', 'NewAccount.index'); # Create new account
  Router::route('/assets/{file_name}', 'AssetController.asset');
?>
