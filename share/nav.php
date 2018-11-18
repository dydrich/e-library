<nav id="navigation">
	<div id="head_label" style="display: flex; align-items: center; padding-left: 15px">
		<?php if (!isset($_GET['back'])) : ?>
        <i class="material-icons" id="open_drawer" style="float: left; font-size: 1.8em">menu</i>
        <?php else : ?>
        <a href="<?php echo $_GET['back'] ?>">
            <i class="material-icons" id="open_drawer" style="float: left; font-size: 1.8em">arrow_back</i>
        </a>
        <?php endif; ?>
		<p id="drawer_label" style="margin-left: 10px; float: left; color: white"><?php echo $drawer_label ?></p>
	</div>
	<div class="nav_div" style="text-align: center">
        <a href="">
            <i class="material-icons" style="">account_box</i>
        </a>
        <a href="../do_logout.php">
            <i class="material-icons" style="margin-left: 20px">cloud_off</i>
        </a>
    </div>
</nav>