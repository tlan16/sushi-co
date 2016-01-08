/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new DetailsPageJs(), {
	load: function () {
		var tmp = {};
		tmp.me = this;
		tmp.me._init();
		tmp.serverMeasurement = ((tmp.me._item.id && tmp.me._item.serverMeasurement && tmp.me._item.serverMeasurement.ServeMeasurement ) ? tmp.me._item.serverMeasurement.ServeMeasurement : null);
		tmp.serveMeasurementSelect2Options = {
			multiple: false,
			width: "100%",
			ajax: {
				delay: 250
				,url: '/ajax/getAll'
				,type: 'GET'
				,data: function (params) {
					return {"searchTxt": 'name like ?', 'searchParams': ['%' + params + '%'], 'entityName': 'ServeMeasurement', 'pageNo': 1};
				}
				,results: function(data, page, query) {
					tmp.result = [];
					if(data.resultData && data.resultData.items) {
						data.resultData.items.each(function(item){
							tmp.result.push({'id': item.id, 'text': item.name, 'data': item});
						});
					}
					return { 'results' : tmp.result };
				}
			}
			,cache: true
			,escapeMarkup: function (markup) { return markup; } // let our custom formatter work
		};

		$(tmp.me.getHTMLID('itemDiv')).addClassName('row');
		tmp.me
			._getInputDiv('name', (tmp.me._item.name || ''), $(tmp.me._containerIds.name), null ,true)
			._getInputDiv('description', (tmp.me._item.description || ''), $(tmp.me._containerIds.description))
			._getSelect2Div('ServeMeasurement', 'serveMeasurement', (tmp.serverMeasurement ? {'id': tmp.serverMeasurement.id, 'text': tmp.serverMeasurement.name, 'data': tmp.serverMeasurement} : null), $(tmp.me._containerIds.serverMeasurement), 'Serve Measurement', true, tmp.serveMeasurementSelect2Options)
			._getInputDiv('unitPrice', (tmp.me._item.unitPrice || ''), $(tmp.me._containerIds.unitPrice), 'Unit Price')
			._getInputDiv('position', (tmp.me._item.position || 0), $(tmp.me._containerIds.position), 'Position')
			._getInputDiv('showInPlaceOrder', (tmp.me._item.id ? tmp.me._item.showInPlaceOrder : true), $(tmp.me._containerIds.showInPlaceOrder), null, null, null, null, null, 'checkbox')
			._getInputDiv('showInStockTake', (tmp.me._item.id ? tmp.me._item.showInStockTake : true), $(tmp.me._containerIds.showInStockTake), null, null, null, null, null, 'checkbox')
			._getSaveBtn()
		;
		return tmp.me;
	}
	,collectData: function() {
		var tmp = {};
		tmp.me = this;
		tmp.data = tmp.me._collectFormData($(this.getHTMLID('itemDiv')), 'save-item');
		tmp.data.infoId = tmp.me._item.serverMeasurement ? tmp.me._item.serverMeasurement.id : null;
		return tmp.data;
	}
});