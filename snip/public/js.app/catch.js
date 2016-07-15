if(App.namespace){App.namespace('Catch', function(App) {

    /**
     * @namespace App.Catch
     */
    var  _ = {};

    var _data = {};

    /**
     * @namespace App.Catch.put
     *
     * @param key
     * @param value
     */
    _.put = function(key, value){
        _data[key] = value;
    };

    /**
     * @namespace App.Catch.get
     *
     * @param key
     * @returns {*}
     */
    _.get = function(key){ return _data[key] };

    /**
     * @namespace App.Catch.getAll
     * @returns {{}}
     */
    _.getAll = function(){ return _data };

    /**
     * @namespace App.Catch.exist
     *
     * @param key
     * @returns {boolean}
     */
    _.exist = function(key){ return _data[key] !== undefined };

    return _;
})}