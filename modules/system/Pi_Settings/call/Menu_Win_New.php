<?php
	$out='<div class="red focus">
			<i18n>menu:win:infoNew</i18n>
		</div>
		<div id="new_menu">
			<table class="form separate">
				<tr>
					<th><i18n>menu:iface:menuName</i18n></th>
					<td>
						<input type="hidden" name="Q" value="Menu_New">
						<input type="text" class="std" name="nome" value="" id="focusme">
					</td>
				</tr>
				
			</table>
		</div>';
		$footer = '<button class="red" onclick="pi.win.close()"><i18n>cancel</i18n></button>
		<button class="green" onclick="pi.requestOnModal(\'new_menu\')"> <i18n>save</i18n> </button>';
	$pr->addWindow(400,0,'<i18n>menu:win:newMenuTitle</i18n>',$out,$footer)->addScript("$('#focusme').focus();")->response();
?>