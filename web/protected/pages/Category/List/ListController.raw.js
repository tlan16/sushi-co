/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new CRUDPageJs(), {
	_getResultRow: function(row, isTitle) {
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
			.insert({'bottom': new Element(tmp.tag, {'class': 'name col-sm-3 col-xs-12' + ( tmp.isTitle === true ? 'hidden-xs' :'')}).update(tmp.isTitle === true ? row.name : new Element('div')
				.insert({'bottom': new Element('div').update(row.name) })

			) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'name col-sm-7 col-xs-12' + ( tmp.isTitle === true ? 'hidden-xs' :'')}).insert({'bottom': new Element('i').update(row.description)}) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'text-right btns col-sm-2 col-xs-12'}).update(
				tmp.isTitle === true ? '' :
					(new Element('span', {'class': 'btn-group btn-group-sm'})
						.insert({'bottom': tmp.editBtn = new Element('span', {'class': 'btn btn-default', 'title': 'List of products'})
							.insert({'bottom': new Element('span', {'class': 'glyphicon glyphicon-th-list'}) })
							.observe('click', function(){
								tmp.myWindow = (window.parent || window);
								tmp.myWindow.location = '/products/category/' + row.id;
							})
						})
						.insert({'bottom': tmp.editBtn = new Element('span', {'class': 'btn btn-primary', 'title': 'Edit'})
							.insert({'bottom': new Element('span', {'class': 'glyphicon glyphicon-pencil'}) })
							.observe('click', function(){
								tmp.me._openDetailsPage(row);
							})
						})
						.insert({'bottom':  tmp.me._canEdit === false ? '' : new Element('span')
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