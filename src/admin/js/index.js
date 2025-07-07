import { refreshTable } from './refreshTable';

/**
 * Initializes table refresh handlers on DOM ready.
 * Binds click event to each `.js-naf-table-refresh-handler` button,
 * which triggers an AJAX table refresh.
 */
document.addEventListener( 'DOMContentLoaded', () => {
	document.querySelectorAll( '.js-naf-table-refresh-handler' ).forEach( ( refreshBtn ) => {
		refreshBtn.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			refreshTable( refreshBtn );
		} );
	} );
} );
