if(App.namespace){App.namespace('Controller.Page', function(App) {

    /**
     * @namespace App.Controller.Page
     */
    var page = {};

    /**
     * @namespace App.Controller.Page.construct
     */
    page.construct = function(){

        Dom.loaded(page.loaded);



    };

    page.loaded = function(){
        App.Action.Editor.run();



    };



    return page;
})}


