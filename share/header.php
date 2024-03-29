<?php
$roles = $user->getRoles();
$icon = "person";
if(count($roles) > 0) {
	$icon = "manage_accounts";
}
?>

<header id="header" class="mdc-elevation--z2">
	<div id="sc_firstrow" style="grid-area: head_sx; display: flex; flex-direction: row; align-items: center">
		<i class="material-icons" style="font-size: 1.6em; position: relative; bottom: 2px">school</i>
		<span style="position: relative; margin-left: 5px"><?php echo $_SESSION['__config__']['software_name'].' '.$_SESSION['__config__']['software_version'] .' - '. $_SESSION['__config__']['school_name'] ?></span>
	</div>

	<div id="head_drawer" style="grid-area: drawer; display: flex; flex-direction: row; align-items: center">
		<div id="head_label" style="width: 100%; text-align: center">
			<p id="drawer_label" style="width: 100%">Area <?php if($user->getCurrentRole() == User::$ADMIN) echo "Amministrazione"; else echo "Biblioteca"; ?> :: <?php echo $drawer_label ?></p>
		</div>
	</div>

	<div id="sc_secondrow" style="grid-area: head_user; display: flex; flex-direction: row; align-content: center; justify-content: center; align-items: center">
		<div id="profile" style="display: flex; flex-direction: row; align-content: center; justify-content: center; align-items: center">
			<i id="person" class="material-icons" style="width: 30px"><?php echo $icon ?></i>
			<span style="margin-right: 50px; margin-left: 5px"><?php echo $user->getInitials(1, 0) ?></span>
		</div>	
		<div style="margin-left: 20px; width: 50px; text-align: left; padding-top: 4px">
            <a href="#" onclick="document.location.href = '../do_logout.php'">
                <i id="off" class="material-icons" style="">cloud_off</i>
            </a>
		</div>
	</div>
</header>