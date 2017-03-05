<nav id="navbar">
    <ul id="left-menu">
        <?php
        $menu_left = '';
        $leftMenu = $this->_leftMenu;
        $countLeftMenu = count( $leftMenu );

        for ( $i = 0; $i < $countLeftMenu; $i++ ) {
            $lm = $leftMenu[ $i ][0];
            if ( !is_null( $lm['li_id'] ) )
                $li_id = "class=" . $lm['li_id'];
            else $li_id = '';

            $menu_left .=
                "<li $li_id>
                    <a  id=\"{$lm['id_a']}\" href=\"{$lm['id_a']}\">
                        <i class=\"{$lm['icon']}\"></i>
                        {$lm['name']}
                    </a>
                </li>
			";
            if ( count( $leftMenu[ $i ] ) > 1 ) {
                $j = 1;
                $menu_left .= "<ul class=\"submenu hide-submenu\">";
                while ( $j < count( $leftMenu[ $i ] ) ) {
                    $lm = $leftMenu[ $i ][ $j ];
                    $menu_left .=
                        "<li>
                            <a  id=\"{$lm['id_a']}\" href=\"{$lm['id_a']}\">
                                <i class=\"{$lm['icon']}\"></i>
                                {$lm['name']}
                            </a>
                        </li>";
                    $j++;
                }
                $menu_left .= "</ul>";

            }
        }
        echo $menu_left;
        ?>

    </ul>
</nav>