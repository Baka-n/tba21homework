$(function(){
    $(document).on('click', '.modalLink', function() {
        $('#create-modal')
            .modal('show')
            .find('#createModalContent')
            .load($(this).attr('create-url'));
    });

    $(document).on('click', '.pjax-update-link', function() {
        $('#update-modal')
            .modal('show')
            .find('#updateModalContent')
            .load($(this).attr('update-url'));
    });

    $(document).on('click', '.pjax-delete-link', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('delete-url');
        var pjaxContainer = $(this).attr('pjax-container');
        var result = confirm('Delete this item, are you sure?');
        if(result) {
            $.ajax({
                url: deleteUrl,
                type: 'post',
                error: function(xhr, status, error) {
                    alert('There was an error with your request.' + xhr.responseText);
                }
            }).done(function(data) {
                $.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 3000});
            });
        }
    });

    $("body").on("beforeSubmit", "form#update-form", function () {
        var form = $(this);
        if (form.find(".has-error").length)
        {
            return false;
        }
        $.ajax({
            url    : form.attr("action"),
            type   : "post",
            data   : form.serialize(),
            success: function ()
            {
                $("#update-modal").modal("toggle");
                $.pjax.reload({container:"#pjax-container"});

            },
            error  : function ()
            {
                console.log("internal server error");
            }
        });
        return false;
    });

    $("body").on("beforeSubmit", "form#create-form", function () {
        var form = $(this);
        if (form.find(".has-error").length)
        {
            return false;
        }
        $.ajax({
            url    : form.attr("action"),
            type   : "POST",
            data   : form.serialize(),
            success: function ()
            {
                $("#create-modal").modal("toggle");
                $.pjax.reload({container:"#pjax-container"});

            },
            error  : function ()
            {
                console.log("internal server error");
            }
        });
        return false;
    });
})