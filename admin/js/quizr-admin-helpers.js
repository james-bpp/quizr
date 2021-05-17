const helpers = ( () => {

    let methods = {};

    methods.find_parent_by_tag_name = function(element, tagname){
        let parent = element;

        while( parent != null && parent.tagName !== tagname.toUpperCase() ){
            parent = parent.parentNode;
        }

        return parent;
    }

    return methods;

})();