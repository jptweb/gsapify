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
 * Imports the useEffect React Hook. This is used to set an attribute when the
 * block is loaded in the Editor.
 *
 * @see https://react.dev/reference/react/useEffect
 */
import { useEffect } from 'react';

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
										<TextareaControl
											label={ __( 'GSAP Animation Code', 'gsapify' ) }
											help={ __( 'Add your GSAP animation code here', 'gsapify' ) }
											value={ customJs }
											onChange={(value) => setAttributes({ customJs: value })}
											rows={10}
										/>
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
