<p>Please fill in the following to create a new user.</p>

<div align='center'>
    <form action='{$display_settings.public_dir}/{$self.slug}' method='post'>
        <input type='hidden' name='state' value='process' />
        
        <table class='inputTable'>
            <tr>
                <td class='inputTableRow inputTableSubhead'>
                    <label for='username'>User Name</label>
                </td>
                <td class='inputTableRow' id='username_td'>
                    <input type='text' name='user[user_name]' id='username' value='' maxlength='25' />
                </td>
            </tr>
            
            <tr>
                <td class='inputTableRowAlt inputTableSubhead'>
                    <label for='password'>Password</label>
                </td>
                <td class='inputTableRowAlt' id='password_td'>
                    <input type='password' name='user[password]' id='password' value='' /><br />
                </td>
            </tr>

            <tr>
                <td class='inputTableRow inputTableSubhead'>
                    <label for='password_again'>Password Again</label>
                </td>
                <td class='inputTableRow' id='password_again_td'>
                    <input type='password' name='user[password_again]' id='password_again' value='' /><br />
                </td>
            </tr>
        
            <tr>
                <td class='inputTableRowAlt inputTableSubhead'>
                    <label for='email'>E-mail Address</label>
                </td>
                <td class='inputTableRowAlt' id='email_td'>
                    <input type='text' name='user[email]' id='email' value='' /><br />
                </td>
            </tr>

            <tr>
                <td colspan='2' class='inputTableRow' style='text-align: right;'>
                    <input type='submit' value='Submit' />
                </td>
            </tr>

        </table>
    </form>
</div>
