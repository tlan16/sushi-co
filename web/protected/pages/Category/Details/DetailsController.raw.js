/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new DetailsPageJs(), {
    load: function () {
        var tmp = {};
        tmp.me = this;
        tmp.me._init();

        $(tmp.me.getHTMLID('itemDiv')).addClassName('row');
        tmp.me
            ._getInputDiv('name', (tmp.me._item.name || ''), $(tmp.me._containerIds.name), null ,true)
            ._getInputDiv('description', (tmp.me._item.description || ''), $(tmp.me._containerIds.description))
            ._getInputDiv('position', (tmp.me._item.position || 0), $(tmp.me._containerIds.position))
            ._getSaveBtn()
        ;
        return tmp.me;
    }
});