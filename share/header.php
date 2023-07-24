<div id="page" class="page">
<header id="header">
	<div id="sc_firstrow">
		<i class="material-icons" style="font-size: 1.6em; position: relative; bottom: 2px">school</i>
		<span style="position: relative; bottom: 10px; margin-left: 5px"><?php echo $_SESSION['__config__']['software_name'].' '.$_SESSION['__config__']['software_version'] ?> - Istituto comprensivo Nivola</span>
	</div>
	<div id="sc_secondrow">
		<i class="material-icons" style="position: relative; top: 1px">person</i>
		<span style="position: relative; margin-left: 5px; bottom: 5px">
            <a href="#" onclick="document.location.href = '../do_logout.php'">
                <?php echo $user->getFullName() ?>
                <i id="arrow" class="material-icons" style="position: relative; top: 8px; left: 5px">cloud_off</i>
            </a>
		</span>
	</div>
</header>