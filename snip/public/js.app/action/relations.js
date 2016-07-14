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
        _.node['rel_window'] = App.query('#relations');
        _.enableEvents();
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
        var html = '';
        Util.each(list, function(item){
            html += '<li data-id="'+item['id']+'" data-link="'+item['link']+'">'+item['title']+'</li>';
        });
        return '<ul>'+html+'</ul>';
    };


    /**
     * @namespace App.Action.Relations.enableEvents
     */
    _.enableEvents = function(){

        // Linker events
        Linker.refresh();

        Linker.click('relations_first', function(event){
            var target = event.target;
            var link = target.getAttribute('data-link');

            Dom('li', target.parentNode).removeClass('selected_relation');
            Dom(target).addClass('selected_relation');

            if(_.injectData['deep'] > 2) {
                Dom(_.node['rel_second']).addClass('width_50');
            }

            App.Api.request('getsubcategories', function (data) {
                console.log(data);
            } , {link:link} );

            //console.log(link);
        });

        Linker.click('relations_second', function(event){
            var target = event.target;
            var link = target.getAttribute('data-link');

            Dom('li', target.parentNode).removeClass('selected_relation');
            Dom(target).addClass('selected_relation');
            console.log(link);
        });

        Linker.click('relations_btn', function(event){
            var link = event.target.getAttribute('data-link');
            console.log(link);
            if(link == 'cancel') _.close();
        });

    };


    return _;
})}