// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
    onCtrlEnter: {
        keepDefault: false,
        replaceWith: '<br />\n'
    },
    onShiftEnter: {
        keepDefault: false,
        openWith: '\n<p>',
        closeWith: '</p>\n'
    },
    onTab: {
        keepDefault: false,
        openWith: '    '
    },
    markupSet: [
        {
            name: 'Paragraph',
            text: '<i class="fa fa-paragraph"></i>',
            openWith: '<p(!( class="[![Class]!]")!)>',
            closeWith: '</p>'
        },
        {
            name: 'Break',
            text: '<i class="fa fa-arrow-circle-down"></i>',
            replaceWith: '<br />'
        },
        {
            separator: '---------------'
        },
        {
            name: 'Heading 3',
            text: '<i class="fa fa-header"></i><small>3</small>',
            key: '3',
            openWith: '<h3(!( class="[![Class]!]")!)>',
            closeWith: '</h3>',
            placeHolder: 'Your title here...'
        },
        {
            name: 'Heading 4',
            text: '<i class="fa fa-header"></i><small>4</small>',
            key: '4',
            openWith: '<h4(!( class="[![Class]!]")!)>',
            closeWith: '</h4>',
            placeHolder: 'Your title here...'
        },
        {
            name: 'Heading 5',
            text: '<i class="fa fa-header"></i><small>5</small>',
            key: '5',
            openWith: '<h5(!( class="[![Class]!]")!)>',
            closeWith: '</h5>',
            placeHolder: 'Your title here...'
        },
        {
            name: 'Heading 6',
            text: '<i class="fa fa-header"></i><small>6</small>',
            key: '6',
            openWith: '<h6(!( class="[![Class]!]")!)>',
            closeWith: '</h6>',
            placeHolder: 'Your title here...'
        },
        {
            separator: '---------------'
        },
        {
            name: 'Bold',
            text: '<i class="fa fa-bold"></i>',
            key: 'B',
            openWith: '(!(<strong>|!|<b>)!)',
            closeWith: '(!(</strong>|!|</b>)!)'
        },
        {
            name: 'Italic',
            text: '<i class="fa fa-italic"></i>',
            key: 'I',
            openWith: '(!(<em>|!|<i>)!)',
            closeWith: '(!(</em>|!|</i>)!)'
        },
        {
            name: 'Underline',
            text: '<i class="fa fa-underline"></i>',
            key: 'U',
            openWith: '<u>',
            closeWith: '</u>'
        },
        {
            name: 'Stroke through',
            text: '<i class="fa fa-strikethrough"></i>',
            key: 'R',
            openWith: '<del>',
            closeWith: '</del>'
        },
        {
            name: 'Highlight',
            text: '<i class="fa fa-lightbulb-o"></i>',
            key: 'M',
            openWith: '<mark>',
            closeWith: '</mark>'
        },
        {
            name: 'Small Text',
            text: '<i class="fa fa-text-height"></i>',
            key: 'SM',
            openWith: '<small>',
            closeWith: '</small>'
        },
        {
            name: 'Subscript',
            text: '<i class="fa fa-subscript"></i>',
            key: 'D',
            openWith: '<sub>',
            closeWith: '</sub>'
        },
        {
            name: 'Superscript',
            text: '<i class="fa fa-superscript"></i>',
            key: 'T',
            openWith: '<sup>',
            closeWith: '</sup>'
        },
        {
            name: 'Blockquote',
            text: '<i class="fa fa-quote-left"></i>',
            key: 'Q',
            openWith: '<blockquote><p>',
            closeWith: '</p></blockquote>'
        },
        {
            name: 'Text classes',
            text: '<i class="fa fa-pencil"></i>',
            replaceWith: 'class="[![Class]!]"',
            dropMenu: [
                // {
                //     name: 'Align left',
                //     text: 'Align left',
                //     replaceWith: 'class="text-left"'
                // },
                // {
                //     name: 'Align right',
                //     text: 'Align right',
                //     replaceWith: 'class="text-right"'
                // },
                // {
                //     name: 'Align center',
                //     text: 'Align center',
                //     replaceWith: 'class="text-center"'
                // },
                // {
                //     name: 'Align justify',
                //     text: 'Align justify',
                //     replaceWith: 'class="text-justify"'
                // },
                // {
                //     name: 'No wrap text',
                //     text: 'No wrap text',
                //     replaceWith: 'class="text-nowrap"'
                // },
                // {
                //     name: 'Text muted',
                //     text: 'Text muted',
                //     replaceWith: 'class="text-muted"'
                // },
                // {
                //     name: 'Text primary',
                //     text: 'Text primary',
                //     replaceWith: 'class="text-primary"'
                // },
                // {
                //     name: 'Text success',
                //     text: 'Text success',
                //     replaceWith: 'class="text-success"'
                // },
                // {
                //     name: 'Text info',
                //     text: 'Text info',
                //     replaceWith: 'class="text-info"'
                // },
                // {
                //     name: 'Text warning',
                //     text: 'Text warning',
                //     replaceWith: 'class="text-warning"'
                // },
                // {
                //     name: 'Text danger',
                //     text: 'Text danger',
                //     replaceWith: 'class="text-danger"'
                // },
                // {
                //     name: 'Background primary',
                //     text: 'Background primary',
                //     replaceWith: 'class="bg-primary"'
                // },
                // {
                //     name: 'Background success',
                //     text: 'Background success',
                //     replaceWith: 'class="bg-success"'
                // },
                // {
                //     name: 'Background info',
                //     text: 'Background info',
                //     replaceWith: 'class="bg-info"'
                // },
                // {
                //     name: 'Background warning',
                //     text: 'Background warning',
                //     replaceWith: 'class="bg-warning"'
                // },
                // {
                //     name: 'Background danger',
                //     text: 'Background danger',
                //     replaceWith: 'class="bg-danger"'
                // },
                {
                    name: 'Intro PlanetaInteligente',
                    text: 'Intro PlanetaInteligente',
                    replaceWith: '<div class="row">\n\t<div class="col-40 photo-main">\n\t\t<figure class="hey hey2" style="opacity: 1;">\n\t\t\tIMG\n\t\t\t<figcaption>PIE DE FOTO</figcaption>\n\t\t</figure>\n\t\t<blockquote class="featured-sm hey hey2" style="opacity: 1;">DESTACADO</blockquote>\n\t</div>\n\t<div class="col-50">\n\t\tTEXTO\n\t</div>\n</div>'
                }
            ]
        },
        {
            name: 'Image classes',
            text: '<i class="fa fa-image"></i>',
            replaceWith: 'class="[![Class]!]"',
            dropMenu: [
                {
                    name: 'Float left',
                    text: 'Float left',
                    replaceWith: 'class="pull-left"'
                },
                {
                    name: 'Float right',
                    text: 'Float right',
                    replaceWith: 'class="pull-right"'
                },
                {
                    name: 'Image rounded',
                    text: 'Image rounded',
                    replaceWith: 'class="img-rounded"'
                },
                {
                    name: 'Image circle',
                    text: 'Image circle',
                    replaceWith: 'class="img-circle"'
                },
                {
                    name: 'Image thumb',
                    text: 'Image thumb',
                    replaceWith: 'class="img-thumbnail"'
                }
            ]
        },
        {
            name: 'Button classes',
            text: '<i class="fa fa-crosshairs"></i>',
            replaceWith: 'class="[![Class]!]"',
            dropMenu: [
                {
                    name: 'Button defautl',
                    text: 'Button defautl',
                    replaceWith: 'class="btn btn-default"'
                },
                {
                    name: 'Button primary',
                    text: 'Button primary',
                    replaceWith: 'class="btn btn-primary"'
                },
                {
                    name: 'Button success',
                    text: 'Button success',
                    replaceWith: 'class="btn btn-success"'
                },
                {
                    name: 'Button info',
                    text: 'Button info',
                    replaceWith: 'class="btn btn-info"'
                },
                {
                    name: 'Button warning',
                    text: 'Button warning',
                    replaceWith: 'class="btn btn-warning"'
                },
                {
                    name: 'Button danger',
                    text: 'Button danger',
                    replaceWith: 'class="btn btn-danger"'
                },
                {
                    name: 'Button link',
                    text: 'Button link',
                    replaceWith: 'class="btn btn-link"'
                }
            ]
        },
        {
            separator: '---------------'
        },
        {
            name: 'Ul',
            text: '<i class="fa fa-list-ul"></i>',
            openWith: '<ul>\n',
            closeWith: '</ul>\n'
        },
        {
            name: 'Ol',
            text: '<i class="fa fa-list-ol"></i>',
            openWith: '<ol>\n',
            closeWith: '</ol>\n'
        },
        {
            name: 'Li',
            text: '<i class="fa fa-list-alt"></i>',
            openWith: '<li>',
            closeWith: '</li>'
        },
        {
            separator: '---------------'
        },
        {
            name: 'Picture',
            text: '<i class="fa fa-file-image-o"></i>',
            key: 'P',
            replaceWith: '<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />'
        },
        {
            name: 'Upload Image',
            text: '<i class="fa fa-file-image-o"></i><small>+</small>',
            key: 'J',
            beforeInsert: function(markItUp) {
                InlineUpload.image(markItUp);
            }
        },
        {
            name: 'Link',
            text: '<i class="fa fa-link"></i>',
            key: 'F',
            beforeInsert: function(markItUp) {
                InlineUpload.link(markItUp);
            }
        },
        {
            name: 'Upload File',
            text: '<i class="fa fa-link"></i><small>+</small>',
            key: 'F',
            beforeInsert: function(markItUp) {
                InlineUpload.file(markItUp);
            }
        },
        {
            separator: '---------------'
        },
        {
            name: 'Preview',
            text: '<i class="fa fa-code"></i>',
            className: 'preview',
            call: 'preview'
        }
    ]
};
