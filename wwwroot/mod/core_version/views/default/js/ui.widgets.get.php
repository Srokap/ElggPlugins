<?php if (false) {?><script type="text/javascript"><?php };?>
elgg.provide('elgg.ui.widgets');

elgg.ui.widgets.init_get = function() {
	$('a.elgg-widget-refresh').live('click', elgg.ui.widgets.refresh);
};

/**
 * Refresh a widget
 *
 * Uses Ajax to get the HTML.
 *
 * @param {Object} event
 * @return void
 */
elgg.ui.widgets.refresh = function(event) {
	var $widgetContent = $(this).parents('.elgg-widget-content').first();

	// stick the ajax loader in there
	var $loader = $('#elgg-widget-loader').clone();
	$loader.attr('id', '#elgg-widget-active-loader');
	$loader.removeClass('hidden');
	$widgetContent.html($loader);

	var params = elgg.parse_url($(this).attr('href'), 'query', true) || {};
	params.guid = $widgetContent.attr('id').split('-').pop();
	
	elgg.action('widgets/get', {
		data: params,
		success: function(json) {
			$widgetContent.html(json.output);
		}
	});
	event.preventDefault();
};

elgg.register_hook_handler('init', 'system', elgg.ui.widgets.init_get);
