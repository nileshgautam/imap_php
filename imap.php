<h1>Gmail Email Inbox using PHP with IMAP</h1>
<?php
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
    for ($i = 0; $i < count($emailDataAnswered); $i++) {
        // print_r($emailDataAnswered[$i]);
        $Allheader = imap_fetch_overview($connection, $emailDataAnswered[$i], 0);
        if (!empty($emailData)) {
            // print_r($emailData);    
            foreach ($emailData as $email) {
                $header = imap_fetch_overview($connection, $email, 0);
                if($Allheader[0]->subject==$header[0]->subject){
                    $groupedarr[$i]=$header[0];
                }

                // print_r($header[0]->subject);
            }
        }
    }
    print_r($groupedarr);
    imap_close($connection);
}
    ?>
    </div>