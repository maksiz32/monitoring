const spinner = $('#remote-modal__spinner');

    $('.remote-modal__show').on('click', (el) => {
        const deleteId = $(el.target).data('remote-id');
        $('#remote-modal__delete').attr('data-remote-id', deleteId);
    });

    $('#remote-modal__delete').on('click', () => {
        $('#remote-modal__delete').hide();
        spinner.show();
        const deleteId = $('#remote-modal__delete').data('remote-id');
        $.ajax({
            method: 'DELETE',
            url: `/remote/${deleteId}`,
            data: {"_token": $('meta[name="csrf-token"]').attr('content')},
            success(Response) {
                window.location.href = '/remote';
            },
            error(Error) {
                window.location.href = '/remote';
            },
            always() {
                spinner.hide();
                $('#remote-modal__delete').show();
            },
        })
    });

