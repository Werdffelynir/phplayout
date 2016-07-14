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
        _.node['form_error'] = App.query('#form_error');
        _.node['title'] = App.query('form[name=edit] input[name=title]');
        _.node['link'] = App.query('form[name=edit] input[name=link]');

        // Dynamic events
        App.Action.Editor.titleToLink();
        App.Action.Relations.find();

        // Linker events
        Linker.refresh();
        Linker.click('item-edit-menu', function (event) {
            var type = event.target.getAttribute('data-type');
            if (type == 'save') _.saveItem();
            if (type == 'remove') _.saveRemove();
            if (type == 'new') _.saveNew();
        });

        Linker.click('item-deep', function (event) {

            var target = event.target;
            var deep = target.getAttribute('data-deep');

            Dom('span', target.parentNode).removeClass('active_deep');
            Dom('input[name="deep"][value="'+deep+'"]').one(function(elem){elem.checked = true});
            Dom(target).addClass('active_deep');


            if (deep > 1)
                App.Api.request('getcategories', function (data) {
                    App.Action.Relations.open({categories: data['categories'], deep: deep});
                }, {});
            else
                App.Action.Relations.close();
        });



        //console.log('request success categories:', data['categories']);
        //console.log('request success categories:', data['categories']);

/*
 <input hidden="hidden" type="radio" name="deep" value="3" checked>
Linker.click('relation-remove', function (event) {
            console.log(this, event);
        });

        Linker.click('relation-add', function (event) {
            console.log(this, event);
        });*/
    };

    //Object { link: "", tags: "", keyword: "", description: "", deep: "3", title: "", content: "" }
    _.saveItem = function(){

        var errors = '',
            require = ['link', 'deep', 'title', 'content'],
            formData = Util.formData(_.node['form'], true);

        require.map(function (field) {
            if (!formData[field] || formData[field].length < 0)
                errors += '<p>Field <strong>' + field + '</strong> can`t be empty!</p>';
        });

        if (errors == '') {
            _.node['form_error'].style.display = 'none';
            App.Api.request('save', function (data) {
                console.log('request success:', data);
            }, formData);
        } else {
            _.node['form_error'].style.display = 'block';
            App.inject(_.node['form_error'], errors);
        }


    };

    _.saveRemove = function(){};
    _.saveNew = function(){};

    /**
     * @namespace App.Action.Editor.attachButtonEvents
     */
    _.titleToLink = function(){
        if(_.node['title']) {
            Dom(_.node['title']).on('blur', function(event){
                if(Util.isEmpty(_.node['link'].value))
                    _.node['link'].value = Util.toTranslit(_.node['title'].value.trim()).toLowerCase();
            });
        }
    };

    _.deepSwitcher = function(){

    };


    return _;
})}