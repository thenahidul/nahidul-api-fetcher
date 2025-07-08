import { showAdminNotice } from './helpers';

/**
 * Refreshes the API data table via AJAX.
 *
 * @param {HTMLElement} refreshBtn
 */
export async function refreshTable( refreshBtn ) {
	if ( ! refreshBtn ) {
		return;
	}

	const tableContainer = refreshBtn.closest( '.js-naf-table-container' );
	const spinner = tableContainer?.querySelector( '.js-naf-spinner' );

	if ( ! tableContainer || ! spinner ) {
		console.error( 'Missing table container or spinner.' );
		showAdminNotice( 'Refreshing failed.', 'error' );
		return;
	}

	const { ajax_url, ajax_action, nonce } = window.nahidulApiFetcher || {};

	if ( ! ajax_url || ! ajax_action || ! nonce ) {
		console.error( 'Missing AJAX config.' );
		showAdminNotice( 'Refreshing failed.', 'error' );
		return;
	}

	refreshBtn.disabled = true;
	spinner.classList.add( 'is-active' );
	tableContainer.classList.add( 'is-loading' );

	try {
		const formData = new FormData();
		formData.append( 'action', ajax_action );
		formData.append( 'nonce', nonce );

		const response = await fetch( ajax_url, {
			method: 'POST',
			body: formData,
			credentials: 'same-origin',
		} );

		if ( ! response.ok ) {
			console.error( `HTTP error! status: ${ response.status }` );
			showAdminNotice( 'Refreshing failed.', 'error' );
			return;
		}

		const json = await response.json();

		if ( json.success && json.data?.html ) {
			tableContainer.innerHTML = json.data.html;
			showAdminNotice( 'Successfully refreshed.' );
		} else {
			console.error( 'WordPress Error:', json.data );
			showAdminNotice( 'Refreshing failed.', 'error' );
		}
	} catch ( error ) {
		console.error( 'AJAX fetch failed:', error );
		showAdminNotice( 'Refreshing failed.', 'error' );
	} finally {
		refreshBtn.disabled = false;
		spinner.classList.remove( 'is-active' );
		tableContainer.classList.remove( 'is-loading' );
	}
}
