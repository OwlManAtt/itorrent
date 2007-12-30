<p>Enter the URL to a torrent. Magnet links are not supported in rTorrent (wink wink nudge nudge), so don't enter those. Since rTorrent uses libcurl to get torrents, it probably supports http, https, ftp, ftps, scp, sftp, telnet, tftp, telnet, dict, ldap, and ldaps.</p>

<form action='{$display_settings.public_dir}/{$self.slug}' method='post'>
    <input type='hidden' name='state' value='add' />

    <div align='center'>
        <table class='inputTable' width='40%'>
            <tr>
                <td colspan='2' class='inputTableHead'>Add Torrent</td>
            </tr>
            <tr>
                <td class='inputTableRow inputTableSubhead'>URL</td>
                <td class='inputTableRow'>
                    <input type='text' name='torrent[uri]' size='40' />
                </td>
            </tr>
            <tr>
                <td class='inputTableRowAlt inputTableSubhead'>Pause</td>
                <td class='inputTableRowAlt'>
                    <input type='checkbox' name='torrent[pause]' value='false' />
                </td>
            </tr>
            <tr>
                <td colspan='2' class='inputTableRow' style='text-align: right;'>
                    <input type='submit' value='Add' />
                </td>
            </tr>
        </table>
    </div>
</form>
