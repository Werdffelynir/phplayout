if(App.namespace){App.namespace('Tool', function(App) {

    /**
     * @namespace App.Tool
     */
    var tool = {};

    /**
     * @namespace App.Tool.encodeLink
     */
    tool.encodeLink = function(text){
        return encodeURIComponent(Util.toTranslit(text.trim().toLowerCase()));
    };

    tool.queryUp = function(selector, from){
        from = from || document;
        if(typeof from === 'string')
            from = document.querySelector(from);

        if(typeof selector === 'string')
            selector = from.querySelector(from);
    };

    return tool;
})}