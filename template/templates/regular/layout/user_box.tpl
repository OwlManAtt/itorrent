<div id='user-box'>
    <ul id='user-info'>
        <li><strong>Username</strong>: {kkkurl link_text=$user->getUserName() slug='profile' args=$user->getUserId()}</li>
    </ul>
    <ul id='user-actions'>
        {* <li>{kkkurl link_text='Preferences' slug='preferences'}</li> *}
        <li>{kkkurl link_text='Logout' slug='logoff'}</li>
    </ul>
</div>
