

window.App = new NamespaceApplication({

    uri: location.pathname,
    url: location.origin + location.pathname,
    uriLibs: location.pathname + '/public/js.libs/',
    uriView: location.pathname + '/public/js.app/view/',
    debug: true,
    token: null,
    constructsType: false
});

App.require('libs',
    [
        App.uriLibs + 'aj.js',
        App.uriLibs + 'dom.js',
        App.uriLibs + 'util.js',
        App.uriLibs + 'piece.js',
        App.uriLibs + 'linker.js'
    ],
    initLibs, initError);


App.require('dependence',
    [
        // Common tools
        App.uri + 'public/js.app/tool.js',

        // Actions
        App.uri + 'public/js.app/action/editor.js',

         // Controllers
        App.uri + 'public/js.app/controller/page.js'

    ],
    initDependence, initError);


// load resources 'libs'
App.requireStart('libs');

function initError(error){
    console.error('onRequireError' , error);
}

// After, load resources 'dependence'
function initLibs(list){
    App.requireStart('dependence');
}




// Start
function initDependence(list){
    console.log('Application start!');

    App.Controller.Page.construct();
}
