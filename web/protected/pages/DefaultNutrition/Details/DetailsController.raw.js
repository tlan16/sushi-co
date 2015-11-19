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
		tmp.nutritionOptions = {
				width: "100%",
				ajax: {
					delay: 250
					,url: '/ajax/getAll'
					,type: 'GET'
					,data: function (params) {
						return {"searchTxt": 'name like ?', 'searchParams': ['%' + params + '%'], 'entityName': 'Nutrition', 'pageNo': 1};
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
		tmp.serveMeasurementOptions = {
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
		tmp.me
			._getSelect2Div('Nutrition', 'nutrition', (tmp.me._item.nutrition ? {'id': tmp.me._item.nutrition.id, 'text': tmp.me._item.nutrition.name, 'data': tmp.me._item.nutrition} : null), $(tmp.me._containerIds.nutrition), null, true, tmp.nutritionOptions)
			._getSelect2Div('ServeMeasurement', 'serveMeasurement', (tmp.me._item.serveMeasurement ? {'id': tmp.me._item.serveMeasurement.id, 'text': tmp.me._item.serveMeasurement.name, 'data': tmp.me._item.serveMeasurement} : null), $(tmp.me._containerIds.serveMeasurement), 'Serve Measurement', true, tmp.serveMeasurementOptions)
			._getInputDiv('description', (tmp.me._item.description || ''), $(tmp.me._containerIds.description), null)
			._getSaveBtn()
		;
		return tmp.me;
	}
});