<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<h1>Gmail Email Inbox using PHP with IMAP</h1>
<?php
    if (! function_exists('imap_open')) {
        echo "IMAP is not configured.";
        exit();
    } else {
        ?>
<div id="listData" class="list-form-container">
    <?php
        
        /* Connecting Gmail server with IMAP */
        $connection = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 
        'nileshwephyre', 'gautam@@123') or die('Cannot connect to Gmail: ' . imap_last_error());
        
        /* Search Emails having the specified keyword in the email subject */
        $emailData = imap_search($connection, 'ANSWERED');
        
        
        if (! empty($emailData)) {
            // echo "<pre>";
            ?>
    <table>
        <?php
        // echo '<pre>';

            foreach ($emailData as $emailIdent) {

                // print_r($emailIdent);
            // die;
                
                $overview = imap_fetch_overview($connection, $emailIdent, 0);
                // print_r($overview[0]);

                $message = imap_fetchbody($connection, $emailIdent, '2');

                // print_r($message);

                $messageExcerpt = substr($message, 0, 150);
                // $messageExcerpt = $message;

                $partialMessage = trim(quoted_printable_decode($messageExcerpt)); 
                $date = date("d F, Y", strtotime($overview[0]->date));
                ?>
         <tr>
            <td><span class="column">
                    <?php echo $overview[0]->from; ?>

            </span></td>
            <td class="content-div"><span class="column">
                    
            <?php echo $overview[0]->subject; ?> - 

                    <?php echo $partialMessage; ?>

            </span><span class="date">
                    <?php echo $date; ?>
            </span>
        </td>
        </tr> 
        <?php
            } // End foreach
            ?>
    </table>
    <?php
    // die;
        } // end if
        
        imap_close($connection);
    }
    ?>
</div>