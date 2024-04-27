$(document).ready(function () {
    $('#urlForm').submit(function (e) {
        e.preventDefault();

        var url = $('#url').val();

        if (!isValidUrl(url)) {
            $('#result').html('<div class="alert alert-danger">Insira uma URL valida.</div>');
        }

        $.ajax({
            type: 'POST',
            url: '/create',
            contentType: 'application/json',
            data: JSON.stringify({ url: url }),
            success: function (data) {
                $('#result').html('<div class="alert alert-success">URL encurtada: <a href="' + data.shortURL + '" target="_blank" rel="noopener noreferrer">' + data.shortURL + '</a></div>');
            },
            error: function (xhr) {
                const response = JSON.parse(xhr.responseText);
                $('#result').html('<div class="alert alert-danger">' + response.url[0] + '</div>');
            }
        });
    });

    const isValidUrl = urlString=> {
        try { 
            return Boolean(new URL(urlString)); 
        }
        catch(e){ 
            return false; 
        }
    }
});