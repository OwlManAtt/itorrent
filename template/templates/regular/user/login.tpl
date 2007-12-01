<p align='center'>Please authenticate.</p>

<div align='center'>
    <form action='{$display_settings.public_dir}/login/' method='post'>
        <input type='hidden' name='state' value='process' />
        
        <table class='inputTable'>
            <tr>
                <td class='inputTableRow inputTableSubhead'><label for='username'>User Name</label></td>
                <td class='inputTableRow' id='username_td'>
                    <input type='text' name='user[username]' id='username' maxlength='25' /><br />
                </td>
            </tr>

            <tr>
                <td class='inputTableRowAlt inputTableSubhead'><label for='password'>Password</label></td>
                <td class='inputTableRowAlt' id='password_td'>
                    <input type='password' name='user[password]' id='password' /><br />
                </td>
            </tr>
            
            <tr>
                <td class='inputTableRow inputTableSubhead'>&nbsp;</td>
                <td class='inputTableRow' style='text-align: right;'> 
                    <input type='submit' value='Login' />
                </td>
            </tr>
        </table>
    </form>
</div>

<p style='font-size: small;' align='center'>{kkkurl link_text='Forgot your password?' slug='reset-password'}</p>
