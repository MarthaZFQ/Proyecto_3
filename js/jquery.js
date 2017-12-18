$(document).ready(function() {
  $('.reportar_div').hide();

  $("#mod").hide();
  $('#check').click(function() {
    $("#input_pass").val('');
      $("#mod").toggle(this.checked);
  });

  $('.masterTooltip').hover(function(){
        var title = $(this).attr('title');
        $(this).data('tipText', title).removeAttr('title');
        $('<p class="tooltip"></p>')
        .text(title)
        .appendTo('body')
        .fadeIn('slow');
    }, function() {
        $(this).attr('title', $(this).data('tipText'));
        $('.tooltip').remove();
    }).mousemove(function(e) {
        var mousex = e.pageX + 20; //X
        var mousey = e.pageY + 10; //Y
        $('.tooltip')
        .css({ top: mousey, left: mousex })
     });
});

function elegir(n){
  $("#opt"+n).addClass="active"
  
}

function mostrarincidencia(n){
    $('.inci_area').val('');
    $('#div_'+n).toggle();
};

/*Jquery para modificar*/
function valueChanged(){

      if ($('#check_input').is(":checked")) {
        $('#span_files').html('<input type="file" name="usu_foto" accept="image/jpg,image/png,image/jpeg"><br><br>');
      }else{
        $('#span_files').html('')
      }

    }