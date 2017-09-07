
<?php
if(!empty($_POST['root']) && !empty($_FILES['croppedImage'])) {
  file_put_contents($_POST['root'], file_get_contents($_FILES['croppedImage']['tmp_name']));
}
?>

<script>
  (function() {
    $(window).load(function(){
      setTimeout(function () {
        $('.field-name-cropper').remove();
        if($('.field-name-_info input').val().startsWith("image")) {
          $('.fileview-options ul').append('<li><button  class="btn btn-with-icon cropper-init"><i class="icon icon-left fa fa-crop"></i>Crop</button></li>');
          $('.fileview-options ul li').css({'width': '25%'});
        }
      }, 750);
    });

    var cropper = null;
    $(document).on('click', '.cropper-init', function(e){
      $image = $('.fileview-image img').clone();
      if($('.fileview-cropper').length == 0) {
        $('.fileview-image nav').css({'visibility': 'hidden'});
        $figure = $('<figure class="fileview-cropper" ></figure>');
        $div = $('<div />');
        $div.append($image);
        $figure.append($div);
        $('.fileview').append($figure);
        $figure.append('<div class="cropper-button-container"><button class="btn btn-rounded btn-cropper-submit"><i class="icon icon-left fa fa-crop"></i> Apply</button><button class="btn btn-rounded btn-cropper-cancel"><i class="icon icon-left fa fa-remove"></i> Cancel</button></div>');
      }
      else {
        location.reload();
      }
      cropper = $image.cropper();
    });

    $(document).on('click', '.btn-cropper-cancel', function(e) {
      location.reload();
    });

    $(document).on('click', '.btn-cropper-submit', function(e) {
      e.preventDefault();

      cropper.cropper('getCroppedCanvas').toBlob(function (blob) {
        var formData = new FormData();

        formData.append('croppedImage', blob);
        formData.append('root', '<?= str_replace('\\', '\\\\', $file->root()); ?>');

        $.ajax({
          url: '',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (data, status) {
             location.reload();
          },
          error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
          }
        });
      });
    });

  })();
</script>





