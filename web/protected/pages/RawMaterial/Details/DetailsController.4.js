var PageJs=new Class.create;
PageJs.prototype=Object.extend(new DetailsPageJs,{load:function(){var a,b;this._init();a=this._item.id&&this._item.serverMeasurement&&this._item.serverMeasurement.ServeMeasurement?this._item.serverMeasurement.ServeMeasurement:null;$(this.getHTMLID("itemDiv")).addClassName("row");this._getInputDiv("name",this._item.name||"",$(this._containerIds.name),null,!0)._getInputDiv("description",this._item.description||"",$(this._containerIds.description))._getSelect2Div("ServeMeasurement","serveMeasurement",
a?{id:a.id,text:a.name,data:a}:null,$(this._containerIds.serverMeasurement),"Serve Measurement",!0,{multiple:!1,width:"100%",ajax:{delay:250,url:"/ajax/getAll",type:"GET",data:function(a){return{searchTxt:"name like ?",searchParams:["%"+a+"%"],entityName:"ServeMeasurement",pageNo:1}},results:function(a,c,d){b=[];a.resultData&&a.resultData.items&&a.resultData.items.each(function(a){b.push({id:a.id,text:a.name,data:a})});return{results:b}}},cache:!0,escapeMarkup:function(a){return a}})._getInputDiv("unitPrice",
this._item.unitPrice||"",$(this._containerIds.unitPrice),"Unit Price")._getInputDiv("position",this._item.position||0,$(this._containerIds.position),"Position")._getSaveBtn();return this},collectData:function(){var a;a=this._collectFormData($(this.getHTMLID("itemDiv")),"save-item");a.infoId=this._item.serverMeasurement?this._item.serverMeasurement.id:null;return a}});