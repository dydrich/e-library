<nav id="navigation-with-mdtabs">
	<div style="grid-area: nav_sx"></div>
    <div id="tabs_space" style="grid-area: nav_tabs">
        <div class="mdtabs" style="width: 80%; text-align: center; margin: auto; height: 100%">
            <div class="mdtab <?php if (!isset($_GET['active'])) echo "mdselected_tab" ?>">
                <a href="<?php echo $nav_link ?>"><span>Tutt<?php echo $nav_final_letter ?></span></a>
            </div>
            <div class="mdtab <?php if ((isset($_GET['active']) && $_GET['active'] == 1)) echo "mdselected_tab" ?>">
                <a href="<?php echo $nav_link ?>?active=1"><span>Attiv<?php echo $nav_final_letter ?></span></a>
            </div>
            <div class="mdtab <?php if (isset($_GET['active']) && $_GET['active'] == 0) echo "mdselected_tab" ?>">
                <a href="<?php echo $nav_link ?>?active=0"><span>Non attiv<?php echo $nav_final_letter ?></span></a>
            </div>
        </div>
    </div>
    <div style="grid-area: nav_void"></div>
</nav>