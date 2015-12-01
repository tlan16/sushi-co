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
			._getInputDiv('type', (tmp.me._item.type || ''), $(tmp.me._containerIds.type), null ,true)
			._getInputDiv('value', (tmp.me._item.value || ''), $(tmp.me._containerIds.value), null ,true)
			._getInputDiv('description', (tmp.me._item.description || ''), $(tmp.me._containerIds.description))
			._getSaveBtn()
		;
		jQuery('input[save-item="type"]').prop('disabled', true);
		return tmp.me;
	}
});