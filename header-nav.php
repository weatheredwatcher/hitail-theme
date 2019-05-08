<nav class="navbar navbar-expand-md navbar-dark bg-trans fixed-top">
    <a class="navbar-brand" href="#"><img src="/wp-content/themes/hitail-theme/opentext-hightail-logo-262x38.png" alt="OT Hightail"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php
    wp_nav_menu( array(
        'theme_location'  => 'primary',
        'depth'	          => 2,
        'container'       => 'div',
        'container_class' => 'collapse navbar-collapse',
        'container_id'    => 'bs-example-navbar-collapse-1',
        'menu_class'      => 'navbar-nav mr-auto',
        'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
        'walker'          => new WP_Bootstrap_Navwalker(),
    ) );
    ?>
    <form class="form-inline mt-2 mt-md-0">
        <a href="#" style="color:white; text-decoration: none">SIGN IN &nbsp;</a>
        <button class="btn btn-hitail" type="submit" style="color: white; background-color: #f15b41; border-color: #f15b41;">SIGN UP</button>
    </form>
</nav>