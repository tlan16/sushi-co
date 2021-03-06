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
		
		// validate EMAIL RECEIPIENTS
		tmp.value = row.value;
		if(row.type === tmp.me.preData.TYPE_EMAIL_RECEIPIENTS) {
			tmp.tmp = tmp.value.split(";");
			tmp.value = "";
			tmp.hasError = false;
			tmp.tmp.each(function(email){
				tmp.value += "<span" + (tmp.me.validateEmail(email) ? '' : ' class="text-danger"') + ">" + email + "</span><br/>";
				if(!tmp.me.validateEmail(email))
					tmp.hasError = true;
			});
			if(tmp.hasError)
				tmp.value += "<br/><i class='glyphicon glyphicon-warning-sign text-danger'>  possible error in the email addresses</i>"
		}
			
		tmp.row = new Element('span', {'class': 'row'})
			.store('data', row)
			.addClassName( (row.active === false && tmp.isTitle === false ) ? 'warning' : '')
			.addClassName('list-group-item')
			.addClassName('item_row')
			.writeAttribute('item_id', row.id)
			.insert({'bottom': new Element(tmp.tag, {'class': 'type col-sm-2 col-xs-12'}).update(row.type) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'value col-sm-2 col-xs-12'}).setStyle('word-break: break-all').update(tmp.value) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'description col-sm-2 col-xs-12'}).update(row.description) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'created col-sm-2 col-xs-12'}).update(row.created) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'updated col-sm-2 col-xs-12'}).update(row.updated) })
			.insert({'bottom': new Element(tmp.tag, {'class': 'text-right btns col-sm-2 col-xs-12'}).update(
				tmp.isTitle === true ?  
					(new Element('span', {'class': 'btn btn-primary btn-xs hidden', 'title': 'New'})
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