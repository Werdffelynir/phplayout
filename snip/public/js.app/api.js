if(App.namespace){App.namespace('Api', function(App) {

    /**
     * @namespace App.Api
     */
    var api = {};

    /**
     * @namespace App.Api.request
     */
    api.request = function (key, callback, args) {

        args = (args instanceof Object) ? args : {};
        args.key = key;
        args.token = App.token;

        Aj.post('/api', args, function (status, response) {

            if(!!api.log)
                console.log('### Api.request: status ', status, response);

            try {
                var dataResponse = JSON.parse(response);
                App.token = dataResponse.token;
                delete dataResponse.token;

                callback.call(null, dataResponse.data);
            } catch (e) {
                console.error('Api Request catch error! Status: [' + status + '] Response: [' + response + ']');
            }


        });
    };

    /**
     * @namespace App.Api.log
     * @type {boolean}
     */
    api.log = false;

    return api;
})}