

window.App = new NamespaceApplication({

    uri: '/layout/snip/',
    debug: true,
    token: null,
    constructsType: false
});

App.require('libs',
    [
        App.uri + 'public/js.libs/aj.js',
        App.uri + 'public/js.libs/dom.js',
        App.uri + 'public/js.libs/util.js',
        App.uri + 'public/js.libs/piece.js',
        App.uri + 'public/js.libs/linker.js'
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
