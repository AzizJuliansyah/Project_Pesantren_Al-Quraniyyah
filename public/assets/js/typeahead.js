(function ($) {
    "use strict";

    var name = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("nama"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/get-alumni-names?q=%QUERY",
            wildcard: "%QUERY",
            transform: function (response) {
                return $.map(response, function (nama) {
                    return {
                        nama: nama,
                    };
                });
            },
        },
    });

    $("#bloodhound .form-control").typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1,
        },
        {
            name: "name",
            display: "nama",
            source: name,
            limit: 10,
            templates: {
                suggestion: function (data) {
                    return "<div>" + data.nama + "</div>";
                },
            },
        }
    );
})(jQuery);
