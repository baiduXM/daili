/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'Editor';
	
	config.toolbar_Editor = 
	[
	    ['Cut','Copy','Paste','PasteFromWord','-','SpellChecker'],
	    ['Undo','Redo','-','Find','Replace'],
	    ['NumberedList','BulletedList','Outdent','Indent','Blockquote','RemoveFormat'],
	    ['Link','Unlink'],
	    ['xpic','Image','Table','HorizontalRule','SpecialChar'],
	    '/',
	    ['Bold','Italic','StrikeThrough','-','Subscript','Superscript'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Format','FontSize'],
	    ['FitWindow','ShowBlocks']
	];
	config.extraPlugins = "xpic";
};
