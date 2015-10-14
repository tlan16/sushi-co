/**
 * The DetailsPageJs file
 */
var DetailsPageJs = new Class.create();
DetailsPageJs.prototype = Object.extend(new BPCPageJs(), {
	_item: null //the item we are dealing with
	,_dirty: false
	/**
	 * Getting a form group for forms
	 */
	,_getFormGroup: function (label, input, noFormControl) {
		return new Element('div', {'class': 'form-group form-group-sm'})
			.insert({'bottom': new Element('label').update(label) })
			.insert({'bottom': input.addClassName(noFormControl === true ? '' : 'form-control') });
	}
	,refreshParentWindow: function() {
		var tmp = {};
		tmp.me = this;
		if(!parent.window)
			return;
		tmp.parentWindow = parent.window;
		tmp.row = $(tmp.parentWindow.document.body).down('#' + tmp.parentWindow.pageJs.resultDivId + ' .item_row[item_id=' + tmp.me._item.id + ']');
		if(tmp.row) {
			tmp.row.replace(tmp.parentWindow.pageJs._getResultRow(tmp.me._item));
			if(!tmp.row.hasClassName('success'))
				tmp.row.addClassName('success');
		} else if($(tmp.parentWindow.document.body).down('#' + tmp.parentWindow.pageJs.resultDivId + ' #item-list-body')) {
			$(tmp.parentWindow.document.body).down('#' + tmp.parentWindow.pageJs.resultDivId + ' #item-list-body').insert({'top': tmp.parentWindow.pageJs._getResultRow(tmp.me._item) });
			if(tmp.totalEl = $(tmp.parentWindow.document.body).down('#' + tmp.parentWindow.pageJs.totalNoOfItemsId))
				tmp.totalEl.update(parseInt(tmp.totalEl.innerHTML) + 1);
		}
	}
	,_getSaveBtn:function() {
		var tmp = {};
		tmp.me = this;
		tmp.me._refreshDirty();
		if(!tmp.me._containerIds || !tmp.me._containerIds.saveBtn)
			return tmp.me;
		tmp.container = $(tmp.me._containerIds.saveBtn);
		if(!tmp.container)
			return tmp.me;
		tmp.save = new Element('i')
			.addClassName('btn btn-success btn-md')
			.update('Save')
			.observe('click',function(e){
				tmp.btn = $(this);
				tmp.data = tmp.me._collectFormData($(tmp.me.getHTMLID('itemDiv')), 'save-item');
				if(tmp.btn.readAttribute('disabled') === true || tmp.btn.readAttribute('disabled') === 'disabled' || tmp.data === null)
					return tmp.me;
				tmp.me._disableAll($(tmp.me.getHTMLID('itemDiv')));
				if(tmp.data === null)
					return tmp.me;
				if(tmp.me._item && tmp.me._item.id)
					tmp.data.id = tmp.me._item.id;
				tmp.me.saveItem(tmp.input, tmp.data);
			});
		tmp.cancel = new Element('i')
			.addClassName('btn btn-danger btn-md')
			.update('Cancel')
			.observe('click',function(e){
				tmp.me.closeFancyBox();
			});
		
		tmp.container.update('')
			.insert({'bottom': tmp.me._getFormGroup(tmp.title, tmp.save).addClassName('col-md-6') })
			.insert({'bottom': tmp.me._getFormGroup(tmp.title, tmp.cancel).addClassName('pull-right col-md-6') })
		;
		
		if(tmp.me._dirty === false)
			tmp.save.hide();
		return tmp.me;
	}
	,closeFancyBox:function () {
		if(parent.jQuery && parent.jQuery.fancybox)
			parent.jQuery.fancybox.close();
		return this;
	}
	,_getInputDiv:function(saveItem, value, container, title, required, className) {
		var tmp = {};
		tmp.me = this;
		tmp.title = (title || tmp.me.ucfirst(saveItem));
		tmp.required = (required === true);
		tmp.className = (className || 'col-md-12');
		
		if(!container.id)
			tmp.me._signRandID(container);
		tmp.container = $(container.id);
		if(!tmp.container)
			return;
		tmp.input = new Element('input')
			.writeAttribute({
				'required': tmp.required
				,'save-item': saveItem
				,'dirty': false
			})
			.setValue(value || '')
			.observe('keyup',function(e){
				tmp.input.writeAttribute('dirty', value !== $F(tmp.input));
				tmp.me._refreshDirty()._getSaveBtn();
			});
		
		tmp.container.update(tmp.me._getFormGroup(tmp.title, tmp.input).addClassName(tmp.className) );
		
		return tmp.me;
	}
	,_refreshDirty: function() {
		var tmp = {};
		tmp.me = this;
		
		tmp.dirty = false;
		$(tmp.me.getHTMLID('itemDiv')).getElementsBySelector('[save-item]').each(function(el){
			if(tmp.dirty === false && (el.readAttribute('dirty') === true || el.readAttribute('dirty') === 'true' || el.readAttribute('dirty') === 'dirty') )
				tmp.dirty = true;
		});
		
		tmp.me._dirty = tmp.dirty;
		return tmp.me;
	}
	,_getSelect2Div:function(searchEntityName, saveItem, value, container, title, required) {
		var tmp = {};
		tmp.me = this;
		tmp.title = (title || tmp.me.ucfirst(saveItem));
		tmp.required = (required === true);
		
		if(!container.id)
			tmp.me._signRandID(container);
		tmp.container = $(container.id);
		if(!tmp.container)
			return;
		tmp.select2 = new Element('input')
			.writeAttribute('required', tmp.required)
			.writeAttribute('save-item', saveItem);
		
		tmp.container.update(tmp.me._getFormGroup(tmp.title, tmp.select2).addClassName('col-md-12') );
		
		tmp.me._signRandID(tmp.select2);
		
		tmp.data = [];
		if(tmp.me._item && tmp.me._item.id) {
			value.each(function(item){
				tmp.data.push({'id': item.id, 'text': item.name, 'data': item});
			});
		}
		
		tmp.selectBox = jQuery('#'+tmp.select2.id).select2({
			minimumInputLength: 1,
			multiple: true,
			allowClear: true,
			width: "100%",
			ajax: {
				delay: 250
				,url: '/ajax/getAll'
				,type: 'GET'
				,data: function (params) {
					return {"searchTxt": 'name like ?', 'searchParams': ['%' + params + '%'], 'entityName': searchEntityName, 'pageNo': 1};
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
		});
		tmp.selectBox.on('change', function(){
			tmp.selectBox.attr('dirty', tmp.selectBox.val() !== tmp.me._getNamesString(value,'id',','));
			tmp.me._refreshDirty()._getSaveBtn();
		});
		if(tmp.me._item.id && tmp.me._item.infos && tmp.me._item.infos.allergents)
			tmp.selectBox.select2('data', tmp.data);
		return tmp.me;
	}
	
	,setItem: function(item) {
		this._item = item;
		return this;
	}
	,saveItem: function(btn, data, onSuccFunc) {
		var tmp = {};
		tmp.me = this;
		if(btn) {
			tmp.me._signRandID(btn);
			jQuery('#' + btn.id).prop('disabled',true);
		}
		tmp.me.postAjax(tmp.me.getCallbackId('saveItem'), data, {
			'onSuccess': function (sender, param) {
				try {
					tmp.result = tmp.me.getResp(param, false, true);
					if(!tmp.result || !tmp.result.item || !tmp.result.item.id)
						return;
					tmp.me._item = tmp.result.item;
					if(typeof(onSuccFunc) === 'function')
						onSuccFunc(tmp.result);
					tmp.me.closeFancyBox();
				} catch (e) {
					tmp.me.showModalBox('<strong class="text-danger">ERROR:</strong>', e);
				}
			}
			, 'onComplete': function() {
				if(btn)
					jQuery('#' + btn.id).prop('disabled',false);
				tmp.me.refreshParentWindow();
			}
		});
		return tmp.me;
	}

	,_init: function(){
		var tmp = {};
		tmp.me = this;
		return tmp.me;
	}

	,load: function () {
		var tmp = {};
		tmp.me = this;
		tmp.me._init();
		$(tmp.me.getHTMLID('itemDiv')).update(tmp.me._getItemDiv());
		return tmp.me;
	}
});