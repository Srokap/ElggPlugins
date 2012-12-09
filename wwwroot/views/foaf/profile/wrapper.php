<?php
if (!$owner = elgg_get_page_owner_entity()) {
	if (!elgg_is_logged_in()) {
		exit;
	} else {
		$owner = elgg_get_logged_in_user_entity();
	}
}
echo elgg_view_entity($owner);