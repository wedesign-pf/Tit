<link rel="stylesheet" href="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}uploadifive/uploadifive.css">
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}uploadifive/jquery.uploadifive.js"></script>
<style>
#queue {
	border: 3px solid #E5E5E5;
	height: 100px;
	overflow: auto;
	margin-bottom: 10px;
	padding: 0 3px 3px;
	width: 100%;
    text-align:center;
    vertical-align:middle;
    display:table;
    background-color:#EFEFEF;
}


#queue h5{
	height: 100%;
	width: 100%;
    text-align:center;
    vertical-align:middle;
    display: table-cell;
}

#uploadComplete {
       display:table;

}

.fileUploaded {
    background-color: #F5F5F5;
	border-bottom: 1px dotted #D5D5D5;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	font: 12px Arial, Helvetica, Sans-serif;
    display:table-row;
}


.fileUploaded .fic,
.fileUploaded .ok,
.fileUploaded .ko {
    display:table-cell;
    height:20px;
    line-height:20px;
    padding: 5px 15px;
    border-bottom: 1px dotted #D5D5D5;
}

.fileUploaded .fic {
    border-right: 1px dotted #D5D5D5;
}

.fileUploaded .ok {
    color:green;
}

.fileUploaded .ko {
    color:red;
}

.someClass {
    display:none;   
}

.uploadifive-button {
    margin-top:10px;
    margin-bottom:10px;
}
</style>
<div id="queue" class="droptarget" ondragenter="dragEnter(event)" ondragleave="dragLeave(event)" ondragover="allowDrop(event)" ondrop="drop(event)"><h5><br>Glissez-déposez un fichier ici ou cliquez</h5></div>
<input id="file_upload" name="file_upload" type="file" multiple>
<div id="uploadComplete" class="mts pas" ></div>

<script type="text/javascript" >
var textDrop=$("#queue").html();

function dragStart(event) {
    event.dataTransfer.setData("Text", event.target.id);
}

function dragEnter(event) {
   // $("#queue").html("");
    event.target.style.border = "3px dotted green";
}

function dragLeave(event) {
     event.target.style.border = "";
     $("#queue").html(textDrop);
}

function allowDrop(event) {
    event.preventDefault();

}

function drop(event) {
    event.preventDefault();
    $("#queue").html("");
}

$(function() {
    
    var erreursUpload=1;
    
    $('#file_upload').uploadifive({
				'auto'             : true,
                'simUploadLimit' : 3,
                {if $upload_prop.multi=="1" }
                'multi'       : false,
                {/if}
                'queueSizeLimit': {$upload_prop.multi},
                'removeCompleted' : true,
                'buttonText'   : '{$datas_lang.parcourir}',
				//'checkScript'      : '{$smarty.const.DOS_OUTILS_ADMIN}uploadifive/check-exists.php',
				'formData'         : {
                                       'dimThumbs'  : '{$upload_prop.dimThumbs}' ,
                                       'foldThumbs' : '{$upload_prop.path}' ,
                                       'path'       : '{$upload_prop.path}' ,
                                       'cropThumbs' : false ,
                                       'svig'       : '{$upload_prop.sufThumbs}' ,
                                       'wMax'       : '{$upload_prop.wMax}' ,
                                       'hMax'       : '{$upload_prop.hMax}' ,
                                       'exts'       : '{$upload_prop.exts}' //
                                       
				                     },
				'queueID'          : 'queue',
				'uploadScript'     : '{$smarty.const.DOS_OUTILS_ADMIN}uploadifive/uploadifive.php',
                'fileSizeLimit' : {$upload_prop.poidsmax/1024},
                
                'onSelect' : function(queue) {
                    erreursUpload=1;
                },

				'onUploadComplete' : function(file, data) { 
                    if(erreursUpload==1) { erreursUpload=0; }
                    var dataObj = JSON.parse(data);
                    if(dataObj.message!=""){ 
                        erreursUpload=2;
                        $("#uploadComplete").append("<div class='fileUploaded'><div class='fic'>" + file.name + "</div>" + dataObj.message + "</div>");
                    } else {
                         {if $upload_prop.src=="browse" }
                          {else} 
                                //console.log("{$this->field}"+lgActiveSuffixe);
                              $("#{$this->field}"+lgActiveSuffixe).val(dataObj.targetFile);
                              $("#{$this->field}").val(dataObj.targetFile);
                          {/if}
                        
                    }
                 },
                 'onQueueComplete' : function(uploads) {
                        if(uploads.errors==0 && erreursUpload==0) { 
                            {if $upload_prop.src=="browse" }
                                reloadBrowse();
                            {else} 
                                $("#queue").html(textDrop);
                            {/if}
                        } 
                  }

			});
});
</script>