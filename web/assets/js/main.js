$(document).ready(function () {

    var popup =  $('.popup-content');
    var responseText = $('#response');
    $('.load').click(function(){
        $(this).prop('disabled', true);
        var select = $(this).parent().find('.select-channel');
        var videoId = select.data('video-id');
        var checkedInput = select.find('input:checked');
        if (checkedInput.length == 0) {
            popup.show();
            responseText.html('Choose channel');
            $(this).prop('disabled', false);
            return;
        }
        var channelId = checkedInput.val();
        $.ajax({
            url: '/share/' + videoId + '/' + channelId,
            method: 'POST',
            success: function(response) {
                popup.show();
                responseText.html('Success');
                window.location.reload();
            },
            error: function(response) {
                $(this).prop('disabled', false);
                console.log(response);
                if (response.status == 409) {
                    popup.show();
                    responseText.html('Choose channel');
                } else {
                    popup.show();
                    responseText.html(response.statusText);
                }

            }
        })
    });

    // --------------- Customize project filter select options

    $('.option-channel-selected').on("click", function(){
        var self = $(this);
        self.toggleClass('show');
        self.parents('.select-channel').find('.select-channel-list').toggleClass('show');
        SelectChild();
    });

    function SelectChild(){
        $('.option-channel').click(function(){
            var checkDisabled = $(this).find('input').prop('disabled');
            var self = $(this);
            var text = self.find('label').text();
            var selected = self.parents('.select-channel').find('.option-channel-selected');

            if (checkDisabled == false ) {
                $('.select-channel-list').removeClass('show');
                selected.text(text);
                selected.removeClass('show');
            }
            else {}
        });
    }

    // --------------- Click out of element

    $(window).on("click.Bst", function(event){
        var selectBlock = $('.select-channel');
        if (selectBlock.has(event.target).length == 0 && !selectBlock.is(event.target)) {
            $('.select-channel-list').removeClass('show');
            $('.option-channel-selected').removeClass('show');
        } else { }
    });

    $('#add-youtube').click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '/connection/url/youtube',
            method: 'GET',
            success: function(response) {
                window.location = response.url;
            }
        })
    });

    $('#add-dailymotion').click(function(event) {
        event.preventDefault();
        $.ajax({
            url: '/connection/url/dailymotion',
            method: 'GET',
            success: function(response) {
                window.location = response.url;
            }
        })
    });

    $('.upload-btn').on("click", function () {
        $('#upload-form').submit();
    });

    $('.close-popup').on("click", function () {
       popup.hide();
    });

});

function uploadFile(target) {
    document.getElementById("file-name").innerHTML = target.files[0].name;
    $('.upload-btn').addClass('show');
}