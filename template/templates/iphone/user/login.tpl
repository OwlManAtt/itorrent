<form action='{$display_settings.public_dir}/login/' method='post' id='login' title='Authenticate' class='panel' selected='true' target='_self'>
    <input type='hidden' name='state' value='process' />
        <h2>{$site_name} Credentials</h2>    
        <fieldset>
            <div class='row'>
                <label for='username'>User Name</label>
                <input type='text' name='user[username]' id='username' maxlength='25' />
            </div>
            
            <div class='row'> 
                <label for='password'>Password</label>
                <input type='password' name='user[password]' id='password' />
            </div>
        </fieldset>
</form>
