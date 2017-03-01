<ul>
    <?php
    \Base\mainMenu::getMenu( $this->_FileMainMenu )->render();
    \Pdo\GetUser::GetUser( $this->_auth )->render();
    ?>
</ul>