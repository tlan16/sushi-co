var PageJs=new Class.create;PageJs.prototype=Object.extend(new DetailsPageJs,{load:function(){this._init();$(this.getHTMLID("itemDiv")).addClassName("row");this._getInputDiv("type",this._item.type||"",$(this._containerIds.type),null,!0)._getInputDiv("value",this._item.value||"",$(this._containerIds.value),null,!0)._getInputDiv("description",this._item.description||"",$(this._containerIds.description))._getSaveBtn();jQuery('input[save-item="type"]').prop("disabled",!0);return this}});