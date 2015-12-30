/**
 * The page Js file
 */
var PageJs = new Class.create();
PageJs.prototype = Object.extend(new CRUDPageJs(), {
    _getTitleRowData: function() {
        this._titleRowData.serverMeasurement = {'ServeMeasurement': {'name': 'Server Measurement'}};
        this._titleRowData.unitPrice = 'Unit Price';
        this._titleRowData.totalPrice = 'Total Price';
        this._titleRowData.orderqty = 'Order QTY';
        return this._titleRowData;
    }
    ,init: function() {
        var tmp = {};
        tmp.me = this;
        tmp.me._htmlIDs.totalRow = 'total-row';

        tmp.me._bindSubmitButton();

        return tmp.me;
    }
    ,_priceCalc: function() {
        var tmp = {};
        tmp.me = this;
        tmp.total = 0.0;

        $('item-list-body').getElementsBySelector('.item_row').each(function(row){
            tmp.unitPrice = row.down('[save-item="unitPrice"]');
            tmp.totalPrice = row.down('[save-item="totalPrice"]');
            tmp.stocktakeShop = row.down('[save-item="stocktakeShop"]');
            tmp.stocktakeStoreRoom = row.down('[save-item="stocktakeStoreRoom"]');
            tmp.orderQty = row.down('[save-item="orderQty"]');

            tmp.totalPrice.setValue((accounting.unformat($F(tmp.stocktakeShop)) + accounting.unformat($F(tmp.stocktakeStoreRoom)) + accounting.unformat($F(tmp.orderQty))) * accounting.unformat($F(tmp.unitPrice)));
            tmp.total += accounting.unformat($F(tmp.totalPrice));
        });

        $(tmp.me._htmlIDs.totalRow).down('[save-item="totalPrice"]').setValue(tmp.total);

        return tmp.me;
    }
    ,_bindSubmitButton: function() {
        var tmp = {};
        tmp.me = this;
        tmp.btn = $('item-list').up('.panel').down('[type="submit"]');
        if(!tmp.btn)
            return tmp.me;
        tmp.btn.observe('click', function(){
            tmp.me._preSubmit(tmp.me._collectData(), tmp.btn);
        });
        return tmp.me;
    }
    ,_preSubmit: function(data, btn) {
        var tmp = {};
        tmp.me = this;
        tmp.btn = (btn || null);
        tmp.confirmBoxContent = new Element('div', {'class': 'pre-submit-box'})
            .insert({'bottom': new Element('h4').update('Once you submit these data, then you will NOT be able to changed it any more.') });
        tmp.confirmBoxFooter = new Element('div', {'class': 'row pre-submit-box-footer'})
            .insert({'bottom': new Element('span', {'class': 'btn btn-primary col-sm-3'})
                .update('YES, continue.')
                .observe('click', function() {
                    if(tmp.btn && !tmp.btn.readAttribute('disabled'))
                        tmp.btn.writeAttribute('disabled', true);
                    $$('.pre-submit-box-footer btn').each(function(item) {
                        item.writeAttribute('disabled', true);
                    });
                    tmp.me._submit(data, tmp.btn);
                })
            })
            .insert({'bottom': new Element('span', {'class': 'btn btn-default col-sm-3 pull-right'})
                .update('No, let me review it again.')
                .observe('click', function(){
                    tmp.me.hideModalBox();
                })
            });
        tmp.me.showModalBox('Please confirm', tmp.confirmBoxContent, false, tmp.confirmBoxFooter, true);
        return tmp.me;
    }
    ,_submit: function(data, btn) {
        var tmp = {};
        tmp.me = this;
        tmp.btn = (btn || null);

        tmp.me.postAjax(tmp.me.getCallbackId('stocktake'), data, {
            'onSuccess': function (sender, param) {
                try {
                    tmp.result = tmp.me.getResp(param, false, true);
                    if (tmp.result && tmp.result.email && tmp.result.asset) {
                        tmp.resultBox = new Element('div')
                            .insert({'bottom': new Element('b', {'class': "success"}).update('An email will be send to :' + tmp.result.email) })
                            .insert({'bottom': 'With an attached excel: '})
                            .insert({'bottom': new Element('a', {'href': tmp.result.asset.url, "target": "__BLANK"}).update(tmp.result.asset.filename)});
                        tmp.resultFooter = new Element('div', {'class': 'text-center'})
                            .insert({'bottom': new Element('span', {'class': 'btn btn-default'})
                                .update('OK')
                                .observe('click', function() {
                                    window.location = document.URL;
                                })
                            });
                        tmp.me.showModalBox('Success', tmp.resultBox, false, tmp.resultFooter, true);
                    }
                } catch (e) {
                    tmp.me.showModalBox('Error', '<pre>' + e + '</pre>');
                    if(tmp.btn !== null)
                        tmp.btn.writeAttribute('disabled', false);
                }
            }
            ,'onComplete': function() {
            }
        });
        return tmp.me;
    }
    ,_collectData: function() {
        var tmp = {};
        tmp.me = this;
        tmp.data = [];
        $('item-list-body').getElementsBySelector('.item_row[item_id]').each(function(row){
            tmp.rowData = tmp.me._collectFormData(row, 'save-item');
            tmp.rowData.item = row.retrieve('data');
            tmp.data.push(tmp.rowData);
        });
        return tmp.data;
    }
    ,_getInput: function(saveItem, value, prefix, postfix, disabled) {
        var tmp = {};
        tmp.me = this;
        tmp.newDiv = new Element('div', {'class': 'input-group'})
            .insert({'bottom': new Element('input', {'class': 'form-control', 'save-item': saveItem, 'type': 'text', 'disabled': (disabled === true)}).setStyle('width: 100%').setValue(value) });
        if(prefix)
            tmp.newDiv.insert({'top': new Element('div', {'class': 'input-group-addon'}).update(prefix)});
        if(postfix)
            tmp.newDiv.insert({'bottom': new Element('div', {'class': 'input-group-addon'}).update(postfix)});
        return tmp.newDiv;
    }
    ,getResultsOnComplete: function() {
        this._addTotalRow();
    }
    ,_addTotalRow: function() {
        var tmp = {};
        tmp.me = this;

        if(jQuery('#total-row').length > 0)
            return tmp.me;

        tmp.row = tmp.me._getTitleRowData();
        tmp.row.name = '<b>Total</b>';
        tmp.row.serverMeasurement = {'ServeMeasurement': {'name': null}};

        tmp.totalRow = tmp.me._getResultRow(tmp.row).writeAttribute('id', tmp.me._htmlIDs.totalRow);

        tmp.totalRow.getElementsBySelector('input').each(function(input){ input.writeAttribute('disabled', true); });

        $('item-list-body').insert({'bottom': tmp.totalRow});

        return tmp.me;
    }
    ,_getResultRow: function(row, isTitle) {
        var tmp = {};
        tmp.me = this;
        tmp.isTitle = (isTitle || false);
        tmp.tag = (tmp.isTitle === true ? 'strong' : 'span');
        tmp.row = new Element('span', {'class': 'row'})
            .store('data', row)
            .addClassName( (row.active === false && tmp.isTitle === false ) ? 'warning' : '')
            .addClassName('list-group-item')
            .addClassName('item_row')
            .writeAttribute('item_id', row.id)
            .insert({'bottom': new Element(tmp.tag, {'class': 'name col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? 'Name' : row.name) })
            .insert({'bottom': new Element(tmp.tag, {'class': 'unitPrice col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? row.unitPrice : tmp.unitPrice = tmp.me._getInput('unitPrice', accounting.formatMoney(row.unitPrice, "", 2, "", "."), '$') ) })
            .insert({'bottom': new Element(tmp.tag, {'class': 'totalPrice col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? row.totalPrice : tmp.totalPrice = tmp.me._getInput('totalPrice', null, '$', null, true)) })
            .insert({'bottom': new Element(tmp.tag, {'class': 'stocktakeShop col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? 'Stocktake QTY<br/>(Shop)' : tmp.stocktakeShop = tmp.me._getInput('stocktakeShop', null, null, row.serverMeasurement.ServeMeasurement.name)) })
            .insert({'bottom': new Element(tmp.tag, {'class': 'stocktakeStoreRoom col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? 'Stocktake QTY<br/>(Store Room)' : tmp.stocktakeStoreRoom = tmp.me._getInput('stocktakeStoreRoom', null, null, row.serverMeasurement.ServeMeasurement.name)) })
            .insert({'bottom': new Element(tmp.tag, {'class': 'orderQty col-sm-2 col-xs-12'}).update(tmp.isTitle === true ? 'Order QTY' : tmp.orderQty = tmp.me._getInput('orderQty', null, null, row.serverMeasurement.ServeMeasurement.name)) })
        ;
        // validate can edit unit price
        if(tmp.isTitle === false && tmp.me.preData.canEditUnitPrice === false)
            tmp.unitPrice.down('input').disable();
        if(tmp.isTitle === false) {
            tmp.events = ['keyup', 'change', 'wheel'];
            tmp.events.each(function(event) {
                tmp.unitPrice.down('input').observe(event, function(){ tmp.me._priceCalc() });
                tmp.stocktakeShop.down('input').observe(event, function(){ tmp.me._priceCalc() });
                tmp.stocktakeStoreRoom.down('input').observe(event, function(){ tmp.me._priceCalc() });
                tmp.orderQty.down('input').observe(event, function(){ tmp.me._priceCalc() });
            });
        }
        if(tmp.me._view && tmp.me._view !== '') {
            switch(tmp.me._view) {
                case 'stocktake': {
                    tmp.row.down('.orderQty').hide();
                    break;
                }
                case 'placeorder': {
                    tmp.row.down('.stocktakeShop').hide();
                    tmp.row.down('.stocktakeStoreRoom').hide();
                    break;
                }
            }
        }
        return tmp.row;
    }
});