
var App = App || {};

(function(App){


    App.Piece = new Piece({
        width: 300
    });

    App.readyCallbacks = [];

    App.url = location.origin+location.pathname;
    App.uri = location.pathname;

    App.node = [];

    App.encodeLink = function(text){
        return encodeURIComponent(Util.toTranslit(text.trim().toLowerCase()));
    };

    App.loaderContent = function(show){
        if(!!show) {
            var formSize = Util.getPosition(App.node['form']);
            if(Util.isObj(formSize)) {
                App.node['loader_content'].style.display = 'block';
                App.node['loader_content'].style.width = formSize.width + 'px';
            } else
                throw new Error("Not find form")
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

        var pieceChoice = App.Piece.create('rel_choice');

        // On Linker handler
        Linker.search();

        // Select relations
        Linker.click('rel_remove', function(event){
            console.log('rel_remove: ', event);
            pieceChoice.setTitle('Remove Relation');
            pieceChoice.setContent('?');
            pieceChoice.show();
        });

        Linker.click('rel_add_category', function(event){
            console.log('rel_add_category: ', event);

            Aj.post(App.uri+'api/all_category', {}, function(status, response){
                //console.log('response >>> ', status, response);
                var selectlist = Util.createElement('div', {'class': 'selectlist'}),
                    data = null;
                try{
                    data = JSON.parse(response);
                    if(data.result) {

                        var relations_content = contentChoiceRelations(data.result);

                        pieceChoice.setX(event.target.offsetLeft);
                        pieceChoice.setY(event.target.offsetTop - 5);
                        pieceChoice.setTitle('Choice relation for this record');
                        pieceChoice.setContent(relations_content.outerHTML);
                        pieceChoice.show();

                        pieceChoice.node.addEventListener('click', function(event){
                            if(event.target.getAttribute('data-category')){

                                event.target.style.backgroundColor = '#DDD';

                                Aj.post(App.uri+'api/all_subcategory/'+event.target.getAttribute('data-parent'), null, function(status, response){
                                    //console.log('response >>> ', status, response);
                                    try{
                                        var html = '';
                                        data = JSON.parse(response);
                                        if(data.result && data.result.length > 0) {

                                            var i = 0, ul = document.createElement('ul');

                                            while (i < data.result.length) {
                                                var li = document.createElement('li');
                                                li.setAttribute('data-subcategory', data.result[i]['id']);
                                                li.textContent = data.result[i]['title'];
                                                ul.appendChild(li);
                                                i ++;
                                            }

                                            ul.className = 'subcategories_list';

                                            html = ul.outerHTML;
                                        }
                                        pieceChoice.node.querySelector('#content_rel_right').innerHTML = html;
                                    } catch (error) {}
                                });
                            }

                            else if(event.target.getAttribute('data-subcategory')) {




                            }
                        });

                    }
                } catch (error) {}
            });
        });



    }


    function contentChoiceRelations(categories){
        var i = 0;
        var ul = document.createElement('ul');
        var html = document.createElement('div');
        var content = document.createElement('div');
        var left = document.createElement('div');
        var right = document.createElement('div');
        var bottom = document.createElement('div');
        var btnOk = document.createElement('button');
        var btnClose = document.createElement('button');

        content.className = 'tbl';
        left.className = right.className = 'tbl_cell width_50 valign_top';
        left.id = 'content_rel_left';
        right.id = 'content_rel_right';

        while (i < categories.length) {
            var li = document.createElement('li');
            li.setAttribute('data-category', categories[i]['id']);
            li.textContent = categories[i]['title'];
            ul.appendChild(li);
            i ++;
        }

        ul.className = 'categories_list';
        left.appendChild(ul);

        content.appendChild(left);
        content.appendChild(right);

        btnOk.textContent = 'Ok';
        bottom.appendChild(btnOk);
        btnClose.textContent = 'Close';
        bottom.appendChild(btnClose);

        html.appendChild(content);
        html.appendChild(bottom);
        return html;
    }


    App.ready(function(){

        App.node['form'] = Dom('form[name=edit_item]').one();
        App.node['loader_content'] = Dom('.loader_content').one();

        Dom('.checkbox_deep').each(function(elem){
            if(elem.classList.contains('active_deep')){
                var selector = 'input[name=deep][type=radio][value='+(elem.getAttribute('data-deep'))+']';
                console.log(Dom(selector).all());
                //Dom().one().checked = true;
            }
        });

        /*Dom('.icon_btn').each(function(item, index){
            item.onclick = function(event){
                console.log(item, index);
                if(event.target.classList.contains('action-create-relations')){}
                if(event.target.classList.contains('action-remove-relations')){}
            };
        });*/

        Dom('.checkbox_deep').on('click', function(event){

            Dom('.checkbox_deep').each(function(elem){
                elem.classList.remove('active_deep');
            });

            var target = event.target;
            var deep = target.getAttribute('data-deep');
            var selector = 'input[name="deep"][value="'+deep+'"]';

            target.classList.add('active_deep');

            Dom(selector).one().checked = true;
        });



        /*
        Dom('.action-new-record').on('click', function(event){
            console.log(event);
        });


        Dom('.action-remove-record').on('click', function(event){
            App.loaderContent(true);
            setTimeout(function(){
                App.loaderContent(false);
            },1000);
        });*/


        Dom('.action-save-record').on('click', function(event){
            var formData = Util.formData(App.node['form'], true);
            var error = null;

            console.log(formData);

            App.loaderContent(true);

            if(typeof formData === 'object') {

                if(Util.isEmpty(formData.title)) {
                    error = 'Field "title" can`t be empty'
                }
                else if(Util.isEmpty(formData.link)) {
                    Dom('input[name=link]').one().value = formData.link = App.encodeLink(formData.title);
                }
                else if(Util.isEmpty(formData.deep)) {
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

                    Aj.post(App.uri+'api/insert', formData, function(status, response){
                        var data = null;
                        console.log('response >>> ', status, response);
                        try{
                            data = JSON.parse(response);
                            if(data.error) {

                                App.infoPanel({
                                    title: 'Server error',
                                    content: data.error
                                });

                            }
                        } catch (error) {}
                    });
                }
            }
            App.loaderContent(false);
        });


    });


})(App);