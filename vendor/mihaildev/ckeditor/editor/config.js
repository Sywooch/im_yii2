/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.language = 'ru';
    //config.uiColor = '#AADC6E';
	
    config.filebrowserBrowseUrl = '/js/vendor/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = '/js/vendor/kcfinder/browse.php?type=images';
    //config.filebrowserFlashBrowseUrl = '/js/vendor/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = '/js/vendor/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = '/js/vendor/kcfinder/upload.php?type=images';
    //config.filebrowserFlashUploadUrl = '/js/vendor/kcfinder/upload.php?type=flash';
   
   /*  config.extraPlugins = 'youtube'; */
   
    /* config.toolbar = 'Custom'; */
    config.stylesSet = 'my_styles';
	config.protectedSource.push( /<script[\s\S]*?script>/g ); /* script tags */
	config.allowedContent = true; /* all tags */
};

CKEDITOR.stylesSet.add( 'my_styles', [
    // Block-level styles
    { name: 'Блок 100% зеленая рамка', element: 'p', attributes: { 'class': 'mark-1' } },
    { name: 'Блок 100% зеленый фон' , element: 'p', attributes: { 'class': 'mark-2' } },
	{ name: 'Блок (!) слева 55% зеленый фон' , element: 'p', attributes: { 'class': 'mark-3' } },
	{ name: 'Блок (!) справа 55% зеленый фон' , element: 'p', attributes: { 'class': 'mark-3-right' } },
	{ name: 'Блок (%) слева 55% зеленый фон' , element: 'p', attributes: { 'class': 'mark-4' } },
	{ name: 'Блок (%) справа 55% зеленый фон' , element: 'p', attributes: { 'class': 'mark-4-right' } },
	{ name: 'Блок (?) слева 55% зеленый фон' , element: 'p', attributes: { 'class': 'mark-5' } },
	{ name: 'Блок (?) справа 55% зеленый фон', element: 'p', attributes: { 'class': 'mark-5-right' } },
	{ name: 'Блок («») слева 55% зеленый фон', element: 'p', attributes: { 'class': 'mark-6' } },
	{ name: 'Блок («») справа 55% зеленый фон', element: 'p', attributes: { 'class': 'mark-6-right' } },
	{ name: 'Маркированный список (оранжевые точки)', element: 'ul', attributes: { 'class': 'list-1' } },
	{ name: 'Маркированный список (белые точки)', element: 'ul', attributes: { 'class': 'list-2' } },
	{ name: 'Нумерованный список (оранжевые цифры)', element: 'ol', attributes: { 'class': 'list-1' } },
	{ name: 'Нумерованный список (белые цифры)', element: 'ol', attributes: { 'class': 'list-2' } },
	{ name: 'Картинка на всю ширину', element: 'img', attributes: { 'class': 'img-full-width' } },
	{ name: 'Картинка слева', element: 'img', attributes: { 'class': 'img-left' } },
	{ name: 'Картинка справа', element: 'img', attributes: { 'class': 'img-right' } }
]);