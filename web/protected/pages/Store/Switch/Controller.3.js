/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new BPCPageJs(), {
	load: function() {
		var tmp = {};
		tmp.me = this;

		tmp.me.getStoreList($(tmp.me._preData.containerId), tmp.me._preData.stores);

		return tmp.me;
	}
	,getStoreList: function(container, stores) {
		var tmp = {};
		tmp.me = this;
		tmp.container = (container || null);
		tmp.stores = (stores || []);

		if(!tmp.container)
			return tmp.me;

		tmp.container.insert({'bottom': tmp.listGroup = new Element('div').addClassName('list-group') });

		tmp.stores.each(function(item){
			tmp.listGroup.insert({'bottom': new Element('a', {'href': 'javascript:void(0)', 'class': 'list-group-item', 'store_id': item.id, 'role_id': item.role.id, 'title': 'Switch to this store'})
				.addClassName((item.selected && item.selected === true) ? 'active' : '')
				.update(
					new Element('div', {'class': 'row'})
						.insert({'bottom': new Element('div', {'class': 'col-sm-8'}).update(item.name)})
						.insert({'bottom': new Element('div', {'class': 'col-sm-4 text-right'}).update(item.role.name)})
				)
				.observe('click', function(e){
					tmp.btn = $(this);
					if(tmp.btn.hasClassName('active'))
						return tmp.me;
					tmp.storeId = tmp.btn.readAttribute('store_id');
					tmp.roleId = tmp.btn.readAttribute('role_id');
					if(!tmp.storeId || tmp.storeId === '' || tmp.storeId == 0)
						return tmp.me;
					if(!tmp.roleId || tmp.roleId === '' || tmp.roleId == 0)
						return tmp.me;
					tmp.me.switchStore(tmp.storeId, tmp.roleId);
				})
			});
		});
	}
	,switchStore: function(storeId, roleId) {
		var tmp = {};
		tmp.me = this;
		tmp.me._disableAll();
		tmp.me.postAjax(tmp.me.getCallbackId('switchStore'), {'storeId': storeId, 'roleId': roleId}, {
			'onComplete': function() {
				console.debug('test');
//				location.reload(true); // force ignore browser cache
			}
		});
		return tmp.me;
	}
});