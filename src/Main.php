<?php

namespace Acelle\Plugin\AddNewLeadToCrm;

use Acelle\Model\Plugin as PluginModel;
use Acelle\Library\Facades\Hook;
use Acelle\Model\MailList;
use Exception;
use DB;

class Main
{
    const NAME = 'acelle/add-new-lead-to-crm'; // MUST match "name" in composer.json

    public function getDbRecord()
    {
        return PluginModel::where('name', self::NAME)->first();
    }

    public function registerHooks()
    {
        Hook::register('activate_plugin_'.self::NAME, function () {
            // throw new Exception('Hello world');
        });

        Hook::register('deactivate_plugin_'.self::NAME, function () {
            return true; // or throw an exception
        });

        Hook::register('delete_plugin_'.self::NAME, function () {
            return true; // or throw an exception
        });

        // Register new import job
        if ($this->getDbRecord()->isActive()) {

            Hook::register('customer_added', function($customer) {
                // The following code shall be executed every time a new customer is added

                /*echo '<pre>'; print_r($customer['user']['email']); */

                $name = 'Dmitri Oleinikov';

                if(!empty($customer['user']['email'])){
                    $email = $customer['user']['email'];
                    $main = new Main();
                    $plugin = $main->getDbRecord();
                    $data = $plugin->getData();

                    $apiurl = array_key_exists('apiurl', $data) ? $data['apiurl'] : null;
                    $apitoken = array_key_exists('apitoken', $data) ? $data['apitoken'] : null;
                    $apistatus = array_key_exists('apistatus', $data) ? $data['apistatus'] : null;
                    $apisource = array_key_exists('apisource', $data) ? $data['apisource'] : null;

                    $name = $customer['user']['first_name'] .' '. $customer['user']['last_name'];

                    if (!empty($apiurl) && !empty($apitoken) && !empty($apistatus) && !empty($apisource)) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $apiurl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        $headers = array();
                        $headers[] = 'Authtoken: '.$apitoken;
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $data = array('source' => $apisource, 'status' => $apistatus, 'name' => $name, 'email' => $email );
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                        $result = curl_exec($ch);
                        /*echo '<pre>'; print_r($result); die;*/

                    }

                }
                

                if(!empty($_POST['first_name'])){
                    $name = $_POST['first_name'] .' '. $_POST['last_name'];
                }

                if(!empty($_POST['email'])){

                    $main = new Main();
                    $plugin = $main->getDbRecord();
                    $data = $plugin->getData();

                    $apiurl = array_key_exists('apiurl', $data) ? $data['apiurl'] : null;
                    $apitoken = array_key_exists('apitoken', $data) ? $data['apitoken'] : null;
                    $apistatus = array_key_exists('apistatus', $data) ? $data['apistatus'] : null;
                    $apisource = array_key_exists('apisource', $data) ? $data['apisource'] : null;

                    $email = $_POST['email'];

                    if (!empty($apiurl) && !empty($apitoken) && !empty($apistatus) && !empty($apisource)) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $apiurl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        $headers = array();
                        $headers[] = 'Authtoken: '.$apitoken;
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $data = array('source' => $apisource, 'status' => $apistatus, 'name' => $name, 'email' => $email );
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                        $result = curl_exec($ch);
                        /*echo '<pre>'; print_r($result); die;*/

                    }                    

                }               

            });
        }
    }

    public function getSelectedList()
    {
        // Get the plugin selected list
        $data = $this->getDbRecord()->getData();
        if (!array_key_exists('list_id', $data)) {
            throw new Exception('Plugin error: [AddNewLeadToCrm] please go to the plugin setting page and select a list first');
        }

        $listId = $data['list_id'];
        $list = MailList::find($listId);

        if (is_null($list)) {
            throw new Exception('Plugin error: [AddNewLeadToCrm] the selected mail list no longer exists. Please go to the plugin setting page and select another list');
        }

        return $list;
    }
}
