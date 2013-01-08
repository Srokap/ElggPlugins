<?php

$english = array(
	'IOException:UnknownVersion' => "Unable to fetch newset Elgg version information! Make sure that you have curl extension loaded or alow url fopen PHP setting enabled.",
	'admin:widget:version' => 'Version',
	'admin:widget:version:help' => 'Shows results of check if current core version is up to date',
	'admin:widget:version:current' => 'Installed Elgg version: <strong>%s</strong>',
	'admin:widget:version:newer_found' => 'New Elgg version found: ',
	'admin:widget:version:status:ok' => 'Up to date',
	'admin:widget:version:status:bad' => 'Outdated',
	'admin:widget:version:last_checked' => 'Last checked: %s',
	'admin:widget:version:check' => 'Check now',
	'admin:version:local_release' => 'Installed Elgg release',
	'admin:version:latest_release' => 'Newest release',
	'admin:version:last_checked' => 'Last checked',
	'admin:version:status' => 'Status',
	'admin:version:download' => 'Download Elgg %s',
);

add_translation("en",$english);
