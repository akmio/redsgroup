$(document).ready(function(){
    $(document).on('click', '.button-vote', function(){

        var url =  $(this).attr('data-vote');
        var elemId = $(this).attr('data-id');
        var targetContainer = $('.input'+elemId);

        targetContainer.disabled = false;

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                success: function(data){
                    var input = $(data).find('.input'+elemId);
                    targetContainer.replaceWith(input);
                }
            });
        }
        
    });
});