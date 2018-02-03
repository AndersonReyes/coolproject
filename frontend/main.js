$(document).ready(function() {
    $("#login-form").submit(function(event) {

        event.preventDefault();

        var form_data = $("#login-form").serialize();

        $.ajax({
            type: "POST",
            url: $("#login-form").attr("action"),
            data: form_data
        }).done(function(response) {
            var result = JSON.parse(response);

            var text = "";

            for(var res in result) {
                text += res + " "  + result[res];
            }
            
            $("#form-container").append("<p style='color: green;'>" + text + "</p>");
            $("#flogin-form").find("input").val("");

        }).fail(function(data) {
            $("#form-container").append("<p style='color: red;'>" + data.responseText + "</p>");
        });

    });
});