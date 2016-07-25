/**
 * @type NamespaceApplication App
 */
if(App.namespace){App.namespace('Action.Relations', function(App) {

    /**
     * @namespace App.Action.Relations _
     */
    var _ = {
        node: {},
        deep: null,
        categories: null,
        subcategories: null
    };


    /**
     * @namespace App.Action.Relations.find
     */
    _.find = function(){
        _.node['rel_items'] = App.query('#relation_items');
        _.node['rel_window'] = App.query('#relations');
        _.enableEvents();

        //
/*        var cat1 = _.createItem('Category One');
        var cat2 = _.createItem('Category Other', 'Sub category');
        var cat3 = _.createItem('Simple Case', 'Inside');

        _.node['rel_items'].appendChild(cat1);
        _.node['rel_items'].appendChild(cat2);
        _.node['rel_items'].appendChild(cat3);*/
    };


    /**
     * @namespace App.Action.Relations.open
     * @param categories
     * @param deep
     */
    _.open = function(categories, deep) {
        _.categories = categories;
        _.deep = deep;

        // Elements nodes
        _.node['rel_first']  = App.query('#relations_first');
        _.node['rel_second'] = App.query('#relations_second');
        _.node['rel_window'].style.display = 'block';

        if (deep == 2) {
            _.node['rel_second'].textContent = '';
            Dom(_.node['rel_second']).removeClass('width_50');
        }

        _.addCategories(_.categories);

        Dom('li', _.node['rel_window']).removeClass('selected_relation');
    };

    _.addCategories = function (list) {
        if(typeof list === 'object') {
            App.inject('#relations_first', _.createList(list));
        }
    };

    _.addSubcategories = function (list) {
        Dom(_.node['rel_second']).addClass('width_50');
        if(typeof list === 'object') {
            App.inject('#relations_second', _.createList(list));
        }
    };

    /**
     * @namespace App.Action.Relations.close
     */
    _.close = function() {
        _.node['rel_window'].style.display = 'none';
    };

    _.createList = function(list) {
        var ul = Util.createElement('ul');

        Util.each(list, function(item) {
            ul.appendChild(Util.createElement('li', {
                'data-id' : item['id'],
                'data-link' : item['link'],
                'data-title' : item['title'],
                'data-deep' : item['deep']
            }, item['title']));
        });

        return ul;
    };

    _.dataSelect = {first:null,second:null};
    /**
     * @namespace App.Action.Relations.enableEvents
     */
    _.enableEvents = function(){

        // Linker events
        Linker.refresh();


        Linker.click('relations_first', function(event) {
            var target = event.target;
            var id = target.getAttribute('data-id'),
                link = target.getAttribute('data-link');

            Dom('li', target.parentNode).removeClass('selected_relation');
            Dom(target).addClass('selected_relation');

            App.Catch.put('relation_first', {
                target : event.target,
                id : id,
                data: App.Catch.get('categories').filter(function(a){return a.id == id})[0]
            });

            if(_.deep > 2) {
                App.Api.request('getsubcategories', function (data) {
                    _.subcategories = data['subcategories'];
                    _.addSubcategories(data['subcategories'])
                } , {link:link} );
            }
        });


        Linker.click('relations_second', function(event){
            var target = event.target;
            var id = target.getAttribute('data-id'),
                link = target.getAttribute('data-link');

            Dom('li', target.parentNode).removeClass('selected_relation');
            Dom(target).addClass('selected_relation');

            App.Catch.put('relation_second', {
                target : event.target,
                id : id,
                data: _.subcategories.filter(function(a){return a.id == id})[0]
            });

        });

        Linker.click('relations_btn', function(event) {

            var link = event.target.getAttribute('data-link');

            if(link == 'cancel') _.close();
            if(link == 'confirm') {

                var relfirst = App.Catch.get('relation_first')['data'];

                if(_.deep == 2 && _.countItems() < 1) {
                    _.node['rel_items'].appendChild(_.createItemElement(relfirst.title, relfirst.id));
                }
                else if(_.deep == 3) {
                    var relsecond = App.Catch.get('relation_second')['data'];
                    _.node['rel_items'].appendChild(_.createItemElement(relfirst.title +' > '+ relsecond.title, relsecond.id));

                }
                _.close();
            }
        });

    };



    /**
     * @namespace App.Action.Relations.createItem
     *
     * @param desc
     * @param id
     * @returns {Element}
     */
    _.createItemElement = function(desc, id) {

        id = id || 0;

        var
            item = Util.createElement('div', {'class': 'relation_item tbl', 'data-id': id}),
            icon = Util.createElement('i', {'class': 'icon-cancel'}),
            cell_ico = Util.createElement('div', {'class': 'tbl_cell'}),
            cell_desc = Util.createElement('div', {'class': 'tbl_cell'}, desc);

        icon.addEventListener('click', _.onRemoveItemElement, false);
        cell_ico.appendChild(icon);
        item.appendChild(cell_ico);
        item.appendChild(cell_desc);
        return item;
    };


    _.onRemoveItemElement = function(event) {
        var target = event.target,
            item = target.parentNode.parentNode
            ;

        console.log(item);

        target.removeEventListener('click', _.onRemoveItemElement, false);
        item.parentNode.removeChild(item)
    };

    _.countItems = function() {
        var allItems =  Dom('.relation_item', _.node['rel_items']).all();
        return Util.isArr(allItems) ? allItems.length : 0;
    };

    return _;
})}