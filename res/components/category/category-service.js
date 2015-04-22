angular.module('owiki')
        .service('categorySvc', function () {

            this.parseCategories = function (categories) {
                var parsedCategories = [];

                var fetchSubCategories = function (category, level) {
                    var parentLevel = level;
                    
                    parsedCategories.push({
                        id: category.id,
                        name: getLevelStr(level) + category.name,
                        level: level
                    });
                    
                    level++;

                    for (var c = 0; c < category.categories.length; c++) {
                        fetchSubCategories(category.categories[c], level);
                    }
                    level = parentLevel;
                };
                
                var getLevelStr = function(level) {
                    if(level <= 0) {
                        return '';
                    } else {
                        var str = '|';
                        for(var s = 0; s < level; s++) {
                            str += '-';
                        }
                        str += ' ';
                        return str;
                    }
                };

                for (var c = 0; c < categories.length; c++) {
                    var category = categories[c];
                    var level = 0;
                    fetchSubCategories(category, level);
                }
                
                return parsedCategories;
            };
            
            this.getUpperLevel = function(categories, category) {
                var upperOnly = [];
                var level = 0;
                
                for (var l = 0; l < categories.length; l++) {
                    if(categories[l].id == category.id) {
                        level = categories[l].level;
                        break;
                    }
                }
                
                for (var c = 0; c < categories.length; c++) {
                    console.log(categories[c], categories[c].level, level);
                    if(categories[c].level < level) {
                        upperOnly.push(categories[c]);
                    }
                }
                
                return upperOnly;
            };

        });