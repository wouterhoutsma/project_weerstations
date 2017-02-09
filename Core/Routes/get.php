<?php
  use Core\Router;

  //echo "Test";
  Router::route('/settings', 'UserController.show_Settings');
  Router::route('/', 'FrontpageController.index');  // Frontpage

  Router::route('/login', 'FrontpageController.index');
  Router::route('/logout', 'FrontpageController.logout');

  Router::route('/station/{station_number}', 'StationController.index');
  Router::route('/userconfiguration', 'UserConfiguration.index');
  Router::route('/userconfiguration/{user_id}/yes', 'UserConfiguration.delete_account');
  Router::route('/confirmdelete/{user_id}', 'UserConfiguration.confirm_delete_account');
  Router::route('/createnewaccount', 'UserConfiguration.create_account_form'); # Create new account
  Router::route('/assets/{file_name}', 'AssetController.asset');

  Router::route('/getweatherdata/{station}/{time}', 'StationController.get_data'); # 'API' call for the stations

?>
