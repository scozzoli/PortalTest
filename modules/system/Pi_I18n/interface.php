<?php
	$js = '$(document).ready(
		function(){
			$("#focusme").focus();
			shortcut("enter",function(){pi.request("data","Cerca");},{type:"keydown",propagate:false,target:"focusme"});
			pi.request(null,"LoadLogs");
		}
	);';
	
	//<button class="red" onclick="pi.request(null,\'LoadMissingModule\')"><i class="mdi mdi-pencil-off"></i> <i18n>iface:miss</i18n></button>
	$sd->includeScript($js);
	$sd->includeLib('./lib/js/simplemde.min.js');
	$sd->includeLib('./lib/Pi.Component.Markdowneditor.js');
	$interface = '<div class="panel blue" data-pic="collapse:{close:true}">
				<div class="header"><i18n>iface:infoHeader</i18n></div>
				<i18n>iface:infoDetail</i18n>
			</div>
			<div class="panel orange" id="data">
				<table class="form">
					<tr>
						<th>
							<i18n>iface:fieldSearch</i18n>
						</th>
						<td>
							<input type="text" class="full" name="cerca" id="focusme">
						</td>
						<th>
							<button class="orange" onclick="pi.request(\'data\',\'Cerca\')"><i class="mdi mdi-magnify"></i> <i18n>search</i18n></button>
						</th>
					</tr>
				</table>
				<div class="footer">
					<button class="red" onclick="pi.request(null,\'LoadLogs\')"><i class="mdi mdi-file-document"></i> <i18n>iface:log</i18n></button>
					<button class="red" onclick="pi.request(null,\'LoadDefaults\')"><i class="mdi mdi-book-open-variant"></i> <i18n>iface:default</i18n></button>
					<button class="red" onclick="pi.request(null,\'LoadCommon\')"><i class="mdi mdi-transcribe"></i> <i18n>iface:common</i18n></button>
				</div>
			</div>
			<div id="container"></div>';
?>