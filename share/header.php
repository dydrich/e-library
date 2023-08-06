
<header id="header" class="mdc-elevation--z2">
	<div id="sc_firstrow" style="grid-area: head_sx; display: flex; flex-direction: row; align-items: center">
		<i class="material-icons" style="font-size: 1.6em; position: relative; bottom: 2px">school</i>
		<span style="position: relative; margin-left: 5px"><?php echo $_SESSION['__config__']['software_name'].' '.$_SESSION['__config__']['software_version'] ?> - Istituto comprensivo Nivola</span>
	</div>

	<div id="head_drawer" style="grid-area: drawer; display: flex; flex-direction: row; align-items: center">
		<div id="head_label" style="width: 100%; text-align: center">
			<p id="drawer_label" style="width: 100%">Area amministrazione :: <?php echo $drawer_label ?></p>
		</div>
	</div>

	<div id="sc_secondrow" style="grid-area: head_user; display: flex; flex-direction: row; align-content: center; justify-content: center; align-items: center">
		<i id="person" class="material-icons" style="">person</i>
		<span style="margin-right: 10px; margin-left: 5px"><?php echo $user->getInitials(1, 0) ?></span>
		<div style="margin-left: 20px; width: 50px; text-align: left; padding-top: 4px">
            <a href="#" onclick="document.location.href = '../do_logout.php'">
                <i id="off" class="material-icons" style="">cloud_off</i>
            </a>
		</div>
	</div>
</header>