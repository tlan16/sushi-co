var PageJs=new Class.create;
PageJs.prototype=Object.extend(new DetailsPageJs,{load:function(){var b;this._init();$(this.getHTMLID("itemDiv")).addClassName("row");this._getSelect2Div("Nutrition","nutrition",this._item.nutrition?{id:this._item.nutrition.id,text:this._item.nutrition.name,data:this._item.nutrition}:null,$(this._containerIds.nutrition),null,!0,{width:"100%",ajax:{delay:250,url:"/ajax/getAll",type:"GET",data:function(a){return{searchTxt:"name like ?",searchParams:["%"+a+"%"],entityName:"Nutrition",pageNo:1}},results:function(a,
c,d){b=[];a.resultData&&a.resultData.items&&a.resultData.items.each(function(a){b.push({id:a.id,text:a.name,data:a})});return{results:b}}},cache:!0,escapeMarkup:function(a){return a}})._getSelect2Div("ServeMeasurement","serveMeasurement",this._item.serveMeasurement?{id:this._item.serveMeasurement.id,text:this._item.serveMeasurement.name,data:this._item.serveMeasurement}:null,$(this._containerIds.serveMeasurement),"Serve Measurement",!0,{width:"100%",ajax:{delay:250,url:"/ajax/getAll",type:"GET",data:function(a){return{searchTxt:"name like ?",
searchParams:["%"+a+"%"],entityName:"ServeMeasurement",pageNo:1}},results:function(a,c,d){b=[];a.resultData&&a.resultData.items&&a.resultData.items.each(function(a){b.push({id:a.id,text:a.name,data:a})});return{results:b}}},cache:!0,escapeMarkup:function(a){return a}})._getInputDiv("description",this._item.description||"",$(this._containerIds.description),null)._getSaveBtn();return this}});