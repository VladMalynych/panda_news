/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.toolbar_Standard =
        [
            { name: 'document', items : [ 'NewPage','-','DocProps','Preview','Print','-','Templates','-' ] },
            { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-' ] },
            { name: 'insert', items : [ 'Image','Table','Smiley','SpecialChar'] },

            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
            { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote',
                '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-'] },
            { name: 'links', items : [ 'Link','Unlink'] },

            { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] },
            { name: 'tools', items : [ 'Maximize' ] }
        ];


    config.toolbar_Limited =
        [
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-','RemoveFormat' ] },
            { name: 'styles', items : [ 'Styles','Font','FontSize' ] },
            { name: 'colors', items : [ 'TextColor','BGColor' ] }
        ];
};
