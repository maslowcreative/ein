(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://portal.ein.local',
            routes : [
    {
        "uri": "\/",
        "name": "index"
    },
    {
        "uri": "login",
        "name": "login"
    },
    {
        "uri": "logout",
        "name": "logout"
    },
    {
        "uri": "register",
        "name": "register"
    },
    {
        "uri": "password\/reset",
        "name": "password.request"
    },
    {
        "uri": "password\/email",
        "name": "password.email"
    },
    {
        "uri": "password\/reset\/{token}",
        "name": "password.reset"
    },
    {
        "uri": "password\/reset",
        "name": "password.update"
    },
    {
        "uri": "password\/confirm",
        "name": "password.confirm"
    },
    {
        "uri": "home",
        "name": "home"
    },
    {
        "uri": "my-account",
        "name": "my.account"
    },
    {
        "uri": "analytics",
        "name": "analytics"
    },
    {
        "uri": "plan-budget-allocations",
        "name": "provider.budget.allocation"
    },
    {
        "uri": "calim\/{claim}\/invoice\/download",
        "name": "claim.invoice.download"
    },
    {
        "uri": "plan\/{file_name}",
        "name": "plan.file.download"
    },
    {
        "uri": "job-test",
        "name": "job.test"
    },
    {
        "uri": "ajax\/users\/store",
        "name": "ajax."
    },
    {
        "uri": "ajax\/users\/representative\/{representative}\/participants",
        "name": "ajax.users.representative.participants"
    },
    {
        "uri": "ajax\/users\/{user}\/basic-info",
        "name": "ajax.users.update.basic.info"
    },
    {
        "uri": "ajax\/users\/{user}\/bank-info",
        "name": "ajax.users.update.bank.info"
    },
    {
        "uri": "ajax\/users\/status-toggle",
        "name": "ajax.user.status.toggle"
    },
    {
        "uri": "ajax\/users\/{user}\/representative\/update-auto-approval",
        "name": "ajax.user.representative.approval"
    },
    {
        "uri": "ajax\/users\/{user}\/upload-avatar",
        "name": "ajax.users.upload.avatar"
    },
    {
        "uri": "ajax\/users\/participant",
        "name": "ajax.participants.index"
    },
    {
        "uri": "ajax\/users",
        "name": "ajax.users.index"
    },
    {
        "uri": "ajax\/users",
        "name": "ajax.users.store"
    },
    {
        "uri": "ajax\/users\/{user}",
        "name": "ajax.users.show"
    },
    {
        "uri": "ajax\/users\/{user}",
        "name": "ajax.users.update"
    },
    {
        "uri": "ajax\/users\/{user}",
        "name": "ajax.users.destroy"
    },
    {
        "uri": "ajax\/providers\/remove-participants",
        "name": "ajax.providers.remove.participants"
    },
    {
        "uri": "ajax\/providers",
        "name": "ajax.providers.index"
    },
    {
        "uri": "ajax\/providers",
        "name": "ajax.providers.store"
    },
    {
        "uri": "ajax\/providers\/{provider}",
        "name": "ajax.providers.show"
    },
    {
        "uri": "ajax\/providers\/{provider}",
        "name": "ajax.providers.update"
    },
    {
        "uri": "ajax\/providers\/{provider}",
        "name": "ajax.providers.destroy"
    },
    {
        "uri": "ajax\/claims\/store",
        "name": "ajax."
    },
    {
        "uri": "ajax\/claims\/admin-store",
        "name": "ajax.claims.store.admin"
    },
    {
        "uri": "ajax\/claims\/{claim}\/representative-action",
        "name": "ajax.claims.representative.action"
    },
    {
        "uri": "ajax\/claims\/bulk-upload-file",
        "name": "ajax.claims.bulk.upload.file"
    },
    {
        "uri": "ajax\/claims\/quick-reconciliation",
        "name": "ajax.claims.quick.reconciliation"
    },
    {
        "uri": "ajax\/claims\/reconciled-results-file",
        "name": "ajax.claims.reconciled.results.file"
    },
    {
        "uri": "ajax\/claims\/recent-reconciliation-results-file",
        "name": "ajax.claims.recent.reconciliation.results.file"
    },
    {
        "uri": "ajax\/claims\/upload-reconciled-file",
        "name": "ajax.claims.upload.reconciled.file"
    },
    {
        "uri": "ajax\/claims\/list",
        "name": "ajax.claims.list"
    },
    {
        "uri": "ajax\/claims\/admin\/approved",
        "name": "ajax.claims.admin.approved"
    },
    {
        "uri": "ajax\/claims\/update-claim",
        "name": "ajax.claims.update"
    },
    {
        "uri": "ajax\/claims",
        "name": "ajax.claims.index"
    },
    {
        "uri": "ajax\/claims",
        "name": "ajax.claims.store"
    },
    {
        "uri": "ajax\/claims\/{claim}",
        "name": "ajax.claims.show"
    },
    {
        "uri": "ajax\/claims\/{claim}",
        "name": "ajax.claims.update"
    },
    {
        "uri": "ajax\/claims\/{claim}",
        "name": "ajax.claims.destroy"
    },
    {
        "uri": "ajax\/plans\/upload",
        "name": "ajax.plans.upload"
    },
    {
        "uri": "ajax\/plans\/spending-data",
        "name": "ajax.plans.spending.data"
    },
    {
        "uri": "ajax\/plans\/provider-spending-data",
        "name": "ajax.plans.provider.spending.data"
    },
    {
        "uri": "ajax\/plans\/provider-budget-allocation",
        "name": "ajax.budget.allocation"
    },
    {
        "uri": "ajax\/plans\/provider-budget-allocation",
        "name": "ajax.get.budget.allocation"
    },
    {
        "uri": "ajax\/plans",
        "name": "ajax.plans.index"
    },
    {
        "uri": "ajax\/plans",
        "name": "ajax.plans.store"
    },
    {
        "uri": "ajax\/plans\/{plan}",
        "name": "ajax.plans.show"
    },
    {
        "uri": "ajax\/plans\/{plan}",
        "name": "ajax.plans.update"
    },
    {
        "uri": "ajax\/plans\/{plan}",
        "name": "ajax.plans.destroy"
    },
    {
        "uri": "ajax\/services",
        "name": "ajax.services.index"
    },
    {
        "uri": "ajax\/services",
        "name": "ajax.services.store"
    },
    {
        "uri": "ajax\/services\/{service}",
        "name": "ajax.services.show"
    },
    {
        "uri": "ajax\/services\/{service}",
        "name": "ajax.services.update"
    },
    {
        "uri": "ajax\/services\/{service}",
        "name": "ajax.services.destroy"
    },
    {
        "uri": "ajax\/admin\/update-permissions",
        "name": "ajax.admins.update.permission"
    },
    {
        "uri": "ajax\/admins",
        "name": "ajax.admins.index"
    },
    {
        "uri": "ajax\/admins",
        "name": "ajax.admins.store"
    },
    {
        "uri": "ajax\/admins\/{admin}",
        "name": "ajax.admins.show"
    },
    {
        "uri": "ajax\/admins\/{admin}",
        "name": "ajax.admins.update"
    },
    {
        "uri": "ajax\/admins\/{admin}",
        "name": "ajax.admins.destroy"
    }
],
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

