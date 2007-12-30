<p>You may select a new password for your account. You will be logged in after you complete this step.</p>

<form action='{$display_settings.public_dir}/reset-password' method='post'>
    <input type='hidden' name='state' value='change' />
    <input type='hidden' name='substate' value='process' />
    <input type='hidden' name='user_id' value='{$user_id}' />
    <input type='hidden' name='confirm' value='{$confirm}' />

    <table class='inputTable' width='30%'>
        <tr>
            <td class='inputTableRow inputTableSubhead'>
                <label for='password_a'>New Password</label>
            </td>
            <td class='inputTableRow' id='password_a_td'>
                <input type='password' name='password[a]' id='password_a' /><br />
            </td>
        </tr>
        <tr>
            <td class='inputTableRowAlt inputTableSubhead'>
                <label for='password_b'>Repeat Password</label>
            </td>
            <td class='inputTableRowAlt' id='password_b_td'>
                <input type='password' name='password[b]' id='password_b' /><br />
            </td>
        </tr>
        <tr>
            <td class='inputTableRow' colspan='2' style='text-align: right;'>
                <input type='submit' value='Change' />
            </td>
        </tr>
    </table>
</form>
{/literal}
