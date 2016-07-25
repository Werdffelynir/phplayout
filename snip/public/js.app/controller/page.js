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

        // Init Highlighter
        hljs.initHighlightingOnLoad();

        Dom.loaded(page.loaded);


    };

    page.loaded = function(){

        // Width Highlighter
        // Timer.timeout(function(){
        //     Dom('.hljs').css('width', Util.getPosition(Dom('#content').one()).width + 'px');
        // }, 1000);





        Dom('#navigation li>a').all(function(items){
            items.forEach(function (its) {
                if(its.textContent.toString().toLowerCase() == App.server['queryCat'])
                    its.classList.add('active_nav');
                else its.classList.remove('active_nav');
            });
        });

        if (page.route == '/') {
            console.log('main page');
        } else if (page.route.slice(0,7) == '/editor') {
            App.Action.Editor.run();
        }
    };



    return page;
})}


