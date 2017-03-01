<div id=wrap>
    <?php
    // include("base/top.php");
    // include("base/left.php");
    ?>
    <div id="top">
    </div>
    <div id="menu">
        <?php include( __DIR__ . "/../base/menu.php" ); ?>
    </div>
    <?php include( __DIR__ . "/../base/login_form.php" ); // loginform ?>

    <div id="left">
        <?php if ( !is_null( $this->_auth ) ) include( __DIR__ . "/../base/menu_left.php" ); ?>
    </div>

    <div id="right">
        <div class="autocomplete">
            <div class="ui-widget">
                <div class="label_p">
                    <label for="nzakaz">Номер заказа</label>
                </div>
                <input id="nzakaz" type="text">
            </div>
        </div>
    </div>


    <div id="test"></div>
    <?php
    //  include_once('base/footer.php');
    ?>

</div>
