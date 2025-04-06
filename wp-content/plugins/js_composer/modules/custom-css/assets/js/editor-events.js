[ 'wpbAceEditorContentChanged', 'wpbPageSettingRoleBack' ].forEach( function ( eventName ) {
	document.addEventListener( eventName, function ( event ) {
		if ( !event.detail.wpb_css_editor ) {
			return;
		}

		var currentValue = event.detail.wpb_css_editor.currentValue;
		if ( vc.frame_window ) {
			vc.frame_window.vc_iframe.loadCustomCss( currentValue );
		}
	});
});
