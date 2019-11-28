$('#add-image').click(function () {
    const index = +$('#widgets-counter').val();

    // we get the prototype which contains form html and replace name by the index
    const tmpl = $('#annonce_images').data('prototype').replace(/__name__/g, index);

    // code injection
    $('#annonce_images').append(tmpl);
    $('#widgets-counter').val(index + 1);

    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#annonce_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();