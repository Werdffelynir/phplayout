if(App.namespace){App.namespace('Action.Editor', function(App) {

    /**
     * @namespace App.Action.Editor
     */
    var _ = {
        node:{}
    };

    /**
     * @namespace App.Action.Editor.run
     */
    _.run = function(){

        // Elements nodes
        _.node['form'] = App.query('form[name=edit]');
        _.node['title'] = App.query('form[name=edit] input[name=title]');
        _.node['link'] = App.query('form[name=edit] input[name=link]');

        // Dynamic events
        App.Action.Editor.titleToLink();

        // Linker events
        Linker.refresh();
        Linker.click('item-edit-menu', function(event){
            var type = event.target.getAttribute('data-type');
            if(type == 'save') _.saveItem();
            if(type == 'remove') _.saveRemove();
            if(type == 'new') _.saveNew();
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

    //Object { link: "", tags: "", keyword: "", description: "", deep: "3", title: "", content: "" }
    _.saveItem = function(){
        var formData = Util.formData(_.node['form'], true);
        console.log( formData );
    };

    _.saveRemove = function(){};
    _.saveNew = function(){};

    /**
     * @namespace App.Action.Editor.attachButtonEvents
     */
    _.titleToLink = function(){
        Dom(_.node['title']).on('blur', function(event){
            if(Util.isEmpty(_.node['link'].value))
                _.node['link'].value = Util.toTranslit(_.node['title'].value.trim()).toLowerCase();
        });
    };

    _.deepSwitcher = function(){

    };


    return _;
})}