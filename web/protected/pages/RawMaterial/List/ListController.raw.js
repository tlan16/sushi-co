/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new CRUDPageJs(), {
	_getTitleRowData: function() {
		this._titleRowData.serverMeasurement = {'ServeMeasurement': {'name': 'Server Measurement'}};
		this._titleRowData.unitPrice = 'Unit Price';
		this._titleRowData.showInPlaceOrder = this.ucfirst(this.decamelize('showInPlaceOrder'));
		this._titleRowData.showInStockTake = this.ucfirst(this.decamelize('showInStockTake'));
		return this._titleRowData;
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
			.insert({'bottom': new Element(tmp.tag, {'class': 'name col-sm-2 col-xs-12'}).update(row.name) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'description col-sm-2 col-xs-12'}).update(row.description) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'serverMeasurement col-sm-2 col-xs-12'}).update(row.serverMeasurement.ServeMeasurement.name) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'unitPrice col-sm-1 col-xs-12'}).update(tmp.isTitle ? row.unitPrice : accounting.formatMoney(row.unitPrice)) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'position col-sm-1 hidden-xs'}).update(row.position) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'position col-sm-1 hidden-xs'}).update( tmp.isTitle ? row.showInPlaceOrder :
				new Element('input', {'disabled': true, 'type': 'checkbox', 'checked': row.showInPlaceOrder})
			) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'position col-sm-1 hidden-xs'}).update( tmp.isTitle ? row.showInStockTake :
				new Element('input', {'disabled': true, 'type': 'checkbox', 'checked': row.showInStockTake})
			) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'text-right btns col-sm-2 col-xs-12'}).update(
				tmp.isTitle === true ?
					(new Element('span', {'class': 'btn btn-primary btn-xs', 'title': 'New'})
							.insert({'bottom': new Element('span', {'class': 'glyphicon glyphicon-plus'}) })
							.insert({'bottom': ' NEW' })
							.observe('click', function(){
								tmp.me._openDetailsPage();
							})
					)
					:
					(new Element('span', {'class': 'btn-group btn-group-xs'})
							.insert({'bottom': tmp.editBtn = new Element('span', {'class': 'btn btn-primary', 'title': 'Delete'})
								.insert({'bottom': new Element('span', {'class': 'glyphicon glyphicon-pencil'}) })
								.observe('click', function(){
									tmp.me._openDetailsPage(row);
								})
							})
							.insert({'bottom': new Element('span')
								.addClassName( (row.active === false && tmp.isTitle === false ) ? 'btn btn-success' : 'btn btn-danger')
								.writeAttribute('title', ((row.active === false && tmp.isTitle === false ) ? 'Re-activate' : 'De-activate') )
								.insert({'bottom': new Element('span')
									.addClassName( (row.active === false && tmp.isTitle === false ) ? 'glyphicon glyphicon-repeat' : 'glyphicon glyphicon-trash')
								})
								.observe('click', function(){
									if(!confirm('Are you sure you want to ' + (row.active === true ? 'DE-ACTIVATE' : 'RE-ACTIVATE') +' this item?'))
										return false;
									tmp.me._deleteItem(row, row.active);
								})
							})
					)
			) })
		;
		return tmp.row;
	}
});