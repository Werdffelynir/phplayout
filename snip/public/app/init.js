
window.App = new NamespaceApplication({
    url: '/layout/snip/',
    urlLibs: '/layout/snip/public/applibrary/',
    name: 'Developer NS.JS Framework',
    environment: 'environment',
    debug: true,
    token: null,
    constructsType: false
});

App.require('libs',
    [
        App.urlLibs + 'aj.js',
        App.urlLibs + 'idb.js',
        App.urlLibs + 'dom.js',
        App.urlLibs + 'util.js',
        App.urlLibs + 'timer.js'
    ],
    initLibrary, initError);


App.require('dependence',
    [
        // App Extensions
        //'js.app/extension/common.js',
        //'js.app/extension/linker.js',
        //'js.app/extension/api.js',
        //'js.app/extension/error.js',

        // Actions
        //'js.app/action/user.js',
        //'js.app/action/popup.js',
        //'js.app/action/render.js',
        //'js.app/action/content.js',
        //'js.app/action/sidebar.js',
        //'js.app/action/navigate.js',

        // Controllers
        //'js.app/controller/page.js',
        //'js.app/controller/back.js'

    ],
    initDependence, initError);


// start loading resources 'libs'
App.requireStart('libs');

function initError(error){
    console.error('onRequireError' , error);
}

function initLibrary(list){
    App.requireStart('dependence');
}
function initDependence(list){
    console.log('Application start!');

    //App.Controller.Page.construct();
}



