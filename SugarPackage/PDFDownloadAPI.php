<?php

require_once('include/Sugarpdf/SugarpdfFactory.php');

class PDFDownloadAPI extends SugarApi
{
    /**
     * Function: registerApiRest
     *
     * This function registers the Rest api
     */
    public function registerApiRest()
    {
        return array(
            'downloadPDF' => array(
                'reqType' => 'GET',
                'path' => array('<module>', '?', 'pdf', '?'),
                'pathVars' => array('module', 'record', 'pdf', 'pdf_template_id'),
                'method' => 'downloadPDF',
                'rawReply' => true,
                'allowDownloadCookie' => true,
                'shortHelp' => 'Download PDF for the module record',
                'longHelp' => '',
            ),
        );
    }
    /**
     * Function: downloadPDF
     *
     * This function will generate and make PDF for download
     * @param $api ServiceBase The API class of the request, used in cases where the API changes
     * how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return bool
     */
    public function downloadPDF($api, $args)
    {
        $this->requireArgs($args, array('module', 'record', 'pdf_template_id'));
        
        // check for access to edit
        if (!ACLController::checkAccess('PdfManager', 'view')) {
            throw new SugarApiExceptionNotAuthorized();
        }

        // PDF Manager checks for $_REQUEST['pdf_template_id']
        $_REQUEST['pdf_template_id'] = $args['pdf_template_id'];
        $_REQUEST['module'] = $args['module'];
        $_REQUEST['record'] = $args['record'];

        $bean = $this->loadBean($api, $args);

        // getting PDF Bean
        $sugarpdfBean = SugarpdfFactory::loadSugarpdf('pdfmanager', $args['module'], $bean);
        $sugarpdfBean->process();
        $sugarpdfBean->Output($sugarpdfBean->fileName);
    }
}
