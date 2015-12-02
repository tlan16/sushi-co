var PageJs=new Class.create;
PageJs.prototype=Object.extend(new CRUDPageJs,{_getTitleRowData:function(){this._titleRowData.serverMeasurement={ServeMeasurement:{name:"Server Measurement"}};this._titleRowData.unitPrice="Unit Price";this._titleRowData.totalPrice="Total Price";this._titleRowData.orderqty="Order QTY";return this._titleRowData},init:function(){this._htmlIDs.totalRow="total-row";this._bindSubmitButton();return this},_priceCalc:function(){var a,c,b,d,e,g;a=0;$("item-list-body").getElementsBySelector(".item_row").each(function(f){c=f.down('[save-item="unitPrice"]');
b=f.down('[save-item="totalPrice"]');d=f.down('[save-item="stocktakeShop"]');e=f.down('[save-item="stocktakeStoreRoom"]');g=f.down('[save-item="orderQty"]');b.setValue((accounting.unformat($F(d))+accounting.unformat($F(e))+accounting.unformat($F(g)))*accounting.unformat($F(c)));a+=accounting.unformat($F(b))});$(this._htmlIDs.totalRow).down('[save-item="totalPrice"]').setValue(a);return this},_bindSubmitButton:function(){var a,c;a=this;c=$("item-list").up(".panel").down('[type="submit"]');if(!c)return a;
c.observe("click",function(){if(c.readAttribute("disabled"))return a;c.writeAttribute("disabled",!0);a._submit(a._collectData())});return a},_submit:function(a){var c,b;c=this;c.postAjax(c.getCallbackId("stocktake"),a,{onSuccess:function(a,e){try{(b=c.getResp(e,!1,!0))&&b.email&&b.asset&&c.showModalBox("Success",'<b class="success">An email will be send to :'+b.email+'</b>With an attached excel: <a href="'+b.asset.url+'" target="__BLANK">'+b.asset.filename+"</a>")}catch(g){c.showModalBox("Error",
"<pre>"+g+"</pre>")}},onComplete:function(){}});return c},_collectData:function(){var a,c,b;a=this;c=[];$("item-list-body").getElementsBySelector(".item_row[item_id]").each(function(d){b=a._collectFormData(d,"save-item");b.item=d.retrieve("data");c.push(b)});return c},_getInput:function(a,c,b,d,e){a=(new Element("div",{"class":"input-group"})).insert({bottom:(new Element("input",{"class":"form-control","save-item":a,type:"number",disabled:!0===e})).setStyle("width: 100%").setValue(c)});b&&a.insert({top:(new Element("div",
{"class":"input-group-addon"})).update(b)});d&&a.insert({bottom:(new Element("div",{"class":"input-group-addon"})).update(d)});return a},getResultsOnComplete:function(){this._addTotalRow()},_addTotalRow:function(){var a;if(0<jQuery("#total-row").length)return this;a=this._getTitleRowData();a.name="<b>Total</b>";a.serverMeasurement={ServeMeasurement:{name:null}};a=this._getResultRow(a).writeAttribute("id",this._htmlIDs.totalRow);a.getElementsBySelector("input").each(function(a){a.writeAttribute("disabled",
!0)});$("item-list-body").insert({bottom:a});return this},_getResultRow:function(a,c){var b,d,e,g,f,h,k;b=this;d=c||!1;e=!0===d?"strong":"span";e=(new Element("span",{"class":"row"})).store("data",a).addClassName(!1===a.active&&!1===d?"warning":"").addClassName("list-group-item").addClassName("item_row").writeAttribute("item_id",a.id).insert({bottom:(new Element(e,{"class":"name col-sm-2 col-xs-12"})).update(!0===d?"Name":a.name)}).insert({bottom:(new Element(e,{"class":"unitPrice col-sm-2 col-xs-12"})).update(!0===
d?a.unitPrice:g=b._getInput("unitPrice",a.unitPrice,"$"))}).insert({bottom:(new Element(e,{"class":"totalPrice col-sm-2 col-xs-12"})).update(!0===d?a.totalPrice:b._getInput("totalPrice",null,"$",null,!0))}).insert({bottom:(new Element(e,{"class":"stocktakeShop col-sm-2 col-xs-12"})).update(!0===d?"Stocktake QTY<br/>(Shop)":f=b._getInput("stocktakeShop",null,null,a.serverMeasurement.ServeMeasurement.name))}).insert({bottom:(new Element(e,{"class":"stocktakeStoreRoom col-sm-2 col-xs-12"})).update(!0===
d?"Stocktake QTY<br/>(Store Room)":h=b._getInput("stocktakeStoreRoom",null,null,a.serverMeasurement.ServeMeasurement.name))}).insert({bottom:(new Element(e,{"class":"orderQty col-sm-2 col-xs-12"})).update(!0===d?"Order QTY":k=b._getInput("orderQty",null,null,a.serverMeasurement.ServeMeasurement.name))});!1===d&&(d=["keyup","change","wheel"],d.each(function(a){g.down("input").observe(a,function(){b._priceCalc()});f.down("input").observe(a,function(){b._priceCalc()});h.down("input").observe(a,function(){b._priceCalc()});
k.down("input").observe(a,function(){b._priceCalc()})}));if(b._view&&""!==b._view)switch(b._view){case "stocktake":e.down(".orderQty").hide();break;case "placeorder":e.down(".stocktakeShop").hide(),e.down(".stocktakeStoreRoom").hide()}return e}});