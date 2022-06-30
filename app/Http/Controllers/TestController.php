<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;

use \RouterOS\Client;
use \RouterOS\Query;
use Illuminate\Support\Arr;

class TestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $config = new \RouterOS\Config([
        //     'host' => '10.254.252.10',
        //     'user' => 'admin',
        //     'pass' => '',
        //     'port' => 8728,
        // ]);

        $client = $this->client();
        // Create "where" Query object for RouterOS
        // $query =
        //     (new Query('/ip/hotspot/ip-binding/add'))
        //     ->equal('mac-address', '00:00:00:00:40:29')
        //     ->equal('type', 'bypassed')
        //     ->equal('comment', 'testcomment');
        // $response = $client->export();
        // Send query and read response from RouterOS
        // $response = $client->query($query)->read();

        //bridge
        // $response = $client->qr('/interface/bridge/host/print');
        // $response = $client->query('/ip/hotspot/active/print')->read();

        // Send query to RouterOS
        // $query =
        //     (new Query('/interface/monitor-traffic'))
        //     ->equal('interface', 'ether1')
        //     ->equal('once');
        // $response = $client->query($query)->read();

        // $response = $client->qr('/ip/firewall/address-list/find');
        // $response = $client->qr('/system/script/print');
        // $response = $client->qr('/system/package/print');
        // $response = $client->qr('/interface/wireless/security-profiles/print');
        // $response = $client->query(['/queue/simple/print'])->read();
        // $response = $client->query(['/ip/address/print'])->read();
        // print_r($response);
        // $query    = new Query('/queue/simple/print', ['?target=10.254.252.10/24']);
        // $response = $client->qr($query);

        // $client = $this->connect();

        // Get list of all available profiles with name Block
        // $query = new Query('/ppp/secret/print');
        // $query->where('name', 'Block');
        // $response = $client->query($query)->read();

        // echo "Before update" . PHP_EOL;
        // print_r($secrets);

        // // Parse secrets and set password
        // foreach ($secrets as $secret) {

        //     // Change password
        //     $query = (new Query('/ppp/secret/set'))
        //         ->equal('.id', $secret['.id'])
        //         ->equal('password', 'pa$$word');

        //     // Update query ordinary have no return
        //     $client->query($query)->read();
        // }

        // echo PHP_EOL . "After update" . PHP_EOL;
        // print_r($secrets);
        // $response = $client->query('/ip/firewall/address-list/print')->read();
        // $response = $client->query('/system/logging/print')->read();
        // $response = $client->query('/queue/simple/print')->readAsIterator();

        // $response = $client->q('/tool/user-manager/session/print')->r();
        // if (is_array($response)) {
        //     foreach ($response as  $session) {
        //         $id = array_shift($session);
        //         // dd($session);
        //         $session['m_id'] = $id;
        //         UserSession::create($session);
        //     }
        // }

        // $response = $client->q('/tool/user-manager/profile/print')->r();
        // if (is_array($response)) {
        //     foreach ($response as  $profile) {
        //         $id = array_shift($profile);
        //         $profile['m_id'] = $id;
        //         // dd($profile);
        //         Profile::create($profile);
        //     }
        // }

        // $response = $client->q('/tool/user-manager/user/print')->r();
        // if (is_array($response)) {
        //     foreach ($response as  $user) {
        //         $id = array_shift($user);
        //         $user['m_id'] = $id;
        //         User::create($user);
        //     }
        // }

        $response = $client->q('/tool/user-manager/user/print')->r();
        $response = $client->q('/ppp/secret/print')->r();
        $response = $client->q('/ip/pool/print')->r();
        // $response = $client->qr('/interface/print');
        // $response = $client->q('/ppp/profile/print')->r();

        // $response = $client->q('/interface/vlan/print')->r();
        // $response = $client->q('/ip/address/print')->r();
        $response = $client->q('/queue/simple/print')->r();
        // $response = $client->q('/ppp/active/print')->r();
        // $response = $client->q('/interface/pppoe-client/print')->r();
        // $response = $client->q('/ip/pool/print')->r();
        // $response = $client->q('/tool/user-manager/customer/print')->r();
        // $response = $client->q('/tool/user-manager/log/print')->r();
        // $response = $client->q('/tool/user-manager/payment/print')->r();
        // $response = $client->q('/tool/user-manager/router/print')->r();
        // $response = $client->q('/tool/user-manager/router/print')->r();
        // $response = $client->q('/tool/user-manager/profile/print')->r();
        // $response = $client->q('/tool/user-manager/profile/limitation/print')->r();
        // $response = $client->q('/tool/user-manager/profile/profile-limitation/print')->r();
        // $response = $client->q('/tool/user-manager/setting/print')->r();
        // $response = $client->q('/tool/user-manager/setting/print')->r();
        // $response = $client->qr('/system/script/job/print');



        // Profile Add Start
        // $query = new Query('/tool/user-manager/profile/add');
        // $query->equal("name", "Rabbi"); //*
        // $query->equal("owner", "admin"); //*
        // $query->equal("name-for-users", "Rabbi 2");
        // $query->equal("starts-at", "logon");
        // $query->equal("price", "0");
        // $response = $client->query($query)->read();
        // $response = $client->q('/tool/user-manager/profile/print')->r();
        // Profile Add End

        //Profile update Start
        // $query = new Query('/tool/user-manager/profile/set');
        // $query->equal('.id', '*6');
        // $query->equal('name', '3M');
        // $query->equal('price', '500');
        // $query->equal('name-for-users', 'Rabbi 22');
        // $response = $client->query($query)->read();
        // $response = $client->q('/tool/user-manager/profile/print')->r();
        // Profile update End


        // Profile Add Start
        // $query = new Query('/tool/user-manager/profile/add');
        // $query->equal("name", "Rabbi"); //*
        // $query->equal("owner", "admin"); //*
        // $query->equal("name-for-users", "Rabbi 2");
        // $query->equal("starts-at", "logon");
        // $query->equal("price", "0");
        // $response = $client->query($query)->read();
        // $response = $client->q('/tool/user-manager/profile-limitation/print')->r();
        // Profile Add End


        // Start ARP
        // address=172.168.2.6 mac-address=112233445568 interface=ether1 comment=ranabhai
        // $query = new Query('/ip/arp/add');
        // $query->equal('address', '172.168.2.30');
        // $query->equal('mac-address', '912233113318');
        // // $query->equal('type', 'bypassed');
        // $query->equal('published', 'yes');
        // $query->equal('disabled', 'no');
        // // $query->equal('invalid ', 'yes');
        // $query->equal('interface', 'ether1');
        // $query->equal('comment', 'l House-9, Road-4, Sector-12, Uttara');

        // $response = $client->query($query)->read();
        // $query = new Query('/ip/arp/remove');
        // $query = new Query('/ip/arp/set');

        // $query->equal('.id', '*21');
        // $query->equal("address", "172.168.2.21");
        // $query->equal('mac-address', '00:00:00:00:00:00');
        // $query->equal('disabled', 'no');
        // $query->equal('complete', false);
        // $query->tag(29);

        // $response = $client->query($query)->read();

        // $response = $client->q('/ip/arp/remove/')->r();
        //End ARP
        // ip arp remove

        // // Start Queue
        // // name="bhai" target=172.168.2.5/32 parent=All max-limit=2M/2M comment="bhai-road5"
        // $query = new Query('/queue/simple/add');
        // $query->equal('name', 'testJoyda');
        // $query->equal('target', '172.168.2.21/32');
        // $query->equal('parent', 'bhai');
        // // $query->equal('interface', 'ether1');
        // $query->equal('max-limit', '1M/1M');
        // $query->equal('comment', 'House-9, Road-4, Sector-12, Uttara for queue');

        // $response = $client->q($query)->r();

        // $response = $client->qr('/queue/simple/print');
        // $response = $client->qr('/ip/arp/print');
        // //End Queue

        // $response = $client->q('/tool/user-manager/profile/limitation/print')->r();
        // $response = $client->q('/tool/user-manager/profile/profile-limitation/print')->r();

        // Limit Add Start
        // $query = new Query('/tool/user-manager/profile/limitation/add');
        // $query->equal("name", "5M"); //*
        // $query->equal("owner", "admin"); //*
        // $query->equal("download-limit", "0");
        // $query->equal("upload-limit", "0");
        // $query->equal("transfer-limit", "0");
        // $query->equal("uptime-limit", "0s");
        // $query->equal("name-for-users", "Rabbi 2");
        // $query->equal("starts-at", "logon");
        // $query->equal("price", "0");
        // $response = $client->query($query)->read();
        // $response = $client->q('/tool/user-manager/profile/limitation/print')->r();
        // Limit Add End
        // Remove
        // $query = new Query('/tool/user-manager/profile/limitation/remove');
        // $query->equal('.id', '*3');
        // $response = $client->query($query)->read();
        // End Remove

        // $response = $client->q('/tool/user-manager/profile/limitation/print')->r();
        return $response;
        // $result = User::first(['shared-users', 'actual-profile', 'username']);
        // dd($result['shared-users'], $result['actual-profile'], $result);
    }
}
