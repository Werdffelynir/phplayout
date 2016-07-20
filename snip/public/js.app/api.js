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
                var resData = JSON.parse(response);
                console.log('JSON.parse: ', resData);

                App.token = resData.token;
                delete resData.token;

                callback.call(null, resData.data);
            } catch (error) {
                // console.log('Exception: ', error);
                // console.error('Api Request catch error! Status: ' + status);
                // console.error('Api Request catch error! Response: ' + response);
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