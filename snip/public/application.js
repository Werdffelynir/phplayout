
var App = App || {};

(function(App){



    App.readyCallbacks = [];

    App.node = [];

    App.encodeLink = function(text){
        return encodeURIComponent(Util.toTranslit(text.trim()));
    };

    App.loaderContent = function(show){
        if(!!show) {
            var formSize = Util.getPosition(App.node['form']);
            if(Util.isObj(formSize)) {
                App.node['loader_content'].style.display = 'block';
                App.node['loader_content'].style.width = formSize.width + 'px';
            } else
                throw new Error("not find form")
        } else {
            App.node['loader_content'].style.display = 'none';
        }
    };

    App.ready = function(callback){
        if(typeof callback === 'function')
            App.readyCallbacks.push(callback);
    };

    /**
     * #info_panel
     #info_panel_title
     #info_panel_close
     #info_panel_content
     * @param values
     */
    App.infoPanel = function(values){

        if(!App.infoPanelElement) {
            App.infoPanelElement = Dom('#info_panel').one();

            if(!App.infoPanelElement) return;

            Dom('#info_panel_close').on('click', function(event){
                App.infoPanel(false);
            });

        }






        if(typeof values === 'object') {
            App.infoPanelElement.style.display = 'block';
            Dom('#info_panel_title').html(values.title || 'System Message');
            Dom('#info_panel_content').html(values.content || 'System Message Content');
        }else{
            App.infoPanelElement.style.display = 'none';
        }
    };
    App.infoPanelElement = null;

    document.addEventListener('DOMContentLoaded', onDOMContentLoaded);
    function onDOMContentLoaded(event){
        var iter = 0;
        while (iter < App.readyCallbacks.length) {
            App.readyCallbacks[iter].call(App);
            delete App.readyCallbacks[iter++];
        }
    }

    App.ready(function(){

        App.node['form'] = Dom('form[name=record]').one();
        App.node['loader_content'] = Dom('.loader_content').one();

        //Dom('input[name=type][value=3]').one().checked = true;
        Dom('.checkbox_type').each(function(elem){
            if(elem.classList.contains('active_type')){
                var selector = 'input[name=type][type=radio][value='+(elem.getAttribute('data-type'))+']';
                console.log(Dom(selector).all());
                //Dom().one().checked = true;
            }
        });

        Dom('.icon_btn').each(function(item, index){
            item.onclick = function(event){
                console.log(item, index);
            };
        });

        Dom('.checkbox_type').on('click', function(event){

            Dom('.checkbox_type').each(function(elem){
                elem.classList.remove('active_type');
            });

            var target = event.target;
            var type = target.getAttribute('data-type');
            target.classList.add('active_type');
            //Dom('input[name=type][value='+type+']').one().checked = true;
        });

        Dom('.action-new-record').on('click', function(event){
            console.log(event);
        });


        Dom('.action-remove-record').on('click', function(event){
            App.loaderContent(true);
            setTimeout(function(){
                App.loaderContent(false);
            },1000);
        });


        Dom('.action-save-record').on('click', function(event){
            var formData = Util.formData(App.node['form'], true);
            var error = null;

            App.loaderContent(true);

            if(typeof formData === 'object') {

                if(Util.isEmpty(formData.title)) {
                    error = 'Field "title" can`t be empty'
                }
                else if(Util.isEmpty(formData.link)) {
                    Dom('input[name=link]').one().value = formData.link = App.encodeLink(formData.title);
                }
                else if(Util.isEmpty(formData.type)) {
                    error = 'Field "type" can`t be empty'
                }
                else if(Util.isEmpty(formData.content)) {
                    error = 'Field "content" can`t be empty'
                }

                if(error) {
                    App.infoPanel({
                        title: 'Field entry error',
                        content: error
                    });
                }else{

                    /*Aj.post('/api/insert', formData, function(status, response){
                        var data = null;
                        try{
                            data = JSON.parse(response);
                            console.log(data);
                        } catch (error) {}

                        console.log(status, response);
                    });*/

                    console.log(formData);

                }
            }
            App.loaderContent(false);
        });









    });






})(App);