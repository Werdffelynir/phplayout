
window.App = new NamespaceApplication({
    path: '/',
    debug: true,
    token: 'secret_token_key',
    constructsType: false
});


App.require('libs',
    [
        App.path + 'public/js.libs/aj.js',
        App.path + 'public/js.libs/dom.js',
        App.path + 'public/js.libs/util.js',
        App.path + 'public/js.libs/piece.js',
        App.path + 'public/js.libs/linker.js'
    ],
    initLibs, initError);


App.require('dependence',
    [
        // Common tools
        App.path + 'public/js.app/api.js',
        App.path + 'public/js.app/tool.js',
        App.path + 'public/js.app/catch.js',

        // Actions
        App.path + 'public/js.app/action/editor.js',
        App.path + 'public/js.app/action/relations.js',

         // Controllers
        App.path + 'public/js.app/controller/page.js'

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
