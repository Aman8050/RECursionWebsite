<div class="header_back" id="header">
	<div class="header row">
		<div class="header_left">
			<div id="site_name"><a href="<?= WEB_URL ?>">CodeCracker</a></div>
			<div id="site_logo" style="display:none;"><img src="<?= BASE_URL ?>/images/computer.png"/></div>
		</div>
		<div class="header_right">
			<span class="dropdown">
				<a id="header_dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
					<span>
					<?php
						echo $admin_name;
					?>
					<span class="caret"></span>
					</span>
				</a>
				<ul class="dropdown-menu" id="header_menu" aria-labelledby="header_dropdown">
					<li><a href="/settings">Settings</a></li>
					<li><a href="/changepassword">Change Password</a></li>
					<li role="separater" class="divider"></li>
					<li><a href="/logout">Logout</a></li>
					<div class="ddpointerb">
					</div>
					<div class="ddpointer">
					</div>
				</ul>
			</span>
		</div>
	</div>
</div>