/**
 * Created by d.eggermann on 30.10.19.
 */

module.exports = {
    inserScriptTag: (src) => {

        return new Promise(function(resolve, reject) {
            var script = document.createElement('script');
            script.src = src;
            script.async = true;
            script.onload = resolve;
            script.onerror = reject;

            var entry = document.getElementsByTagName('script')[0];
            entry.parentNode.insertBefore(script, entry);
        })
    },
    /**
     * get address for a single place
     * @param placeId
     * @return json
     */
    getAddress: function(placeId) {
        var address = {};
        $.ajax({
            url: "index.php",
            type: "GET",
            data: {
                'id': mapSettings.pageId,
                'api': "map",
                'action': "getAddress",
                'placeId': placeId
            },
            dataType: "json",
            success: function(result) {
                address = result;
            }
        });
        return address;
    }
}
