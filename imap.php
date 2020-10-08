<h1>Gmail Email Inbox using PHP with IMAP</h1>
<?php

function group_by($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}
// 
if (!function_exists('imap_open')) {
    echo "IMAP is not configured.";
    exit();
} else {
?>
    <div id="listData" class="list-form-container">
    <?php

    /* Connecting Gmail server with IMAP */

    $connection = imap_open(
        '{imap.gmail.com:993/imap/ssl}INBOX',
        'nileshwephyre',
        'gautam@@123'
    ) or die('Cannot connect to Gmail: ' . imap_last_error());

    /* Search Emails having the specified keyword in the email subject */
    $emailData = imap_search($connection, 'ALL');

    $emailDataAnswered = imap_search($connection, 'ANSWERED');
    echo '<pre>';

    $groupedarr = [];
    $groupby=[];
    $result=array();
    for ($i = 0; $i < count($emailDataAnswered); $i++) {
        // print_r($emailDataAnswered[$i]);
        $Allheader = imap_fetch_overview($connection, $emailDataAnswered[$i], 0);
        if (!empty($emailData)) {
            // print_r($emailData);    
            foreach ($emailData as $email) {
                $header = imap_fetch_overview($connection, $email, 0);
                if ($Allheader[0]->subject == $header[0]->subject) {
                    $head = explode(':', $header[0]->subject);
                    // print_r($head[0]=='Re');
                    // $allhead=explode(':',)
                    if($head[0]=='Re'){
                        array_push($groupedarr,$header[0]);
                    foreach($groupedarr as $gar){

                        if(array_key_exists($header[0]->subject, $gar)){
                            $result[$gar[$header[0]->subject]][] = $gar;
                        }else{
                            $result[""][] = $gar;
                        }
                        // $groupby= group_by($header[0]->subject,$gar);
                        // print_r($gar);
                    }
                    }

                }

                // print_r($header[0]->subject);
            }
        }
    }
    // foreach($groupedarr as $replyed){
    //     // print_r($replyed->header);
    // }
    // print_r($groupedarr);
    print_r($result);
    imap_close($connection);

   
}
    ?>
    </div>