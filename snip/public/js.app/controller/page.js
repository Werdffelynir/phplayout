/**
 * @type NamespaceApplication App
 */
if (App.namespace) { App.namespace('Controller.Page', function(App) {


    /**
     * @namespace App.Controller.Page
     */
    var page = {
        route: App.routePath()
    };

    /**
     * @namespace App.Controller.Page.construct
     */
    page.construct = function(){

        Dom.loaded(page.loaded);



    };

    page.loaded = function(){

        if (page.route == '/') {
            console.log('main page');
        } else if (page.route.slice(0,7) == '/editor') {
            App.Action.Editor.run();
        }



    };



    return page;
})}


