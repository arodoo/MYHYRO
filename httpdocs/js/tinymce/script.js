tinymce.init({
mode: 'specific_textareas',
editor_selector: 'mceEditor',
file_picker_callback: function (callback, value, meta) {
 if (meta.filetype == 'image') {
  var input = document.getElementById('my-file');
   input.click();
   input.onchange = function () {
   var file = input.files[0];
   var reader = new FileReader();
   reader.onload = function (e) {
    callback(e.target.result, {
       alt: file.name
    });
  };
  reader.readAsDataURL(file);
  };
 }
},
directionality : 'ltr',
language: 'fr_FR',
theme: 'modern',
automatic_uploads: true,
relative_urls: false,
remove_script_host: true,
image_advtab: true,
forced_root_block : false,
force_br_newlines:true,
force_p_newlines : false,
paste_data_images: true,
images_upload_base_path: '',
images_upload_url: '/js/tinymce/upload-ajax.php',
images_upload_credentials: true,
plugins: ['paste advlist autolink lists link image charmap print preview hr anchor pagebreak',
'searchreplace wordcount visualblocks visualchars code codesample fullscreen codemirror',
'insertdatetime media nonbreaking save table contextmenu directionality',
'emoticons template textcolor colorpicker textpattern imagetools'],
 contextmenu: "cut copy paste | pastetext | selectall | link image inserttable | cell row column deletetable",
toolbar1: 'insertfile undo redo | styleselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | fullpage | fullscreen | paste | fontselect | codesample | code',
codemirror: {
    indentOnInit: true, // Whether or not to indent code on init.
    fullscreen: true,   // Default setting is false
    path: '<?php echo "$http"; ?><?php echo "$nomsiteweb"; ?>/js/tinymce/js/tinymce/plugins/codemirror/codemirror-4.8', // Path to CodeMirror distribution
    config: {           // CodeMirror config object
       mode: 'application/x-httpd-php',
       lineNumbers: true,
       mode: "htmlmixed"
    },
    width: 800,         // Default value is 800
    height: 600,        // Default value is 550
    saveCursorPosition: true,
  },
content_css: [
'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
'//www.tinymce.com/css/codepen.min.css'
]});