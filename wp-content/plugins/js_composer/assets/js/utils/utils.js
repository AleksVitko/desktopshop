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
		},
		copyTextToClipboard: function ( text ) {
			if ( !navigator.clipboard ) {
				this.fallbackCopyTextToClipboard.call( this, text );
				return;
			}
			navigator.clipboard.writeText( text );
		},
		slugify: function ( string ) {
			string = string || '';
			return string.toString().toLowerCase()
				.replace( /[^a-z0-9\s-]/g, ' ' ) // Remove all non-alphanumeric characters except spaces and hyphens
				.replace( /[\s_-]+/g, '-' ) // Replace spaces, underscores, and multiple hyphens with a single hyphen
				.replace( /^-+|-+$/g, '' ); // Trim leading and trailing hyphens
		},
		stripHtmlTags: function ( string ) {
			return string.replace( /(<([^>]+)>)/ig, '' );
		}
	};
})( window );
