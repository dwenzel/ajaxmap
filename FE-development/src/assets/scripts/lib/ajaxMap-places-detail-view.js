function openDetailView(caller, placeId) {

    switch (caller) {
        case "infoWindow":
            placeId = $('#detailView').data('placeId');
            break;
        case "listView":
            break;
        default:
            break;
    }

    if (placeId) {//?@dirk
        var path = $(location).attr('href');

        if (path.indexOf('?') > -1) {
            path = path + '&type=1441916976';
        } else {
            path = path + '?type=1441916976';
        }

        $.ajax({
            url: path,
            context: $('#detailView .inner'),
            data: {
                tx_ajaxmap_map: {
                    'controller': "Place",
                    'action': 'ajaxShow',
                    'placeId': placeId
                }
            }
        })
        .done(function(data) {
            this.html(data);
            $('#detailView').fadeIn('400');
            $('#overlayDetailHelper').height($(document).height()).fadeIn('400');
            $('#overlay-close').click(function() {
                $('#detailView').fadeOut('500');
                $('#overlayDetailHelper').fadeOut('500');
                $('#detailView .inner').contents().remove();
            });
        });
    }
}

export default openDetailView;
