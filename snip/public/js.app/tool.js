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

    return tool;
})}