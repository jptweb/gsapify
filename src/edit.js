/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Imports the InspectorControls component, which is used to wrap
 * the block's custom controls that will appear in in the Settings
 * Sidebar when the block is selected.
 *
 * Also imports the React hook that is used to mark the block wrapper
 * element. It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#inspectorcontrols
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

/**
 * Imports the necessary components that will be used to create
 * the user interface for the block's settings.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/panel/#panelbody
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/text-control/
 * @see https://developer.wordpress.org/block-editor/reference-guides/components/toggle-control/
 */
import { PanelBody, TextareaControl, TabPanel } from '@wordpress/components';

/**
 * Imports the useEffect and useState React Hooks.
 *
 * @see https://react.dev/reference/react/useEffect
 * @see https://react.dev/reference/react/useState
 */
import { useEffect, useState } from 'react';

/**
 * WordPress dependencies
 */
import apiFetch from '@wordpress/api-fetch';

import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { customHtml, customCss, customJs } = attributes;
	const blockProps = useBlockProps();
	
	// State for storing GSAP plugins and skip main setting
	const [enabledPlugins, setEnabledPlugins] = useState([]);
	const [skipMain, setSkipMain] = useState(false);
	
	// Fetch GSAP settings when component mounts
	useEffect(() => {
		// Fetch enabled plugins
		apiFetch({ path: '/wp/v2/settings' })
			.then((response) => {
				if (response.gsapify_plugins) {
					setEnabledPlugins(response.gsapify_plugins);
				}
				if (response.hasOwnProperty('gsapify_skip_main')) {
					setSkipMain(response.gsapify_skip_main);
				}
			})
			.catch((error) => {
				console.error('Error fetching GSAP settings:', error);
			});
	}, []);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'GSAP Animation Settings', 'gsapify' ) }>
					<TabPanel
						className="gsapify-tabs"
						activeClass="active-tab"
						tabs={[
							{
								name: 'html',
								title: 'HTML',
								className: 'gsapify-tab-html',
							},
							{
								name: 'css',
								title: 'CSS',
								className: 'gsapify-tab-css',
							},
							{
								name: 'js',
								title: 'JavaScript',
								className: 'gsapify-tab-js',
							},
						]}
					>
						{(tab) => {
							switch (tab.name) {
								case 'html':
									return (
										<TextareaControl
											label={ __( 'HTML Structure', 'gsapify' ) }
											help={ __( 'Add the HTML elements you want to animate', 'gsapify' ) }
											value={ customHtml }
											onChange={(value) => setAttributes({ customHtml: value })}
											rows={10}
										/>
									);
								case 'css':
									return (
										<TextareaControl
											label={ __( 'Custom CSS', 'gsapify' ) }
											help={ __( 'Add your custom styles here', 'gsapify' ) }
											value={ customCss }
											onChange={(value) => setAttributes({ customCss: value })}
											rows={10}
										/>
									);
								case 'js':
									return (
										<>
											<TextareaControl
												label={ __( 'GSAP Animation Code', 'gsapify' ) }
												help={ __( 'Add your GSAP animation code here', 'gsapify' ) }
												value={ customJs }
												onChange={(value) => setAttributes({ customJs: value })}
												rows={10}
											/>
											{!skipMain && enabledPlugins.length > 0 && (
												<div className="gsapify-enabled-plugins">
													<p className="gsapify-plugins-title"><strong>{ __( 'Enabled GSAP Plugins:', 'gsapify' ) }</strong></p>
													<ul className="gsapify-plugins-list">
														{enabledPlugins.map((plugin) => (
															<li key={plugin}>{plugin}</li>
														))}
													</ul>
													<p className="gsapify-plugins-help">{ __( 'These plugins are available to use in your GSAP code. To enable more plugins, go to Settings → GSAPify.', 'gsapify' ) }</p>
												</div>
											)}
											{skipMain && (
												<div className="gsapify-skip-main-notice">
													<p>{ __( 'Note: You\'ve chosen to skip loading the main GSAP library. Make sure GSAP is loaded via your theme or another plugin.', 'gsapify' ) }</p>
												</div>
											)}
										</>
									);
							}
						}}
					</TabPanel>
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<div className="gsapify-preview">
					<div dangerouslySetInnerHTML={{ __html: customHtml }} />
					<style>{customCss}</style>
				</div>
			</div>
		</>
	);
}
