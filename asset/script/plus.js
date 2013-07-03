function Set_Vote(data, file, item, module) {
   $.ajax({
      type:"POST",
      url:file,
      data:data,
      dataType: "json",
      success:function (result) {
         $('#vote-' + module + '-' + item + '-up').attr('class', 'btn btn-small disabled').attr('onclick', '');
         $('#vote-' + module + '-' + item + '-down').attr('class', 'btn btn-small disabled').attr('onclick', '');
         if (result.status == 1) {
            if (result.point > 0) {
               $('#vote-' + module + '-' + item + '-do').attr('class', 'btn btn-small btn-success').html(result.point);	
            } else {
               $('#vote-' + module + '-' + item + '-do').attr('class', 'btn btn-small btn-danger').html(result.point);	
            }		
         } else {
            $('#vote-' + module + '-' + item + '-do').attr('data-toggle', 'popover').attr('data-placement', 'top').attr('data-content', result.message).popover('show');
            setTimeout(function() {$('#vote-' + module + '-' + item + '-do').popover('hide')}, 3000);
         }
      }
   });
}