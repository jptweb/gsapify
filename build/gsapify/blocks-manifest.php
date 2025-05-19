<?php
// This file is generated. Do not modify it manually.
return array(
	'gsapify' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/gsapify',
		'version' => '0.1.0',
		'title' => 'GSAPify Animation Block',
		'category' => 'design',
		'description' => 'A developer-friendly block for adding GSAP animations to your content.',
		'example' => array(
			
		),
		'attributes' => array(
			'customHtml' => array(
				'type' => 'string',
				'default' => '<div class=\'animated-element\'>Hello GSAP!</div>'
			),
			'customCss' => array(
				'type' => 'string',
				'default' => '.animated-element { width: 100px; height: 100px; background: #3498db; }'
			),
			'customJs' => array(
				'type' => 'string',
				'default' => 'gsap.to(\'.animated-element\', { duration: 1, x: 100, rotation: 360 });'
			)
		),
		'supports' => array(
			'html' => true,
			'color' => array(
				'background' => true,
				'text' => true
			),
			'typography' => array(
				'fontSize' => true
			)
		),
		'textdomain' => 'gsapify',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js',
		'render' => 'file:./render.php'
	)
);
