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
            if (type == 'full') _.resizeTextarea();
        });

        Linker.click('item-deep', function (event) {

            if (App.server['editMode'] == 'update')
                return;

            var target = event.target;
            var deep = target.getAttribute('data-deep');
            Dom('input[name="deep"][value="'+deep+'"]').one(function(elem){elem.checked = true});

            Dom('span', target.parentNode).removeClass('active_deep');
            Dom(target).addClass('active_deep');

            if (deep > 1)
                App.Api.request('getcategories', function (data) {
                    App.Catch.put('categories', data['categories']);
                    App.Action.Relations.open(data['categories'], deep);
                }, {});
            else
                App.Action.Relations.close();
        });
    };

    //Object { link: "", tags: "", keyword: "", description: "", deep: "3", title: "", content: "" }
    _.saveItem = function(){

        var sendData = {item:null,relation:[]},
            errors = '',
            require = ['link', 'deep', 'title'],
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
                    App.redirect('/editor/' + response['res_item_link']);
                }

            }, sendData );

        } else {
            formError.style.display = 'block';
            App.inject(formError, errors);
        }
    };

    _.saveRemove = function(){
        App.redirect('/delete/');
    };
    _.saveNew = function(){
        App.redirect('/editor');
    };

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
    _.resizeTextareaPosition = {};
    _.resizeTextarea = function(){
        var ta = App.query('#ef_content');
        var menu = Dom.createElement(
            'div',
            {'style':'position:absolute;color:red;top:5px;right:15px;cursor:pointer;'},
            '<i class="icon-resize-full-alt"></i>'
        );
        _.node['form'].appendChild(menu);
        _.resizeTextareaPosition = Util.getPosition(ta);

        ta.style.position = 'absolute';
        ta.style.width = '100%';
        ta.style.height = '100%';
        ta.style.left = '0';
        ta.style.top = '0';

        menu.addEventListener('click',function(){
            ta.style.width = _.resizeTextareaPosition.width+'px';
            ta.style.height = _.resizeTextareaPosition.height+'px';
            ta.style.position = 'auto';
            ta.style.left = 'auto';
            ta.style.top = 'auto';
            _.node['form'].removeChild(menu);
        });
    };
    _.deepSwitcher = function(){

    };


    return _;
})}