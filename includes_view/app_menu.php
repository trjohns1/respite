<!-- This is the list of common applications displayed in the menu bar-->

			<li><a href="../../respite/main/home.php">Home</a></li>
			<li><a href="../../respite/main/myAccount.php">My Account</a></li>

			<li class="menuDivider">Applications</li>

         <?php
            $authorizedRoles = array(
               'resource_user'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="../../resources/main/resourcesHome.php">Resources</a></li>';
            }
         ?>
         <?php
            $authorizedRoles = array(
               'respite_user'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="../../stagecoach/main/home.php">Stagecoach</a></li>';
            }
         ?>
         <?php
            $authorizedRoles = array(
               'respite_user'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="https://respite_server.example.com/secure/focis/main/main.php" target="_blank">FOCIS</a></li>';
            }
         ?>
         <?php
            $authorizedRoles = array(
               'remedy_user'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="../../remedy/main/home.php">Remedy</a></li>';
            }
         ?>

         <?php
            $authorizedRoles = array(
               'respite_administrator'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li class="menuDivider">System</li>';
            }
         ?>

         <?php
            $authorizedRoles = array(
               'respite_administrator'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="../../respite/main/adminHome.php">Administration</a></li>';
            }
         ?>
         <?php
            $authorizedRoles = array(
               'respite_administrator'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="../../respite/main/respiteHome.php">Respite</a></li>';
            }
         ?>

         <?php
            $authorizedRoles = array(
               'respite_user'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li class="menuDivider"></li>';
               echo '<li><a href="https://' . $_SERVER['HTTP_HOST'] . '/Shibboleth.sso/Logout' . '">Logout</a></li>';
            }
         ?>

