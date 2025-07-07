import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { ToggleControl, PanelBody, Button, Spinner } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { useDispatch } from '@wordpress/data';
import { useRef, useState, useEffect, useCallback } from '@wordpress/element';

import { fetchData } from '../api';

import metadata from './block.json';

const allKeys = [
	{ key: 'id', label: __( 'Show ID', 'nahidul-api-fetcher' ) },
	{ key: 'fname', label: __( 'Show First Name', 'nahidul-api-fetcher' ) },
	{ key: 'lname', label: __( 'Show Last Name', 'nahidul-api-fetcher' ) },
	{ key: 'email', label: __( 'Show Email', 'nahidul-api-fetcher' ) },
	{ key: 'date', label: __( 'Show Date', 'nahidul-api-fetcher' ) },
];

const Edit = ( { attributes, setAttributes } ) => {
	const { columns = [] } = attributes;

	const [loading, setLoading] = useState( false );

	const { createNotice, removeNotice } = useDispatch( 'core/notices' );
	const noticeIdRef = useRef( null );

	const loadData = useCallback( async ( refresh ) => {
		setLoading( true );

		const data = await fetchData( refresh );
		setAttributes( { data } );

		if ( refresh ) {
			if ( data ) {
				showNotice( 'success', __( 'Data refreshed successfully.', 'nahidul-api-fetcher' ) );
			} else {
				showNotice( 'error', __( 'Data refresh failed.', 'nahidul-api-fetcher' ) );
			}
		}

		setLoading( false );
	}, [] );

	/**
	 * Load data on an initial page load.
	 */
	useEffect( () => {
		loadData();
	}, [] );

	/**
	 * Show a single notice for this block.
	 *
	 * @param {string} type    - 'success' | 'error' | 'info' | 'warning'
	 * @param {string} message - The message to show
	 */
	const showNotice = ( type, message ) => {
		if ( noticeIdRef.current ) {
			removeNotice( noticeIdRef.current );
		}

		const id = `naf-block-notice-${ Date.now() }`;
		createNotice( type, message, {
			id,
			isDismissible: true,
		} );
		noticeIdRef.current = id;
	};

	const toggleColumn = ( key ) => ( checked ) => {
		let newColumns = [ ...columns ];

		if ( checked ) {
			if ( ! newColumns.includes( key ) ) {
				newColumns.push( key );
			}
		} else {
			newColumns = newColumns.filter( ( col ) => col !== key );
		}

		setAttributes( { columns: newColumns } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'nahidul-api-fetcher' ) }>
					{ allKeys.map( ( { key, label } ) => (
						<ToggleControl
							key={ key }
							label={ label }
							checked={ columns.includes( key ) }
							onChange={ toggleColumn( key ) }
						/>
					) ) }
					<Button
						variant="primary"
						onClick={ () => loadData( true ) }
						disabled={ loading }
					>
						{ loading ? <Spinner/> : __( 'Refresh', 'nahidul-api-fetcher' ) }
					</Button>
				</PanelBody>
			</InspectorControls>

			<div { ...useBlockProps() }>
				<ServerSideRender
					httpMethod="POST"
					block={ metadata.name }
					attributes={ attributes }
				/>
			</div>
		</>
	);
}

export default Edit;
