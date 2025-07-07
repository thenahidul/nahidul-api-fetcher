/**
 * Show a WordPress-style admin notice.
 *
 * @param {string} message - The notice message.
 * @param {string} [type='success'] - The type of notice: success, error, warning, info.
 */
export function showAdminNotice( message, type = 'success' ) {
	const existingNotice = document.querySelector( '.js-naf-admin-notice' );
	if ( existingNotice ) {
		existingNotice.remove();
	}

	const notice = document.createElement( 'div' );
	notice.className = `notice notice-${ type } is-dismissible js-naf-admin-notice`;
	notice.innerHTML = `
		<p>${ message }</p>
		<button type="button" class="notice-dismiss">
			<span class="screen-reader-text">Dismiss this notice.</span>
		</button>
	`;

	const container = document.querySelector( '.wrap' ) || document.body;
	container.prepend( notice );

	notice.querySelector( '.notice-dismiss' ).addEventListener( 'click', () => {
		notice.remove();
	} );
}
