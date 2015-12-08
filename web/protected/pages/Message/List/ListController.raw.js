/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new CRUDPageJs(), {
	_getTitleRowData: function() {
		return jQuery.extend({}, this._titleRowData, {'type': "Type", 'from': 'From', 'to': 'To', 'subject': 'Subject', 'body': 'Body', 'status': 'Status', 'created': 'Created', 'updated': 'Updated'});
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
			.insert({'bottom': new Element(tmp.tag, {'class': 'type col-xs-1 col-xs-12'}).update(row.type) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'from col-xs-1 col-xs-12'}).update(row.from) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'to col-xs-1 col-xs-12'}).update(row.to) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'subject col-xs-1 col-xs-12'}).update(row.subject) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'body col-xs-3 col-xs-12'}).update(row.body) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'status col-xs-1 col-xs-12'}).update(row.status) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'created col-xs-2 col-xs-12'}).update(tmp.isTitle === true ? row.created : moment.utc(row.created).local()) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'updated col-xs-2 col-xs-12'}).update(tmp.isTitle === true ? row.updated : moment.utc(row.updated).local()) })
		;
		return tmp.row;
	}
});