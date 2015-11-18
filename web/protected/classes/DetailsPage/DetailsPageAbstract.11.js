var DetailsPageJs=new Class.create;
DetailsPageJs.prototype=Object.extend(new BPCPageJs,{_item:null,_readOnlyMode:!1,_dirty:!1,_getFormGroup:function(a,b,d){var c;c=new Element("div",{"class":"form-group form-group-sm"});a&&("string"!==typeof a||"string"===typeof a&&!a.blank())&&c.insert({bottom:(new Element("label")).update(a)});c.insert({bottom:b.addClassName(!0===d?"":"form-control")});return c},refreshParentWindow:function(){var a,b,d;if(parent.window)return a=parent.window,(b=$(a.document.body).down("#"+a.pageJs.resultDivId+" .item_row[item_id="+
this._item.id+"]"))?(b.replace(a.pageJs._getResultRow(this._item)),b.hasClassName("success")||b.addClassName("success")):$(a.document.body).down("#"+a.pageJs.resultDivId+" #item-list-body")&&($(a.document.body).down("#"+a.pageJs.resultDivId+" #item-list-body").insert({top:a.pageJs._getResultRow(this._item)}),(d=$(a.document.body).down("#"+a.pageJs.totalNoOfItemsId))&&d.update(parseInt(d.innerHTML)+1)),this},_getSaveBtn:function(){var a={me:this};a.me._refreshDirty();if(!a.me._containerIds||!a.me._containerIds.saveBtn)return a.me;
a.container=$(a.me._containerIds.saveBtn);if(!a.container)return a.me;a.save=(new Element("i")).addClassName("btn btn-success btn-md").update("Save").observe("click",function(b){a.btn=$(this);a.data=a.me.collectData();if(!0===a.btn.readAttribute("disabled")||"disabled"===a.btn.readAttribute("disabled")||null===a.data||null===a.data)return a.me;a.me._item&&a.me._item.id&&(a.data.id=a.me._item.id);a.me.saveItem(a.input,a.data)});a.cancel=(new Element("i")).addClassName("btn btn-default btn-md").update("Cancel").observe("click",
function(b){a.me.closeFancyBox()});a.container.update("").addClassName("col-xs-12").insert({bottom:a.me._getFormGroup(a.title,a.save).addClassName("col-xs-6")}).insert({bottom:a.me._getFormGroup(a.title,a.cancel).addClassName("pull-right col-xs-6")});!1===a.me._dirty&&a.save.hide();return a.me},collectData:function(){return this._collectFormData($(this.getHTMLID("itemDiv")),"save-item")},closeFancyBox:function(){parent.jQuery&&parent.jQuery.fancybox?parent.jQuery.fancybox.close():location.reload();
return this},_getDatePickerDiv:function(a,b,d,c,g,m,l){var h,e,k,f,n;h=this;c=c||h.ucfirst(a);e=!0===g;l=l||"col-xs-12";m=m||"DD/MM/YYYY";d.id||h._signRandID(d);if(d=$(d.id)){k=(new Element("input")).writeAttribute({required:e,"save-item":a,dirty:!1}).setValue(b||"");d.update(h._getFormGroup(c,k).addClassName(l));if("function"!==typeof jQuery(document).datetimepicker)return h;h._signRandID(k);f=jQuery("#"+k.id).datetimepicker({format:m,showClear:!g});f.on("dp.change keyup",function(c){f.data("DateTimePicker")&&
f.data("DateTimePicker").date()?(n=f.data("DateTimePicker").date().local().format("YYYY-MM-DDThh:mm:ss"),a.endsWith("from")&&n.format("YYYY-MM-DDT00:00:00"),a.endsWith("to")&&n.format("YYYY-MM-DDT23:59:59")):n="";k.writeAttribute("dirty",b!==n);h._refreshDirty()._getSaveBtn()});return h}},__validateContainer:function(a){a=a||null;if(!a)return null;a.id||this._signRandID(a);return a.id&&0!==jQuery("#"+a.id).length?a:null},_getInputDiv:function(a,b,d,c,g,m,l,h){var e,k,f;e=this;d=e.__validateContainer(d);
c=c||e.ucfirst(a);g=!0===g;m=m||"col-xs-12";k=!0===l;l=h||"";if(!d)return e;f=(new Element("input")).writeAttribute({required:g,"save-item":a,placeholder:""!==l?l:c,dirty:!1}).setValue(b||"").observe("change",function(a){!0===k&&f.setValue(e.getValueFromCurrency($F(f)))}).observe("keyup",function(a){f.writeAttribute("dirty",b!==(!0===k?e.getValueFromCurrency($F(f)):$F(f)));e._refreshDirty()._getSaveBtn()});d.update(e._getFormGroup(c,f).addClassName(m));return e},_refreshDirty:function(){var a;a=!1;
$(this.getHTMLID("itemDiv")).getElementsBySelector("[save-item]").each(function(b){!1!==a||!0!==b.readAttribute("dirty")&&"true"!==b.readAttribute("dirty")&&"dirty"!==b.readAttribute("dirty")||(a=!0)});this._dirty=a;return this},_getSelect2Div:function(a,b,d,c,g,m,l,h){var e,k,f,n;e=this;c=e.__validateContainer(c);g=g||e.ucfirst(b);m=!0===m;l=l||null;h=h||"col-xs-12";if(!c)return e;b=(new Element("input")).writeAttribute("required",m).writeAttribute("placeholder","Please select a "+a).writeAttribute("save-item",
b);c.update(e._getFormGroup(g,b).addClassName(h));e._signRandID(b);k=[];Array.isArray(d)?d.each(function(a){k.push({id:a.id,text:a.name,data:a})}):k=d;f=jQuery("#"+b.id).select2(l?l:{multiple:!0,allowClear:!0,width:"100%",ajax:{delay:250,url:"/ajax/getAll",type:"GET",data:function(b){return{searchTxt:"name like ?",searchParams:["%"+b+"%"],entityName:a,pageNo:1}},results:function(a,b,c){n=[];a.resultData&&a.resultData.items&&a.resultData.items.each(function(a){n.push({id:a.id,text:a.name,data:a})});
return{results:n}}},cache:!0,escapeMarkup:function(a){return a}});f.on("change",function(){f.attr("dirty",f.val()!==e._getNamesString(d,"id",","));e._refreshDirty()._getSaveBtn()});k&&f.select2("data",k);b.addClassName("transfered-to-select2");return e},setItem:function(a){this._item=a;return this},saveItem:function(a,b,d){var c,g;c=this;a&&(c._signRandID(a),jQuery("#"+a.id).prop("disabled",!0));c._disableAll($(c.getHTMLID("itemDiv")));c.postAjax(c.getCallbackId("saveItem"),b,{onSuccess:function(a,
b){try{(g=c.getResp(b,!1,!0))&&g.item&&g.item.id&&(c._item=g.item,"function"===typeof d&&d(g),c.closeFancyBox())}catch(h){c.showModalBox('<strong class="text-danger">ERROR:</strong>',h),c._refreshDirty()._getSaveBtn()}},onComplete:function(){a&&jQuery("#"+a.id).prop("disabled",!1);c.refreshParentWindow()}});return c},_init:function(){return this},setPreData:function(a){a&&(this._preSetData=a);return this},bindAllEventNObjects:function(){return this},load:function(){this._init();$(this.getHTMLID("itemDiv")).addClassName("row");
this._getInputDiv("name",this._item.name||"",$(this._containerIds.name),null,!0)._getInputDiv("description",this._item.description||"",$(this._containerIds.description))._getSaveBtn();return this},_getCommentsDiv:function(){var a,b;a=$(this._containerIds.comments);b=new Element("div");a.insert({bottom:this._getFormGroup("Comments",b,!0).addClassName("col-md-12")});this._signRandID(b);(new CommentsDivJs(this,this._focusEntity,this._item.id))._setDisplayDivId(b.id).render();return this}});