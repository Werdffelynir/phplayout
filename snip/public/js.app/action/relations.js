/**
 * @type NamespaceApplication App
 */
if(App.namespace){App.namespace('Action.Relations', function(App) {

    /**
     * @namespace App.Action.Relations
     */
    var _ = {
        node:{}
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

        // Elements nodes
        _.node['rel_first'] = App.query('#relations_first');
        _.node['rel_second'] = App.query('#relations_second');
        _.node['rel_window'].style.display = 'block';

        if(injectData['categories']) {
            App.inject('#relations_first', _.createList(injectData['categories']));
        }
        if(injectData['subcategories']) {

        }

        Dom('li', _.node['rel_window']).removeClass('selected_relation');
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
            Dom(_.node['rel_second']).addClass('width_50');
            console.log(link);
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