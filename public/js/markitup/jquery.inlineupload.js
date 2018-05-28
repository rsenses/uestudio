var InlineUpload = {
    dialog: null,
    block: '',
    offset: {},
    options: {
        container_class: 'markItUpInlineUpload',
        form_id: 'inline_upload_form',
        action: '/files/upload',
        inputs: {
            alt: {
                label: 'Alt text',
                id: 'inline_upload_alt',
                name: 'inline_upload_alt'
            },
            rel: {
                label: 'Target',
                id: 'inline_upload_rel',
                name: 'inline_upload_rel'
            },
            file: {
                label: 'File',
                id: 'inline_upload_file',
                name: 'inline_upload_file'
            }
        },
        submit: {
            id: 'inline_upload_submit',
            value: 'upload'
        },
        close: 'inline_upload_close',
        iframe: 'inline_upload_iframe'
    },
    image: function(hash) {
        var self = this;
        this.offset = $(hash.textarea)
            .prev('.markItUpHeader')
            .offset();
        this.webname = $('#web').val();
        this.dialog = $(
            [
                '<div class="',
                this.options.container_class,
                '"><div><form id="',
                this.options.form_id,
                '" action="',
                this.options.action,
                '" target="',
                this.options.iframe,
                '" method="post" enctype="multipart/form-data"><input type="hidden" name="webname" class="markitup-webname" value="',
                this.webname,
                '"><div class="form-group"><label class="control-label" for="',
                this.options.inputs.alt.id,
                '">',
                this.options.inputs.alt.label,
                '</label><input name="',
                this.options.inputs.alt.name,
                '" id="',
                this.options.inputs.alt.id,
                '" type="text" class="form-control"></div><div class="form-group"><label class="control-label" for="',
                this.options.inputs.file.id,
                '">',
                this.options.inputs.file.label,
                '</label><input name="',
                this.options.inputs.file.name,
                '" id="',
                this.options.inputs.file.id,
                '" type="file"></div><div class="form-group"><input id="',
                this.options.submit.id,
                '" type="button" class="btn btn-info btn-block" value="',
                this.options.submit.value,
                '"></div></form><div id="',
                this.options.close,
                '"><i class="fa fa-times"></i></div><iframe id="',
                this.options.iframe,
                '" name="',
                this.options.iframe,
                '" src="about:blank"></iframe></div></div>'
            ].join('')
        )
            .appendTo(document.body)
            .hide()
            .css('top', this.offset.top)
            .css('left', this.offset.left);
        $('#' + this.options.submit.id).click(function() {
            if ($('#inline_upload_file1').val() == '') {
                alert('Please select a file to upload');
                return false;
            }
            upload = true;
            $('#' + self.options.form_id)
                .submit()
                .fadeTo('fast', 0.2);
        });
        $('#' + this.options.close).click(this.cleanUp);
        $('#' + this.options.iframe).bind('load', function() {
            var result = document.getElementById('' + self.options.iframe)
                .contentWindow.document.body.innerHTML;
            console.log(result);
            if (result !== '') {
                var response = jQuery.parseJSON(
                    result.replace(/<(?:.|\n)*?>/gm, '')
                );
                if (response.status == 'success') {
                    this.block = [
                        '<img src="',
                        response.src,
                        '" alt="',
                        $('#' + self.options.inputs.alt.id).val(),
                        '">'
                    ];
                    self.cleanUp();
                    $.markItUp({
                        replaceWith: this.block.join('')
                    });
                } else {
                    console.log(response.msg);
                    self.cleanUp();
                }
            }
        });
        this.dialog.fadeIn('slow');
    },
    file: function(hash) {
        var self = this;
        this.offset = $(hash.textarea)
            .prev('.markItUpHeader')
            .offset();
        this.webname = $('#web').val();
        this.dialog = $(
            [
                '<div class="',
                this.options.container_class,
                '"><div><form id="',
                this.options.form_id,
                '" action="',
                this.options.action,
                '" target="',
                this.options.iframe,
                '" method="post" enctype="multipart/form-data"><input type="hidden" name="webname" class="markitup-webname" value="',
                this.webname,
                '"><div class="form-group"><label class="control-label" for="',
                this.options.inputs.rel.id,
                '">',
                this.options.inputs.rel.label,
                '</label><input name="',
                this.options.inputs.rel.name,
                '" id="',
                this.options.inputs.rel.id,
                '" type="text" class="form-control"></div><div class="form-group"><label class="control-label" for="',
                this.options.inputs.file.id,
                '">',
                this.options.inputs.file.label,
                '</label><input name="',
                this.options.inputs.file.name,
                '" id="',
                this.options.inputs.file.id,
                '" type="file"></div><div class="form-group"><input id="',
                this.options.submit.id,
                '" type="button" class="btn btn-info btn-block" value="',
                this.options.submit.value,
                '"></div></form><div id="',
                this.options.close,
                '"></div><iframe id="',
                this.options.iframe,
                '" name="',
                this.options.iframe,
                '" src="about:blank"></iframe></div></div>'
            ].join('')
        )
            .appendTo(document.body)
            .hide()
            .css('top', this.offset.top)
            .css('left', this.offset.left);
        $('#' + this.options.submit.id).click(function() {
            if ($('#inline_upload_file1').val() == '') {
                alert('Please select a file to upload');
                return false;
            }
            upload = true;
            $('#' + self.options.form_id)
                .submit()
                .fadeTo('fast', 0.2);
        });
        $('#' + this.options.close).click(this.cleanUp);
        $('#' + this.options.iframe).bind('load', function() {
            var result = document.getElementById('' + self.options.iframe)
                .contentWindow.document.body.innerHTML;
            if (result !== '') {
                var response = jQuery.parseJSON(
                    result.replace(/<(?:.|\n)*?>/gm, '')
                );
                if (response.status == 'success') {
                    this.block = [
                        '<a href="',
                        response.src,
                        '" target="',
                        $('#' + self.options.inputs.rel.id).val(),
                        '">',
                        hash.selection,
                        '</a>'
                    ];
                    self.cleanUp();
                    $.markItUp({
                        replaceWith: this.block.join('')
                    });
                } else {
                    console.log('error');
                    console.log(response.msg);
                    self.cleanUp();
                }
            }
        });
        this.dialog.fadeIn('slow');
    },
    cleanUp: function() {
        InlineUpload.dialog.fadeOut().remove();
    }
};
