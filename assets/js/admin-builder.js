jQuery( document ).ready( function( $ ) {

	// Function to toggle the visibility of the legal footer settings
	function toggleLegalFooterSettings() {
		var isChecked = $( '#wpforms-panel-field-settings-legal_footer_enable' ).is( ':checked' );
		if ( isChecked ) {
			$( '.wpforms-legal-footer-settings-content' ).slideDown();
		} else {
			$( '.wpforms-legal-footer-settings-content' ).slideUp();
		}
	}

	// Function to toggle Link Type fields (Custom URL vs Page Dropdown)
	function toggleLinkType( select ) {
		var targetId   = $( select ).data( 'target' ); // e.g., legal_footer_link1
		var selectedVal = $( select ).val();
		
		if ( 'page' === selectedVal ) {
			$( '#' + 'wpforms-legal-footer-' + targetId.replace('legal_footer_', '') + '-custom' ).hide();
			$( '#' + 'wpforms-legal-footer-' + targetId.replace('legal_footer_', '') + '-page' ).show();
		} else {
			$( '#' + 'wpforms-legal-footer-' + targetId.replace('legal_footer_', '') + '-page' ).hide();
			$( '#' + 'wpforms-legal-footer-' + targetId.replace('legal_footer_', '') + '-custom' ).show();
		}
	}

	// Initial check on load
	toggleLegalFooterSettings();

	// Listen for changes on Enable Toggle
	$( document ).on( 'change', '#wpforms-panel-field-settings-legal_footer_enable', function() {
		toggleLegalFooterSettings();
	} );

	// Listen for changes on Link Type Selectors
	$( document ).on( 'change', '.wpforms-legal-footer-link-type select', function() {
		toggleLinkType( this );
	} );

	// Initialize Link Types
	$( '.wpforms-legal-footer-link-type select' ).each( function() {
		toggleLinkType( this );
	} );

});
