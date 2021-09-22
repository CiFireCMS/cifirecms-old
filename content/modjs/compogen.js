
$(document).ready(function() {
    $('#next-to-database').click(function() {
        var step_general = $('#step-general input').valid();
        if (step_general==true) {
            $('#h-database').addClass('active');
            $('#h-general').removeClass('active');
            $('#box-general').hide();
            $('#box-database').show();
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        };
    });
 
    $('#next-to-config').click(function() {
        var step_database = $('#step-database input').valid();
        if (step_database==true) {      
            $('#h-config').addClass('active');
            $('#h-general').removeClass('active');
            $('#h-database').removeClass('active');
            $('#h-finish').removeClass('active');
            $('#box-database').hide();
            $('#box-config').show();
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        }else{
           step_database.focus();
        };
    });

    $('#next-to-finish').click(function() {
        var step_config = $('#step-config input').valid();
        if (step_config==true) { 
            $('#h-finish').addClass('active');
            $('#h-config').removeClass('active');
            $('#h-general').removeClass('active');
            $('#h-database').removeClass('active');
            $('#box-config').hide();
            $('#box-finish').show();
            document.body.scrollTop = document.documentElement.scrollTop = 0;
        };
    });

    $('#prev-to-general').click(function() {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        $('#h-general').addClass('active');
        $('#h-database').removeClass('active');
        $('#h-config').removeClass('active');
        $('#h-finish').removeClass('active');
        $('#box-general').show();
        $('#box-database').hide();
        $('#box-config').hide();
        $('#box-finish').hide();
    });

    $('#prev-to-database').click(function() {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        $('#h-database').addClass('active');
        $('#h-config').removeClass('active');
        $('#h-finish').removeClass('active');
        $('#h-general').removeClass('active');
        $('#box-general').hide();
        $('#box-database').show();
        $('#box-config').hide();
        $('#box-finish').hide();
    });

    $('#prev-to-config').click(function() {
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        $('#h-config').addClass('active');
        $('#h-finish').removeClass('active');
        $('#h-general').removeClass('active');
        $('#h-database').removeClass('active');
        $('#box-general').hide();
        $('#box-database').hide();
        $('#box-config').show();
        $('#box-finish').hide();
    });

    $('#install-cogen').on('click',function() {
        $('body').css('overflow', 'hidden');
        $('#boxc').hide();
        $('#loads').show();
        $('.installing').show();
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    });
});


$(document).ready(function() {
    $('#tablename').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g," ")),$(this).val($(this).val().replace(/\s+/g,"_"))});

    $('#component_name').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$('#classname').val(b.toLowerCase()),$('#classname').val($('#classname').val().replace(/\W/g," ")),$('#classname').val($('#classname').val().replace(/\s+/g,""))});

    $('#com_fieldname_1').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g," ")),$(this).val($(this).val().replace(/\s+/g,"_"))});

    $('input[id^="field"]').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g," ")).replace(/_/g," "),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g," ")),$(this).val($(this).val().replace(/\s+/g,"_"))});
});


$(document).on('click','.btn-add-field',function(e){
    e.preventDefault();
    var id = $(this).attr("id");
    var newid = parseInt(id) + 1;
    var idtot = $('#totalfield').val();
    var newidtot = parseInt(idtot) + 1;
    var dataString = 'id=' + id + '&csrf_name=' + csrfToken;
    $('.btn-add-field span').html("<img src='"+site_url+"content/images/loading.gif'/>");
    $.ajax({
        type: 'POST',
        url: admin_url + a_mod + '/add-field',
        data: dataString,
        cache: false,
        success: function(html){
            $('[data-toggle="tooltip"]').tooltip();
            $('#append-add-field').append(html);
            $('.btn-add-field').attr('id', '' + newid + '');
            $('input[id^="field"]').on('input',function(){var b;b=(b=(b=$(this).val()).replace(/\s+/g,' ')).replace(/_/g,' '),$(this).val(b.toLowerCase()),$(this).val($(this).val().replace(/\W/g,' ')),$(this).val($(this).val().replace(/\s+/g,'_'))});
            $('#totalfield').val(newidtot);
            $('.btn-add-field span').html('<span class="text-success"><i class="fa fa-plus-circle"></i> &nbsp; Add New Field</span>');
        }
    });
    return false;
});


$(document).on('click','.rmfield',function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    $('#def-field-'+id).remove();
});


$(document).on('click','.add-more-option',function(e){
    e.preventDefault();
    var id = $(this).attr("id");
    var newid = parseInt(id) + 1;
    var idtot = $('#totaloption').val();
    var newidtot = parseInt(idtot) + 1;
    var dataString = 'id=' + id + '&csrf_name=' + csrfToken;
    $('.add-more-option span').html("<img src='"+site_url+"content/images/loading.gif'/>");
    $.ajax({
        type: 'POST',
        url: admin_url + 'compogen/add-option',
        data: dataString,
        cache: false,
        success: function(html){
            $('#append-add-options').append(html);
            $('.add-more-option').attr('id', '' + newid + '');
            $('#totaloption').val(newidtot);
            $('.add-more-option span').html('<i class="fa fa-plus-circle"></i> Add Option');
        }
    });
    return false;
});


$(document).on('click','.rmoption',function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    $('#def-option'+id).remove();
});


$(document).on('click','.btn-add-column',function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    var newid = parseInt(id) + 1;
    var idtot = $('#totalcol').val();
    var newidtot = parseInt(idtot) + 1;
    var dataString = 'id=' + id + '&csrf_name=' + csrfToken;
    $('.btn-add-column span').html("<img src='"+site_url+"content/images/loading.gif'/>");
    $.ajax({
        type: 'POST',
        url: admin_url + 'compogen/add-column',
        data: dataString,
        cache: false,
        success: function(html){
            $('#append-add-column').append(html);
            $('.btn-add-column').attr('id', '' + newid + '');
            $('#totalcol').val(newidtot);
            $('.btn-add-column span').html('<i class="fa fa-plus-circle"></i>&nbsp; Add New Column');
        }
    });
    return false;
});


$(document).on('click','.rmcol',function(e){
    e.preventDefault();
    var id = $(this).attr('id');
    $('#def-column-' + id).remove();
});


$(document).ready(function(){
    $('.show-modal-terms').click(function(){
        $('#modal-terms').modal('show');
    });
});