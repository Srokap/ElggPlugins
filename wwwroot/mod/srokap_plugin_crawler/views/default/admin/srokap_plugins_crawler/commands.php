<?php

$commands = array(
	'wget' => 'wget -v',
	'svn' => 'svn -v',
);

foreach ($commands as $name => $command) {
	$title = elgg_echo('srokap_framework:command:'.$name);
	$body = '<pre>'.srokap_framework::system_command($command, $return_code).'</pre>';
	echo elgg_view_module('aside', $title, $body);
}

// $batch = srokap_plugin_crawler::getPluginProjectsBatch();
// $cnt = 0;
// foreach($batch as $item) {
// 	var_dump($item->{'origin/guid'});
// 	$cnt++;
// 	if($cnt>=20) {
// 		break;
// 	}
// }