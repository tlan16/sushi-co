/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new DetailsPageJs(), {
	_nutritions: []
	,_serveMeasurements: []
	,setNutrition: function(nutritions) {
		var tmp = {};
		tmp.me = this;
		tmp.me._nutritions = nutritions
		return tmp.me;
	}
	,setServeMeasurements: function(measurements) {
		var tmp = {};
		tmp.me = this;
		tmp.me._serveMeasurements = measurements
		return tmp.me;
	}
	,load: function () {
		var tmp = {};
		tmp.me = this;
		tmp.me._init();

		$(tmp.me.getHTMLID('itemDiv')).addClassName('row');
		tmp.me
			._getInputDiv('name', (tmp.me._item.name || ''), $(tmp.me._containerIds.name), null ,true)
			._getInputDiv('description', (tmp.me._item.description || ''), $(tmp.me._containerIds.description))
			._getSelect2Div('Ingredient', 'ingredients', tmp.me._item.id ? tmp.me._item.infos.ingredients : [], $(tmp.me._containerIds.ingredients), null)
			._getSaveBtn()
		;

		tmp.me._addNewNutritionBtn($(tmp.me._containerIds.new_material_nutrition));

		if(tmp.me._item && tmp.me._item.infos) {
			tmp.me._item.infos.material_nutrition.each(function(item){
				tmp.me._addNutritionRow(item, $(tmp.me._containerIds.material_nutrition));
			});
		}

		tmp.me._fillDefautNutrition();
		return tmp.me;
	}
	,_fillDefautNutrition: function() {
		var tmp = {};
		tmp.me = this;
		tmp.me._nutritions.each(function(item) {
			if(tmp.me._checkNutritionExist(item.id) !== true) {
				tmp.me._addNutritionRow({'nutrition': item, 'serveMeasurement': item.defaultServeMeasurement, 'qty': 0, 'active': true}, $(tmp.me._containerIds.material_nutrition));
			}
		});
		return tmp.me;
	}
	,_checkNutritionExist: function(nutritionId) {
		var tmp = {};
		tmp.me = this;
		tmp.result = false;
		$(tmp.me.getHTMLID('itemDiv')).getElementsBySelector('.material_nutrition[material_nutrition_id]').each(function(item){
			if(tmp.result === true)
				return tmp.result;
			tmp.material_nutrition = tmp.me._collectFormData($(item), 'save-item');
			if(tmp.material_nutrition && tmp.material_nutrition.nutrition && parseInt(nutritionId) === parseInt(tmp.material_nutrition.nutrition))
				tmp.result = true;
		});
		return tmp.result;
	}
	,_addNewNutritionBtn: function(container) {
		var tmp = {};
		tmp.me = this;
		tmp.container = (container || null);
		if(!tmp.container || !tmp.container.id)
			return tmp.me;
		tmp.newBtn = new Element('button', {'class': 'newNutritionBtn btn btn-primary btn-sm'})
			.update('New Nutrition')
			.observe('click', function(e){
				tmp.newBtn.writeAttribute('disabled', true);
				tmp.container.insert({'bottom': tmp.newDiv = new Element('div')});
				tmp.me._signRandID(tmp.newDiv);
				tmp.me._addNutritionRow(null, tmp.newDiv);
				tmp.newBtn.writeAttribute('disabled', false);
			})
			;

		tmp.container.update(tmp.me._getFormGroup('', tmp.newBtn).addClassName('col-xs-12'));
		return tmp.me;
	}
	,_getNutritionRowDeleteBtn: function(material_nutrition, className) {
		var tmp = {};
		tmp.me = this;
		tmp.material_nutrition = (material_nutrition || null);
		tmp.active = (material_nutrition ? material_nutrition.active === true : true);
		tmp.className = (className || '');

		tmp.deleteBtn = new Element('button', {'class': (tmp.active === true ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success') })
			.addClassName(tmp.className)
			.insert({'bottom': new Element('i', {'class': (tmp.active === true ? 'glyphicon glyphicon-trash' : 'glyphicon glyphicon-repeat')}) })
			.observe('click', function(e){
				if(confirm('This ' + (tmp.material_nutrition ? '' : 'newly added ') + 'nutrition will be REMOVED, continue?')) {
					tmp.panel = tmp.deleteBtn.up('.material_nutrition');
					if(tmp.material_nutrition && tmp.material_nutrition.id) {
						tmp.panel.up().insert({'bottom': new Element('input', {'type': 'hidden', 'save-item': 'ignore_' + tmp.material_nutrition.id, 'dirty': true}) });
					}
					tmp.panel.remove();
					tmp.me._refreshDirty()._getSaveBtn();
				}
			})
			;
		return tmp.deleteBtn;
	}
	,_addNutritionRow: function(material_nutrition, container) {
		var tmp = {};
		tmp.me = this;
		tmp.material_nutrition = (material_nutrition || null);
		tmp.container = (container || null);
		if(!tmp.container || !tmp.container.id)
			return tmp.me;
		console.debug(tmp.material_nutrition);
		tmp.container
			.insert({'bottom': tmp.row = new Element('div', {'class': 'material_nutrition col-xs-12', 'material_nutrition_id': ((tmp.material_nutrition && tmp.material_nutrition.id) ? tmp.material_nutrition.id : 'new'), 'active': (tmp.material_nutrition ? tmp.material_nutrition.active : true) })
				.insert({'bottom': new Element('div', {'class': 'row '})
					.insert({'bottom': tmp.nutrition = new Element('div', {'class': 'nutrition col-md-7 col-sm-4 col-xs-12'}) })
					.insert({'bottom': tmp.qty = new Element('div', {'class': 'qty col-md-2 col-sm-3 col-xs-12'}) })
					.insert({'bottom': tmp.servemeasurement = new Element('div', {'class': 'servemeasurement col-md-2 col-sm-3  col-xs-12'}) })
					.insert({'bottom': new Element('div', {'class': 'pull-right text-right col-md-1 col-sm-1 col-xs-12'}).update(tmp.me._getNutritionRowDeleteBtn(tmp.material_nutrition, 'col-xs-12')) })
				})
			});

		tmp.me
			._getSelectDiv('nutrition', tmp.me._nutritions, (tmp.material_nutrition && tmp.material_nutrition.nutrition ? tmp.material_nutrition.nutrition.id : ''), tmp.row.down('.nutrition'), ' ', true)
			._getInputDiv('qty', (tmp.material_nutrition ? tmp.material_nutrition.qty : ''), tmp.qty, ' ' , false, '', false, 'Qty')
			._getSelectDiv('serveMeasurement', tmp.me._serveMeasurements, (tmp.material_nutrition && tmp.material_nutrition.serveMeasurement ? tmp.material_nutrition.serveMeasurement.id : ''), tmp.row.down('.servemeasurement'), ' ', true)
		;
		return tmp.me;
	}
	,collectData: function() {
		var tmp = {};
		tmp.me = this;
		tmp.data = tmp.me._collectFormData($(tmp.me.getHTMLID('itemDiv')), 'save-item');
		if(!tmp.data)
			return null;
		tmp.data['material_nutrition'] = [];
		$(tmp.me.getHTMLID('itemDiv')).getElementsBySelector('.material_nutrition[material_nutrition_id]').each(function(item){
			tmp.material_nutrition = tmp.me._collectFormData($(item), 'save-item');
			if(tmp.material_nutrition)
				tmp.data['material_nutrition'].push(tmp.material_nutrition);
		});

		return tmp.data;
	}
});