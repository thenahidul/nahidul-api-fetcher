import { refreshTable } from './refreshTable';

/**
 * Initializes table refresh handlers on DOM ready.
 * Binds click event to each `.js-naf-table-refresh-handler` button,
 * which triggers an AJAX table refresh.
 */
document.addEventListener( 'DOMContentLoaded', () => {
	const refreshBtns = document.querySelectorAll( '.js-naf-table-refresh-handler' );
	if ( refreshBtns.length ) {
		refreshBtns.forEach( ( refreshBtn ) => {
			refreshBtn.addEventListener( 'click', ( e ) => {
				e.preventDefault();
				refreshTable( refreshBtn );
			} );
		} );
	}
} );
