$(document).ready(function () {
        $(document).on('click', '#short_url-copy_btn', function () {
                var $temp = $('<input>');
                $("body").append($temp);
                $temp.val($('#short_url').attr('href')).select();
                document.execCommand('copy');
                $temp.remove();
                alert('Ссылка скопирована!');
        })
})

