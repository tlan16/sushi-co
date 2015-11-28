/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new CRUDPageJs(), {
	init: function() {
		var tmp = {};
		tmp.me = this;
		
		tmp.me._bindSubmitButton();
		
		return tmp.me;
	}
	,_bindSubmitButton: function() {
		var tmp = {};
		tmp.me = this;
		tmp.btn = $('item-list').up('.panel').down('[type="submit"]');
		if(!tmp.btn)
			return tmp.me;
		tmp.btn.observe('click', function(){
			if(tmp.btn.readAttribute('disabled'))
				return tmp.me;
			tmp.btn.writeAttribute('disabled', true);
			tmp.me._submit(tmp.me._collectData());
		});
		return tmp.me;
	}
	,_submit: function(data) {
		var tmp = {};
		tmp.me = this;

		tmp.me.postAjax(tmp.me.getCallbackId('stocktake'), data, {
			'onSuccess': function (sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if (tmp.result && tmp.result.email && tmp.result.asset) {
						tmp.me.showModalBox('Success', '<b class="success">An email will be send to :' + tmp.result.email + '</b>With an attached excel: <a href="' + tmp.result.asset.url + '" target="__BLANK">' + tmp.result.asset.filename + '</a>' );
					}
				} catch (e) {
					tmp.me.showModalBox('Error', '<pre>' + e + '</pre>');
				}
			}
			,'onComplete': function() {
			}
		});
		return tmp.me;
	}
	,_collectData: function() {
		var tmp = {};
		tmp.me = this;
		tmp.data = [];
		$('item-list-body').getElementsBySelector('.item_row[item_id]').each(function(row){
			tmp.rowData = tmp.me._collectFormData(row, 'save-item');
			tmp.rowData.item = row.retrieve('data');
			tmp.data.push(tmp.rowData);
		});
		return tmp.data;
	}
	,_getTitleRowData: function() {
		this._titleRowData.serverMeasurement = {'ServeMeasurement': {'name': 'Server Measurement'}};
		this._titleRowData.unitPrice = 'Unit Price';
		return this._titleRowData;
	}
	,_getInput: function(saveItem) {
		var tmp = {};
		tmp.me = this;
		tmp.newDiv = new Element('input', {'save-item': saveItem, 'type': 'number'}).setStyle('width: 100%');
		return tmp.newDiv;
	}
	,_getResultRow: function(row, isTitle) {
		var tmp = {};
		tmp.me = this;
		tmp.isTitle = (isTitle || false);
		tmp.tag = (tmp.isTitle === true ? 'strong' : 'span');
		tmp.row = new Element('span', {'class': 'row'})
			.store('data', row)
			.addClassName( (row.active === false && tmp.isTitle === false ) ? 'warning' : '')
			.addClassName('list-group-item')
			.addClassName('item_row')
			.writeAttribute('item_id', row.id)
			.insert({'bottom': new Element(tmp.tag, {'class': 'name col-sm-5 col-xs-12', 'title': row.description}).update(row.name) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'serverMeasurement col-sm-3 col-xs-12'}).update(row.serverMeasurement.ServeMeasurement.name) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'stocktakeShop col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? 'Stocktake QTY (Shop)' : tmp.me._getInput('stocktakeShop')) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'stocktakeStoreRoom col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? 'Stocktake QTY (Store Room)' : tmp.me._getInput('stocktakeStoreRoom')) })
		;
		return tmp.row;
	}
});