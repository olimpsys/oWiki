angular.module('owiki')
        .service('apiSvc', function ($http, $cookies) {

            this.restApiUrl = 'api';

            //cookie control ---------------------------------------------------

            this.setAccessToken = function (jwt, persist) {
                //$cookies['accesstoken'] = jwt;
                if(!persist) {
                    $cookies.put('accesstoken', jwt);
                } else {
                    var exp = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate()+14);
                    $cookies.put('accesstoken', jwt, {
                        expires: exp
                    });
                }
            };

            this.getAccessToken = function () {
                //return $cookies['accesstoken'];
                return $cookies.get('accesstoken');
            };

            this.removeAccessToken = function () {
                //delete $cookies['accesstoken'];
                $cookies.remove('accesstoken');
            };
            
            //user -------------------------------------------------------------

            this.getUser = function (id) {
                return this.doRequest('/user.php', 'GET', {
                    id: id
                });
            };
            
            this.getUsers = function () {
                return this.doRequest('/users.php');
            };
            
            this.saveUser = function (id, name, email, password, isAdmin, isActive) {
                return this.doRequest('/user.php', 'POST', {
                    id: id,
                    name: name,
                    email: email,
                    password: password,
                    isAdmin: isAdmin,
                    isActive: isActive
                });
            };
            
            this.login = function (email, password) {
                return this.doRequest('/login.php', 'POST', {
                    email: email,
                    password: password
                });
            };
            
            //recent activity --------------------------------------------------
            
            this.getDashboard = function() {
                return this.doRequest('/dashboard.php');
            };
            
            //category ---------------------------------------------------------
            
            this.getCategories = function(output) {
                return this.doRequest('/categories.php', 'GET', {
                    output: output
                });
            };
            
            this.getCategory = function(id) {
                return this.doRequest('/category.php', 'GET', {
                    id: id
                });
            };
            
            this.saveCategory = function(name, parent, id) {
                return this.doRequest('/category.php', 'POST', {
                    id: id,
                    name: name,
                    parent: parent
                });
            };
            
            this.deleteCategory = function(id) {
                return this.doRequest('/category.php', 'POST', {
                    id: id,
                    deleteCategory: true
                });
            };
            
            //page -------------------------------------------------------------
            
            this.savePage = function(id, title, content, categoryId) {
                return this.doRequest('/page.php', 'POST', {
                    id: id,
                    title: title,
                    content: content,
                    categoryId: categoryId
                });
            };
            
            this.getPage = function(id) {
                return this.doRequest('/page.php', 'GET', {
                    id: id
                });
            };
            
            this.deletePage = function(id) {
                return this.doRequest('/page.php', 'POST', {
                    id: id,
                    deletePage: true
                });
            };
            
            //user -------------------------------------------------------------

            this.doSearch = function (query) {
                return this.doRequest('/search.php', 'GET', {
                    query: query
                });
            };

            //common functions -------------------------------------------------

            this.doRequest = function (endpoint, method, data) {

                var req = {
                    method: method,
                    url: this.restApiUrl + endpoint
                };

                req.method = method || 'GET';

                if (data) {
                    if (method == 'GET') {
                        req.params = data;
                    } else if (method == 'POST') {
                        req.data = data;
                    }
                }

                return $http(req);
            };

        });