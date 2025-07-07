import apiFetch from '@wordpress/api-fetch';

const basePath = '/nahidul-api-fetcher/v1/data';

/**
 * Asynchronously fetches data from the API with an optional refresh parameter.
 *
 * @function fetchData
 * @async
 * @param {boolean} [refresh=false] - Determines whether to force a data refresh. Defaults to false.
 * @returns {Promise<any>} The response from the API if successful, or undefined if an error occurs.
 * @throws Will log an error to the console if the API request fails.
 */
export const fetchData = async ( refresh = false ) => {
	const query = new URLSearchParams();
	query.append( 'refresh', refresh ? 'true' : 'false' );

	const path = `${ basePath }?${ query.toString() }`;

	try {
		return await apiFetch( {
			path,
			method: 'GET',
		} );
	} catch ( error ) {
		console.error( 'API fetch failed:', error );
	}
};
