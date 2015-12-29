/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new CRUDPageJs(), {
	_preData: null
	,init: function() {
		var tmp = {};
		tmp.me = this;
		return tmp.me;
	}
	,getListingDev: function(data) {
		
	}
	,getListingTitles: function(data) {
		var tmp = {};
		tmp.me = this;
	}
	,getListingRow: function(row) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('div');
		
		return tmp.newDiv;
	}
});