<?php
  use Core\Router;

  //echo "Test";
  Router::route('/settings/{user_id}', 'UserController.show_settings'); // User panel
  Router::route('/', 'FrontpageController.index');  // Frontpage
<<<<<<< HEAD

  Router::route('/station/{station_number}', 'StationController.index');
  
  Router::route('/createNewAccount', 'NewAccount.index'); # Stijn view test
=======
  Router::route('/createNewAccount', 'NewAccount.index'); # frontpage
  Router::route('/test', 'test.index'); # Stijn view test
>>>>>>> 0fdd9e200461e6e1f487a09610f0b37cb4f31a62
  Router::route('/assets/{file_name}', 'AssetController.asset');
?>
