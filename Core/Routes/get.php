<?php
  use Core\Router;

  //echo "Test";
  Router::route('/settings', 'UserController.show_Settings');
  //Router::route('/settings/{user_id}', 'UserController.show_admin_settings'); // User panel
  Router::route('/', 'FrontpageController.index');  // Frontpage

  Router::route('/login', 'FrontpageController.index');
  Router::route('/logout', 'FrontpageController.logout');

  Router::route('/station/{station_number}', 'StationController.index');
  Router::route('/userconfiguration', 'UserConfiguration.index');
  Router::route('/createnewaccount', 'NewAccount.index'); # Create new account
  Router::route('/assets/{file_name}', 'AssetController.asset');
  //Router::route('/controlpanel', 'UserController.show_settings');
?>
