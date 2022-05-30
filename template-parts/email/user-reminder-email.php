<?php include 'email-header.php';?>

<!-- START CENTERED WHITE CONTAINER -->
<table role="presentation" class="main">

    <!-- START MAIN CONTENT AREA -->
    <tr>
        <td class="wrapper">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        $reminder_email_text_to_user = get_field('user_reminder_email_text','option');
                        if(!empty($reminder_email_text_to_user)){
                            echo $reminder_email_text_to_user;
                        }else{
                        ?>
                            <p>Hi {FULL_NAME},</p>
                            <p>You not complete your registration process. Please complete your registration process.</p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td> <a href="{HOME_URL}?autosave={RES_ID}&_wpnonce={NONCE}" target="_blank">Complete Registration</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p>Thank you!</p>
                        <?php };?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- END MAIN CONTENT AREA -->
</table>

<?php include 'email-footer.php';?>