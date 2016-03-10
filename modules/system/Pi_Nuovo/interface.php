<?php
	$js = '$(document).ready(
		function(){
			$("#focusme").focus();
			shortcut("enter",function(){pi.request("data");},{type:"keydown",propagate:false,target:"focusme"});
		}
	);';
	$sd->includeScript($js);
	$interface = '<div class="panel blue">
			</div>
			<div class="panel orange" id="data">
				
			</div>
			<div id="container"></div>';
?>