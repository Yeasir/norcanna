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
                        $registration_email_text_to_admin = get_field('registration_email_text_to_admin','option');
                        if(!empty($registration_email_text_to_admin)){
                            echo $registration_email_text_to_admin;
                        }else{
                        ?>
                            <p>Hi there,</p>
                            <p>New User has been registered! Please check and approve.</p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td> <a href="{USER_LIST_PAGE}?approve_user={USER_ID}&_wpnonce={NONCE}" target="_blank">Approve</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p>Good luck! Hope it works.</p>
                        <?php };?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- END MAIN CONTENT AREA -->
</table>

<?php include 'email-footer.php';?>