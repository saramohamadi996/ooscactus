<script>
tinymce.init({
selector: '#mytextarea',
language : 'fa',
paste_data_images: true,
height:400,
directionality: 'rtl',
plugins: 'preview link image  code table emoticons textcolor numberlist codesample lists media lists advlist directionality',
toolbar: 'undo redo | styleselect | bold italic Underline| alignleft aligncenter alignright alignjustify numlist bullist| outdent indent forecolor backcolor ltr rtl| link image media table| copy cut paste | preview | list |emoticons codesample|',
image_title: true,
automatic_uploads: true,
images_upload_url: '',
file_picker_types: 'image',
file_picker_callback: function(cb, value, meta) {
var input = document.createElement('input');
input.setAttribute('type', 'file');
input.setAttribute('accept', 'image/*');
input.onchange = function() {
var file = this.files[0];

var reader = new FileReader();
reader.readAsDataURL(file);
reader.onload = function () {
var id = 'blobid' + (new Date()).getTime();
var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
var base64 = reader.result.split(',')[1];
var blobInfo = blobCache.create(id, file, base64);
blobCache.add(blobInfo);
cb(blobInfo.blobUri(), { title: file.name });
};
};
input.click();
}
});
</script>
