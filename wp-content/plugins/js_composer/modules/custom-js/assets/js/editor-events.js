[ 'wpbAceEditorContentChanged', 'wpbPageSettingRoleBack' ].forEach( function ( eventName ) {
	document.addEventListener( eventName, function ( event ) {
		if ( !vc.frame_window ) {
			return;
		}

		if ( event.detail.wpb_js_header_editor ) {
			var currentValue = event.detail.wpb_js_header_editor.currentValue;
			vc.frame_window.vc_iframe.loadCustomJsHeader( currentValue );
		}

		if ( event.detail.wpb_js_footer_editor ) {
			var currentValue = event.detail.wpb_js_footer_editor.currentValue;
			vc.frame_window.vc_iframe.loadCustomJsFooter( currentValue );
		}
	});
});
