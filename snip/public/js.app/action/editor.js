if(App.namespace){App.namespace('Action.Editor', function(App) {

    /**
     * @namespace App.Action.Editor
     */
    var _ = {
        item:{id:0},
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
                    App.Catch.put('categories', data['categories']);
                    App.Action.Relations.open(data['categories'], deep);
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

        var sendData = {item:null,relation:[]},
            errors = '',
            require = ['link', 'deep', 'title', 'content'],
            formError = _.node['form_error'],
            formData = Util.formData(_.node['form'], true);


        require.map(function (field) {
            if (!formData[field] || formData[field].length < 0)
                errors += '<p>Field <strong>' + field + '</strong> can`t be empty!</p>';
        });

        // relations
        var ri, relitem = App.queryAll('.relation_item', '#relation_items');

        if(relitem)
            for(ri = 0; ri < relitem.length; ri++) {
                var attrDataId = relitem[ri].getAttribute('data-id');
                sendData.relation.push(parseInt(attrDataId));
            }

        //console.log('sendData.relation:', sendData.relation);

        if (errors == '') {

            formError.style.display = 'none';

            sendData.item = JSON.stringify(formData);
            sendData.relation = JSON.stringify(sendData.relation);

            // if(formData.deep == 1) { }
            // Object {data: Object, error: null, error_info: null, mode: "insert", res_item: "11"…}
            App.Api.request('save', function (response) {

                console.log('### save:', response);

                if(response['error']) {
                    formError.style.display = 'block';
                    App.inject(formError, response['error_info']);
                }else{
                    App.redirect('/editor/' + response['res_item']);
                }

            }, sendData );

        } else {
            formError.style.display = 'block';
            App.inject(formError, errors);
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