<?php

namespace Acelle\Plugin\AddNewLeadToCrm\Controllers;

use Illuminate\Http\Request;
use Acelle\Http\Controllers\Controller;
use Acelle\Plugin\AddNewLeadToCrm\Main;
use Exception;
use Acelle\Model\MailList;

class MainController extends Controller
{
    /**
     * Whitelabel setting page.
     *
     * @return string
     **/
    public function index(Request $request)
    {        

        $main = new Main();
        $plugin = $main->getDbRecord();

        // Get currently selected list if any
        $data = $plugin->getData();
        $apiurl = array_key_exists('apiurl', $data) ? $data['apiurl'] : null;
        $apitoken = array_key_exists('apitoken', $data) ? $data['apitoken'] : null;
        $apistatus = array_key_exists('apistatus', $data) ? $data['apistatus'] : null;
        $apisource = array_key_exists('apisource', $data) ? $data['apisource'] : null;

        // All lists available
        /*$lists = MailList::all();*/

        /*echo '<pre>'; print_r($apitoken); die;*/

        return view('add_new_lead_to_crm::index', [
            'plugin' => $plugin,
            'apiurl' => $apiurl,
            'apitoken' => $apitoken,
            'apistatus' => $apistatus,
            'apisource' => $apisource,
            'saveListUrl' => action([MainController::class, 'saveList']),
        ]);
    }

    public function saveList(Request $request)
    {
        $apiurl = $request->input('apiurl');
        $apitoken = $request->input('apitoken');
        $apistatus = $request->input('apistatus');
        $apisource = $request->input('apisource');
        if (is_null($apiurl) && is_null($apitoken) && is_null($apistatus) && is_null($apisource)) {
            return redirect()->action([MainController::class, 'index'])->with('error', 'Please Enter Api details');
        }

        $main = new Main();
        $plugin = $main->getDbRecord();

        $plugin->updateData(
            ['apiurl'=> $apiurl,'apitoken'=> $apitoken,'apistatus'=> $apistatus,'apisource'=> $apisource]
        );
        return redirect()->action([MainController::class, 'index'])->with('success', 'Api details successfully saved');
    }
}
