( function ( window ) {
	'use strict';
	if ( ! window.vc ) {
		window.vc = {};
	}
	window.vc.utils = {
		fixUnclosedTags: function ( string ) {
			// Replace opening < and closing </ with respective entities to avoid editor breaking
			return string
				.replace( /<\/([^>]+)$/g, '&#60;/$1' ) // Replace closing </
				.replace( /<([^>]+)?$/g, '&#60;$1' ); // Replace opening < or lone <
		},
		fallbackCopyTextToClipboard: function ( text ) {
			var textArea = document.createElement( 'textarea' );
			textArea.value = text;
			// Avoid scrolling to bottom
			textArea.style.top = '0';
			textArea.style.left = '0';
			textArea.style.position = 'fixed';
			document.body.appendChild( textArea );
			textArea.focus();
			textArea.select();
			try {
				document.execCommand( 'copy' );
			} catch ( err ) {
				console.error( 'Unable to copy', err );
			}
			document.body.removeChild( textArea );
		},
		copyTextToClipboard: function ( text ) {
			if ( !navigator.clipboard ) {
				this.fallbackCopyTextToClipboard( text );
				return;
			}
			navigator.clipboard.writeText( text );
		}
	};
})( window );
