{* http://www.tinymce.com/wiki.php/Configuration:style_formats *}
{* http://www.tinymce.com/wiki.php/Configuration:formats *}
style_formats: [

        { title: 'Titre H1', block: 'h1'},
        { title: 'Titre H2', block: 'h2'},
        { title: 'Titre H3', block: 'h3'},
        { title: 'Titre H4', block: 'h4'},
        { title: 'Titre H5', block: 'h5'},
        

        { title: 'Images', items: [
            { title: 'image à gauche', selector: 'img', classes: 'left'},
			{ title: 'image à droite', selector: 'img', classes: 'right'}
        ]},

		 { title: 'hightlight', inline: 'span', classes: 'hightlight'},

    ],