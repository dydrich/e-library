<nav id="navigation-with-mdtabs" style="">
	<div id="head_label" class="with-mdtabs" style="">
        
    <?php if (!isset($_GET['back'])) : ?>
        <i class="material-icons" id="open_drawer" style="font-size: 1.8em">menu</i>
        <?php else : ?>
        <a href="<?php echo $_GET['back'] ?>">
            <i class="material-icons" id="open_drawer" style="float: left; font-size: 1.8em">arrow_back</i>
        </a>
        <?php endif; ?>
		<p id="drawer_label" style="margin-left: 10px; float: left; color: white; width: 70%; text-align: left"><?php echo $drawer_label ?></p>
     
        <div class="nav_div" style="text-align: left; font-weight: normal">
            <span style="position: relative; top: 5px">Area amministrazione</span>
        </div>
	</div>
    <div class="mdtabs" style="grid-row: 2; grid-column: 1/2; top: 0">
        <div class="mdtab <?php if (!isset($_GET['active'])) echo "mdselected_tab" ?>">
            <a href="users.php"><span>Tutti</span></a>
        </div>
        <div class="mdtab <?php if ((isset($_GET['active']) && $_GET['active'] == 1)) echo "mdselected_tab" ?>">
            <a href="users.php?active=1"><span>Attivi</span></a>
        </div>
        <div class="mdtab <?php if (isset($_GET['active']) && $_GET['active'] == 0) echo "mdselected_tab" ?>">
            <a href="users.php?active=0"><span>Non attivi</span></a>
        </div>
    </div>
</nav>