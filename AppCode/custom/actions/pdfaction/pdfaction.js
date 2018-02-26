const app = SUGAR.App;
const customization = require('%app.core%/customization');
const dialog = require('%app.core%/dialog');
const deviceFeatures = require('%app.core%/device');
const utils = require('%app.js%/utils/utils');

customization.registerRecordAction({
    name: 'pdfaction',
    types: ['right-menu-detail'],
    label: 'LBL_PDF_VIEW',
    iconKey: 'actions.pdfaction',
    rank: 21,
    templateCollection: null,

    stateHandlers: {
        isVisible(view, model) {
            return true;
            // somehow the module is disabled for mobile
            // app.acl.hasAccess('view', 'PdfManager');
        },
    },

    handler(view, model) {
        this.model = model;
        if (this.templateCollection == null) {
            this.templateCollection = [];
            app.api.call(
                'read',
                app.api.buildURL(
                    'PdfManager',
                    null,
                    null,
                    {
                        filter:[{
                            '$and': [{
                                'base_module': model.module
                            }, {
                                'published': 'yes'
                            }]
                        }],
                        max_num:20
                    }
                ),
                null,
                {
                    success: _.bind(function(response){
                        this.templateCollection = response.records;
                        this.showDialog();
                    }, this)
                },
                null
            );
        } else {
            this.showDialog();
        }
    },

    showDialog(){
        if (this.templateCollection.length > 0) {
            let items = _.map(this.templateCollection, function(record) {
                return record.name;
            });

            dialog.showActionSheet(items, {
                title: app.lang.get('LBL_SELECT_PDF_TEMPLATE'),
                onSelectCb: _.bind(function(buttonIndex) {
                    let record = this.templateCollection[buttonIndex];
                    let uri = app.api.serverUrl + '/' + this.model.module + '/' +
                                this.model.id + '/pdf/' + record.id + '?platform=' + app.config.platform;

                    let listItem = {};
                    listItem[this.model.id + '_pdf_' + record.id] = {
                    	url: uri,
                        isImage: false,
                        file_mime_type: 'application/pdf',
                        filename: utils.sanitizeFileName(this.model.get('name') + '_' + record.name + '.pdf'),
                        oauth: true,
                        fieldName: this.model.id
                    };

                    deviceFeatures.openDoc([listItem]);
                }, this)
            });
        } else {
            dialog.showAlert(app.lang.get('LBL_NO_PDF_DATA'));
        }
    }
});
