
$(document).ready(function() {
    table = $('#DataTable').DataTable({
        'language': {
            'url': datatable_lang,
        },
        'autoWidth': false,
        'responsive': true,
        'processing': true,
        'serverSide': true,
        'order': [
            // [1, 'desc']
        ],
        'columnDefs': [
            {'targets': 'no-sort', 'width': '90px', 'orderable': false, 'searchable': false}
            // {"targets": [3], "width": "90px", "orderable": false, "searchable": false}
        ],
        'lengthMenu': [
            [10, 30, 50, 100, -1],
            [10, 30, 50, 100, 'All']
        ],
        'ajax': {
            'url': admin_url + a_mod + '/data-table',
            'type': 'POST',
            data: csrfData
        },
        "drawCallback": function(settings) {
            $('[data-toggle="tooltip"]').tooltip();

            $('.check_item:checkbox').click(function(a) { 
                $(this).is('.check_item:checked') ? $(this).closest('table tbody tr').addClass('danger') : $(this).closest('table tbody tr').removeClass('danger') 
            }), 

            $('.checkedall').on('click', function() {
                var a = this.checked;
                $('.check_item').each(function() { this.checked = a, a == this.checked && $(this).closest('table tbody tr').removeClass('danger'), this.checked && $(this).closest('table tbody tr').addClass('danger')}) 
            });

            $('.modal_delete').click(function() {
                var idDel = $(this).attr('idDel');
                var tname = $(this).attr('tname');
                var xmod = $(this).attr('xmod');
                $('#idDel').val(idDel);
                $('#tname').val(tname);
                $('#xmod').val(xmod);
                $('#modal_delete').modal('show');
            });
        }
    });
});

// ajax delete.
$(document).ready(function() {
    $('#submit_delete').on('click',function() {
        var form = $('#form_delete');
        $(".ajax_alert").hide();
        $(".alert").hide();
        $('#modal_delete').modal('hide');
        $.ajax({
            url: admin_url + a_mod + '/delete',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success:function(response) {
                var alert_type = response.alert_type;
                var alert_messages = response.alert_messages;

                switch (response.status) {
                    case true:
                        table.row($('#table tr.active')).remove().draw(false);
                    break;

                    case false:
                    break;
                    default:
                        alert('ERROR');
                    break;
                }

                $('.ajax_alert').show().html('<div class="alert alert-'+alert_type+' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+alert_messages+'</div>');
                $(".ajax_alert").fadeTo(15353, 50).slideUp(300, function() {
                    $(".alert").alert('close');
                    $(".ajax_alert").hide();
                });
            }
        }); 
        return false;
    });
});


$(document).ready(function() {
    $('classname').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$('#classname').val(b.toLowerCase()),$('#classname').val($('#classname').val().replace(/\W/g,' ')),$('#classname').val($('#classname').val().replace(/\s+/g,'_'))});
    $('#tablename').on('input',function(){var a;a=(a=(a=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$('#tablename').val(a.toLowerCase()),$('#tablename').val($('#tablename').val().replace(/\W/g,' ')),$('#tablename').val($('#tablename').val().replace(/\s+/g,'_'))});
});