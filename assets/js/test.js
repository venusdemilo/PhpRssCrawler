$(document).ready(function() {


    //$('#cible').load({{ path('simple_rss_reader'|escape('js') }});
    $('button').click(function(result){
      $('#cible').html('');
      $("#preloader").addClass('progress').html('<div class="indeterminate"></div>');
      $('#cardTitle').text($(this).text());
      $.getJSON($(this).attr('url'),function(result){
          $("#preloader").removeClass('progress').html(''); // resete ajax logo loader


          $.each(result,function(i,field){

            $.each(field,function(j,data){
              $('#cible').append('- <a href="' + data.link + '" target="_blanck" style="color:white">' + data.title + '</a><br/>');
            });



          });
      });
    });


});
