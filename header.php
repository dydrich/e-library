<header id="header" style="background-image: url('../images/library3.png')">
	<div id="sc_firstrow">
		<i class="material-icons" style="font-size: 1.6em">local_library</i>
		<span style="position: relative; bottom: 8px; margin-left: 5px"><?php echo $_SESSION['__config__']['software_name'].' '.$_SESSION['__config__']['software_version'] ?></span>
		<span style="position: relative; bottom: 8px; font-size: 0.9em; " id="soft_desc"></span>
	</div>
	<div id="sc_secondrow" style="display: flex; justify-content: right">
    <?php if(isset($_SESSION['__user__'])) { ?>    
        <div style="" class="main_menu_item">
            <a href="#">
                <i class="material-icons">person</i>
            </a>
        </div>
        <div style="" class="main_menu_item">
            <a href="admin/index.php">
                <i class="material-icons">settings</i>
            </a>
        </div>
        <div style="" class="main_menu_item">
            <a href="admin/index.php">
                <i class="material-icons">book</i>
            </a>
        </div>
        <div style="" class="main_menu_item">
            <a href="do_logout.php">
                <i class="material-icons">cloud_off</i>
            </a>
        </div> 
    <?php 
    }
    else {
    ?>    
    <div id="sr_label">Istituto comprensivo Nivola - Iglesias</div>
    <?php
    }    
    ?> 
        <div style="" class="main_menu_item">
            <a href="do_logout.php">
                <i class="material-icons">info</i>
            </a>
        </div>
	</div>
    <?php include_once "nav.php" ?>
</header>