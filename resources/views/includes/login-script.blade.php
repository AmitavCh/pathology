<script>
    var controller = '{{ $controller }}';
    var action = '{{ $action }}';
    var csrfTkn = '{{ csrf_token() }}';
    var baseUrl = '{{ URL::to(' / ') }}';
    var onChangeFunction = '';
    var listingUrl = '';

    function showJsonErrors(errors) {
        if (errors != '') {
            resp = $.parseJSON(errors);
            var totErrorLen = resp.length;
            for (var errCnt = 0; errCnt < totErrorLen; errCnt++) {
                var modelField = resp[errCnt]['modelField'];
                var modelErrorMsg = resp[errCnt]['modelErrorMsg'];
                $('[id="' + modelField + '"]').after('<div class="error-message">' + modelErrorMsg + '</div>');
            }
        }
    }
    function resetFormVal(frmId, hidVal){

    if (hidVal == 1){

    $('#' + frmId).find('input:hidden').val('');
    } else{

    $('#id').val('');
    }

    $('#' + frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
            $('.' + frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
            $('#' + frmId).find('input:password,input:text, input:file, select, textarea').val('');
            $('.' + frmId).find('input:password,input:text, input:file, select, textarea').val('');
            $('.error-message').remove();
            //resetting file upload content	

    }
</script>