var PageJs=new Class.create;
PageJs.prototype=Object.extend(new CRUDPageJs,{_getResultRow:function(a,f){var c,b,d,e;c=this;b=f||!1;d=!0===b?"strong":"span";return(new Element("span",{"class":"row"})).store("data",a).addClassName(!1===a.active&&!1===b?"warning":"").addClassName("list-group-item").addClassName("item_row").writeAttribute("item_id",a.id).insert({bottom:(new Element(d,{"class":"name col-sm-3 col-xs-12"+(!0===b?"hidden-xs":"")})).update(!0===b?a.name:(new Element("div")).insert({bottom:(new Element("div")).update(a.name)}))}).insert({bottom:(new Element(d,{"class":"name col-sm-7 col-xs-12"+
(!0===b?"hidden-xs":"")})).insert({bottom:(new Element("i")).update(a.description)})}).insert({bottom:(new Element(d,{"class":"text-right btns col-sm-2 col-xs-12"})).update(!0===b?"":(new Element("span",{"class":"btn-group btn-group-sm"})).insert({bottom:(new Element("span",{"class":"btn btn-default",title:"List of products"})).insert({bottom:new Element("span",{"class":"glyphicon glyphicon-th-list"})}).observe("click",function(){e=window.parent||window;e.location="/products/category/"+a.id})}).insert({bottom:(new Element("span",
{"class":"btn btn-primary",title:"Edit"})).insert({bottom:new Element("span",{"class":"glyphicon glyphicon-pencil"})}).observe("click",function(){c._openDetailsPage(a)})}).insert({bottom:!1===c._canEdit?"":(new Element("span")).addClassName(!1===a.active&&!1===b?"btn btn-success":"btn btn-danger").writeAttribute("title",!1===a.active&&!1===b?"Re-activate":"De-activate").insert({bottom:(new Element("span")).addClassName(!1===a.active&&!1===b?"glyphicon glyphicon-repeat":"glyphicon glyphicon-trash")}).observe("click",
function(){if(!confirm("Are you sure you want to "+(!0===a.active?"DE-ACTIVATE":"RE-ACTIVATE")+" this item?"))return!1;c._deleteItem(a,a.active)})}))})}});