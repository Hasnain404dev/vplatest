// Wishlist functionality
$(document).on("click", ".add-to-wishlist", function (e) {
    e.preventDefault();
    const form = $(this).next("form");
    const url = form.attr("action");

    $.ajax({
        url: url,
        type: "POST",
        data: form.serialize(),
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // Update wishlist count
                $.get("/wishlist/count", function (data) {
                    $(".wishlist-count").text(data.count);
                });

                // Show success message
                toastr.success("Product added to wishlist");
            }
        },
        error: function (xhr) {
            toastr.error("Error adding product to wishlist");
        },
    });
});




$('#search-input').on('input', function () {
    let query = $(this).val();
    let category = $('select[name="category"]').val();

    if (query.length > 1) {
        $.ajax({
            url: "{{ route('frontend.search') }}",
            method: 'GET',
            data: { query: query, category: category },
            success: function (response) {
                $('#search-results-dropdown').html(response.html).show();
            },
            error: function () {
                $('#search-results-dropdown').html('<div class="p-2 text-muted">Error loading results</div>').show();
            }
        });
    } else {
        $('#search-results-dropdown').hide();
    }
});

