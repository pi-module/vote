function Set_Vote(data, file, item, table, module) {
    $.ajax({
        type:"POST",
        url:file,
        data:data,
        dataType: "json",
        success:function (result) {
            $('#vote-' + module + '-' + table + '-' + item + '-up').attr('class', 'btn btn-default btn-sm disabled').attr('onclick', '');
            $('#vote-' + module + '-' + table + '-' + item + '-down').attr('class', 'btn btn-default btn-sm disabled').attr('onclick', '');
            if (result.status == 1) {
                if (result.point > 0) {
                    $('#vote-' + module + '-' + table + '-' + item + '-do').attr('class', 'btn btn-success btn-sm disabled').html(result.point_view);	
                } else {
                    $('#vote-' + module + '-' + table + '-' + item + '-do').attr('class', 'btn btn-danger btn-sm disabled').html(result.point_view);	
                }		
            } else {
                $('#vote-' + module + '-' + table + '-' + item + '-do').popover({trigger: 'hover',  placement: 'top', toggle : 'popover', content : result.message, title: result.title, container: 'body'}).popover('show').attr('class', 'btn btn-default btn-sm disabled');
                setTimeout(function() {$('#vote-' + module + '-' + table + '-' + item + '-do').popover('hide')}, 3000);
            }
        }
    });
}