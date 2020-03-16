(function () {

    var laroute = (function () {

        var routes = {

            absolute: true,
            rootUrl: 'http://localhost:8000',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":"index","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/entrar","name":"auth.index","action":"SIEC\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"admin\/logar","name":"auth.login","action":"SIEC\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/meus-dados","name":"auth.personal-data","action":"SIEC\Http\Controllers\Auth\LoginController@getPersonalData"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/sair","name":"auth.logout","action":"SIEC\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"admin","name":"index","action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/usuarios","name":"users.index","action":"SIEC\Http\Controllers\UserController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/usuarios\/cadastrar","name":"users.create","action":"SIEC\Http\Controllers\UserController@create"},{"host":null,"methods":["POST"],"uri":"admin\/usuarios\/cadastrar","name":"users.store","action":"SIEC\Http\Controllers\UserController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/usuarios\/{id}\/editar","name":"users.edit","action":"SIEC\Http\Controllers\UserController@edit"},{"host":null,"methods":["POST"],"uri":"admin\/usuarios\/{id}","name":"users.update","action":"SIEC\Http\Controllers\UserController@update"},{"host":null,"methods":["DELETE"],"uri":"admin\/usuarios\/{id}","name":"users.destroy","action":"SIEC\Http\Controllers\UserController@destroy"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/inscricao","name":"subscriptions.index","action":"SIEC\Http\Controllers\SubscriptionController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/dev\/logs","name":null,"action":"\Rap2hpoutre\LaravelLogViewer\LogViewerController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/dev\/simulador\/{login}","name":null,"action":"SIEC\Http\Controllers\Dev\DevController@loginSimulator"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/dev\/phpinfo","name":null,"action":"Closure"},{"host":null,"methods":["GET","POST","HEAD"],"uri":"inicio","name":"public.index","action":"SIEC\Http\Controllers\PublicController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"inscricao\/{id}","name":"public.subscription.index","action":"SIEC\Http\Controllers\PublicController@subscription"},{"host":null,"methods":["POST"],"uri":"inscricao\/validar-documento","name":"public.subscription.validadeDocument","action":"SIEC\Http\Controllers\PublicController@validadeDocument"},{"host":null,"methods":["GET","HEAD"],"uri":"inscricao\/cadastrar\/{key}","name":"public.subscription.create","action":"SIEC\Http\Controllers\PublicController@create"},{"host":null,"methods":["POST"],"uri":"inscricao\/store","name":"public.subscription.store","action":"SIEC\Http\Controllers\PublicController@store"},{"host":null,"methods":["GET","HEAD"],"uri":"inscricao\/gerar-comprovante\/{id}","name":"public.subscription.generateReceipt","action":"SIEC\Http\Controllers\PublicController@generateReceipt"},{"host":null,"methods":["GET","HEAD"],"uri":"inscricao\/comprovante\/{key}","name":"public.subscription.finishing","action":"SIEC\Http\Controllers\PublicController@finishing"},{"host":null,"methods":["POST"],"uri":"inscricao\/confirmar","name":"public.subscription.confirm","action":"SIEC\Http\Controllers\PublicController@confirm"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/busca-certidao","name":"student.findIdentificationDocument","action":"SIEC\Http\Controllers\StudentController@findIdentificationDocument"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/busca-series\/{id}","name":"schoolGrade.findByProcess","action":"SIEC\Http\Controllers\SchoolGradeController@findByProcess"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/todas-escolas","name":"school.all","action":"SIEC\Http\Controllers\SchoolController@all"},{"host":null,"methods":["GET","HEAD"],"uri":"dev\/env","name":"dev.envindex","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@overview"},{"host":null,"methods":["POST"],"uri":"dev\/env\/add","name":"dev.envadd","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@add"},{"host":null,"methods":["POST"],"uri":"dev\/env\/update","name":"dev.envupdate","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@update"},{"host":null,"methods":["GET","HEAD"],"uri":"dev\/env\/createbackup","name":"dev.envcreatebackup","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@createBackup"},{"host":null,"methods":["GET","HEAD"],"uri":"dev\/env\/deletebackup\/{timestamp}","name":"dev.envdeletebackup","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@deleteBackup"},{"host":null,"methods":["GET","HEAD"],"uri":"dev\/env\/restore\/{backuptimestamp}","name":"dev.envrestore","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@restore"},{"host":null,"methods":["POST"],"uri":"dev\/env\/delete","name":"dev.envdelete","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@delete"},{"host":null,"methods":["GET","HEAD"],"uri":"dev\/env\/download\/{filename?}","name":"dev.envdownload","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@download"},{"host":null,"methods":["POST"],"uri":"dev\/env\/upload","name":"dev.envupload","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@upload"},{"host":null,"methods":["GET","HEAD"],"uri":"dev\/env\/getdetails\/{timestamp?}","name":"dev.envgetdetails","action":"Brotzka\DotenvEditor\Http\Controllers\EnvController@getDetails"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                if (this.absolute && this.isOtherHost(route)){
                    return "//" + route.host + "/" + uri + qs;
                }

                return this.getCorrectUrl(uri + qs);
            },

            isOtherHost: function (route){
                return route.host && route.host != window.location.hostname;
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if ( ! this.absolute) {
                    return url;
                }

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

