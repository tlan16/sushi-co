var PageJs=new Class.create;
PageJs.prototype=Object.extend(new DetailsPageJs,{load:function(){this._init();$(this.getHTMLID("itemDiv")).addClassName("row");this._getInputDiv("name",this._item.name||"",$(this._containerIds.name),null,!0)._getInputDiv("description",this._item.description||"",$(this._containerIds.description))._getInputDiv("contactName",this._item.address?this._item.address.contactName:"",$(this._containerIds.contactName))._getInputDiv("contactNo",this._item.address?this._item.address.contactNo:"",$(this._containerIds.contactNo))._getInputDiv("street",
this._item.address?this._item.address.street:"",$(this._containerIds.street))._getInputDiv("city",this._item.address?this._item.address.city:"",$(this._containerIds.city))._getInputDiv("region",this._item.address?this._item.address.region:"",$(this._containerIds.region))._getInputDiv("country",this._item.address?this._item.address.country:"",$(this._containerIds.country))._getInputDiv("postCode",this._item.address?this._item.address.postCode:"",$(this._containerIds.postCode))._getSaveBtn();return this}});