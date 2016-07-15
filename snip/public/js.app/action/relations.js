/**
 * @type NamespaceApplication App
 */
if(App.namespace){App.namespace('Action.Relations', function(App) {

    /**
     * @namespace App.Action.Relations
     */
    var _ = {
        node:{},
        injectData:{}
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
     * @param injectData
     */
    _.open = function(injectData) {

        _.injectData = injectData;

        // Elements nodes
        _.node['rel_first'] = App.query('#relations_first');
        _.node['rel_second'] = App.query('#relations_second');
        _.node['rel_window'].style.display = 'block';

        if(injectData['categories']) {
            App.inject('#relations_first', _.createList(injectData['categories']));
        }

        if (_.node['rel_second'].classList.contains('width_50'))
            Dom(_.node['rel_second']).removeClass('width_50');

        Dom('li', _.node['rel_window']).removeClass('selected_relation');
    };

    _.addSubcategories = function (list) {

        if(injectData['subcategories']) {
            App.inject('#relations_first', _.createList(list));
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

        Linker.click('relations_first', function(event){
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

            if(_.injectData['deep'] > 2) {
                Dom(_.node['rel_second']).addClass('width_50');
            }


            //console.log(link);
            App.Api.request('getsubcategories', function (data) {
                console.log('getsubcategories...', data);
            } , {link:link} );

        });

        Linker.click('relations_second', function(event){
            var target = event.target;
            var link = target.getAttribute('data-link');

            Dom('li', target.parentNode).removeClass('selected_relation');
            Dom(target).addClass('selected_relation');
            console.log(link);
        });

        Linker.click('relations_btn', function(event) {

            var link = event.target.getAttribute('data-link');

            if(link == 'cancel') _.close();
            if(link == 'confirm') {
                var parent = App.Catch.get('relation_first')['data'];
                _.node['rel_items'].appendChild(_.createItemElement(parent.title, false, parent.id));
                _.close();
            }
        });

    };



    /**
     * @namespace App.Action.Relations.createItem
     * @returns {Element}
     */
    _.createItemElement = function(cat, subcat, cat_id, subcat_id) {
        subcat = subcat || null;
        cat_id = cat_id || null;
        subcat_id = subcat_id || null;

        var
            item = Util.createElement('div', {'class': 'relation_item tbl'}),
            icon = Util.createElement('i', {'class': 'icon-cancel', 'data-cat': cat_id, 'data-subcat': subcat_id}),
            cell_ico = Util.createElement('div', {'class': 'tbl_cell'}),
            cell_desc = Util.createElement('div', {'class': 'tbl_cell'}, cat + (subcat ? ' > ' + subcat : '') );

        icon.addEventListener('click', _.onRemoveItemElement, false);
        cell_ico.appendChild(icon);
        item.appendChild(cell_ico);
        item.appendChild(cell_desc);
        return item;
    };


    _.onRemoveItemElement = function(event) {
        var item = null, target = event.target;
        target.removeEventListener('click', _.onRemoveItemElement, false);
        item = App.queryUp('.relation_item', target);
        item.parentNode.removeChild(item)
    };






    return _;
})}