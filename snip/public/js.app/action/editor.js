if(App.namespace){App.namespace('Action.Editor', function(App) {

    /**
     * @namespace App.Action.Editor
     */
    var _ = {};

    /**
     * @namespace App.Action.Editor.run
     */
    _.run = function(){

        Linker.refresh();

        Linker.click('item-edit-menu', function(event){
            console.log( this, event );
        });

        Linker.click('item-deep', function(event){
            console.log( this, event );
        });

        Linker.click('relation-remove', function(event){
            console.log( this, event );
        });

        Linker.click('relation-add', function(event){
            console.log( this, event );
        });
    };






    /**
     * @namespace App.Action.Editor.attachButtonEvents
     */
    _.attachButtonEvents = function(){

    };

    _.deepSwitcher = function(){

    };


    return _;
})}