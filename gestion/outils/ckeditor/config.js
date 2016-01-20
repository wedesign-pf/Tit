/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'fr';
	config.skin = 'moono';
	// config.uiColor = '#AADC6E';
config.extraPlugins = 'lineutils';
config.extraPlugins = 'placeholder';
	config.toolbar_Default = [
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','Find','Replace'],
		['Image','Table','-','Link','Unlink', 'Anchor'],
		['Bold','Italic','Underline','Strike','Subscript','Superscript', '-', 'RemoveFormat'],
		['NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Styles','Font','FontSize','-','TextColor','BGColor','-','Smiley','SpecialChar'],
		['Templates','CreateDiv','Maximize', 'ShowBlocks','-','Source','-','About']
	] ;
	
	config.toolbar_Basic = [
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript','-','NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink'],
		['Styles','-','Image','SpecialChar','Source'],
	] ;

	config.toolbar_Simple = [
		['Bold','Italic','Underline','Strike','-','BulletedList','-','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Link','Unlink','-','Image','SpecialChar','Source'],
	] ;
	
	config.toolbar_Image = [
		['Image','Source']
	] ;

};
