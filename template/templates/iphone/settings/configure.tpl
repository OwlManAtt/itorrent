<form action='{$display_settings.public_dir}/{$self.slug}' method='post' class='panel' selected='true'>
    <input type='hidden' name='state' value='save' />
    
    <h2>Global rTorrent Limits</h2>
    <fieldset>
        <div class='row'>
            <label>UL Slots</label>
            <input type='text' name='settings[global][max_upload_slot]' value='{$global.max_upload_slot}' size='4' />
        </div>
        <div class='row'>
            <label>DL Slots</label>
            <input type='text' name='settings[global][max_download_slot]' value='{$global.max_download_slot}' size='4' />
        </div>
        <div class='row'>
            <label>UL kb/s</label>
            <input type='text' name='settings[global][max_upload_rate]' value='{$global.max_upload_rate}' size='4' />
        </div>
        <div class='row'>
            <label>DL kb/s</label>
            <input type='text' name='settings[global][max_download_rate]' value='{$global.max_download_rate}' size='4' />
        </div>
    </fieldset>
   
    <h2>Per-Torrent Limits</h2>
    <fieldset>
        <div class='row'>
            <label>UL Slots</label>
            <input type='text' name='settings[per_torrent][max_upload_slot]' value='{$per_torrent.max_upload_slot}' size='4' />
        </div>
        <div class='row'>
           <label>Peer Slots</label>
           <input type='text' name='settings[per_torrent][max_peer_slot]' value='{$per_torrent.max_peer_slot}' size='4' />
        </div>
        <div class='row'>
            <label>Seed Slots</label>
            <input type='text' name='settings[per_torrent][max_seed_slot]' value='{$per_torrent.max_seed_slot}' size='4' />
        </div>
    </fieldset>
    <a type='submit' class='whiteButton' href='#'>Save</a>
</form>
