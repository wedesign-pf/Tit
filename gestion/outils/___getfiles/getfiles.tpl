<link rel="stylesheet" href="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/cropper.css">
<link rel="stylesheet" href="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/filedrop.css">
<link rel="stylesheet" href="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/getfile.css">
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/cropper.min.js"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/jquery.cssloader.min.js"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/mdetect.min.js"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/filedrop.min.js"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}getfiles/jquery.getfile.js"></script>


       <script type="text/javascript">
            $(document).ready(function()
            {

                $('#imageLoaded').getFile(
                    {
                        urlPlugin:          '.',
                        folder:             '/main-files/public',
                        tmpFolder:          '/main-files/tmp',
                        multiple:           true,
                        spinner: false,
                        filename:"toto",
                        resize:{
                            active:	                false,
                            width:	                300,
                            height:                 200,
                            constrainProportions:	true
                        },
                        copies: [
                            {
                                width:                  100,
                                height:                 100,
                                constrainProportions:   true,
                                prefix:                 '@2x',
                                folder:                 '/main-files/public'
                            },
                            {
                                width:                  50,
                                height:                 40,
                                prefix:                 '@1x',
                                folder:                 '/main-files/public'
                            }
                        ]
                    },
                    function(data)
                    {
                        if(data.success && data.action == "loading")
                        {
                            $('#progressBar').html(data.percentage + '%');
                            $('#progressBar').attr('aria-valuenow', data.percentage);
                            $('#progressBar').css('width', data.percentage + '%');
                        }
                        else
                        {
                            
                            $('#response00').html(data.files[0].name); //data.error data.message data.success
                             $('#response01').html(syntaxHighlight(JSON.stringify(data, null, "\t")));
                            if(data.success)
                            {
                                $.each(data.files, function(index, value) {
                                    if(value.success)
                                    {
                                        
                                        $.data(document, value.name, '#imageLoaded04');

                                        if (value.copies != undefined) {
                                            $.each(value.copies, function (index, value2) {
                                                if (value2.success) {
                                                    $.data(document, value2.name, '#imageLoaded04');
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        }
                    }
                );
            });

            
           function syntaxHighlight(json)
            {
                if (typeof json != 'string') {
                    json = JSON.stringify(json, undefined, 2);
                }
                json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                    var cls = 'number';
                    if (/^"/.test(match)) {
                        if (/:$/.test(match)) {
                            cls = 'key';
                        } else {
                            cls = 'string';
                        }
                    } else if (/true|false/.test(match)) {
                        cls = 'boolean';
                    } else if (/null/.test(match)) {
                        cls = 'null';
                    }
                    return '<span class="' + cls + '">' + match + '</span>';
                });
            }
        </script>
<div id="imageLoaded" class="drop-zone">
    <div class="text-drop-zone">
        Glisse tes fichiers ici ou click dessus pour les rechercher
    </div>
</div>
<div class="progress">
    <div id="progressBar" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<pre id="response00">00</pre>
<pre id="response01">01</pre>
