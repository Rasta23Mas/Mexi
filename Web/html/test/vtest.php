<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
    function upload_img(){

        var formData = new FormData($("#formUpload")[0]);
        $.ajax({
            type: 'POST',
            url: 'subida.php',
            data: formData,
            contentType: false,
            processData: false
        });

    }
</script>

<form onsubmit="return false" class="oculto" method="post" enctype="multipart/form-data" id="formUpload">
    <input type="file" name="image" onchange="upload_img();">
</form>