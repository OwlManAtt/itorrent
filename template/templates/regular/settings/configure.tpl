{if $alert != ''}<ul><li id='alert' class='{$fat}'>{$alert}</li></ul>{/if}

<p>Global limits apply to all the aggregate of all torrents. Per-torrent settingapply to each individual torrent. Remember that <strong>0 = unlimited</strong>!</p>

<form action='{$display_settings.public_dir}/{$self.slug}' method='post'>
    <input type='hidden' name='state' value='save' />

    <div align='center'>
        <table class='inputTable' width='50%'>
            <tr>
                <td class='inputTableHead' colspan='2'>Global rTorrent Limits</td>
            </tr>

            <tr>
                <td class='inputTableRow inputTableSubhead' width='30%'>Max Upload Slots</td>
                <td class='inputTableRow'>
                    <input type='text' name='settings[global][max_upload_slot]' value='{$global.max_upload_slot}' size='4' />
                </td>
            </tr>
            <tr>
                <td class='inputTableRowAlt inputTableSubhead' width='30%'>Max Download Slots</td>
                <td class='inputTableRowAlt'>
                    <input type='text' name='settings[global][max_download_slot]' value='{$global.max_download_slot}' size='4' />
                </td>
            </tr>
            <tr>
                <td class='inputTableRow inputTableSubhead' width='30%'>Max Upload Speed</td>
                <td class='inputTableRow'>
                    <input type='text' name='settings[global][max_upload_rate]' value='{$global.max_upload_rate}' size='4' /> kb/s
                </td>
            </tr>
            <tr>
                <td class='inputTableRowAlt inputTableSubhead' width='30%'>Max Download Speed</td>
                <td class='inputTableRowAlt'>
                    <input type='text' name='settings[global][max_download_rate]' value='{$global.max_download_rate}' size='4' /> kb/s
                </td>
            </tr>
        </table>

        <br /><br />

        <table class='inputTable' width='50%'>
            <tr>
                <td class='inputTableHead' colspan='2'>Per-Torrent Limits</td>
            </tr>
            <tr>
                <td class='inputTableRow inputTableSubhead' width='30%'>Upload Slots</td>
                <td class='inputTableRow'>
                    <input type='text' name='settings[per_torrent][max_upload_slot]' value='{$per_torrent.max_upload_slot}' size='4' />
                </td>
            </tr>
            <tr>
               <td class='inputTableRowAlt inputTableSubhead' width='30%'>Peer Slots</td>
                <td class='inputTableRowAlt'>
                    <input type='text' name='settings[per_torrent][max_peer_slot]' value='{$per_torrent.max_peer_slot}' size='4' />
                </td>
            </tr>
            <tr>
                <td class='inputTableRow inputTableSubhead' width='30%'>Seeding Slots</td>
                <td class='inputTableRow'>
                    <input type='text' name='settings[per_torrent][max_seed_slot]' value='{$per_torrent.max_seed_slot}' size='4' />
                </td>
            </tr>
            <tr>
                <td class='inputTableRowAlt' colspan='2' style='text-align: right;'>
                    <input type='submit' value='Save' />
                </td>
            </tr>
        </table>
    </div>
</form>
