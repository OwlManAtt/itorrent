{if $alert != ''}<ul><li id='alert' class='{$fat}'>{$alert}</li></ul>{/if}

<a name='leeching' />
<table class='inputTable'>
    <tr>
        <td colspan='4' class='inputTableHead'>Leeching</td>
    </tr>
    {section name=index loop=$incomplete_torrents}
    {assign var='torrent' value=$incomplete_torrents[index]}

    {if $torrent.active == 1}
        {assign var='inactive' value=''}
        {assign var='icon' value='green.png'}
    {else}
        {assign var='inactive' value=' inactive'}
        {assign var='icon' value='red.png'}
    {/if}

    {cycle values='inputTableRowAlt,inputTableRow' assign='class'}
    <tr>
        <td class='{$class}{$inactive} center' width='16'>
            <form action='{$display_settings.public_dir}/toggle-status' method='post'>
                <input type='hidden' name='hash_id' value='{$torrent.hash}' />
                <input type='image' src='{$display_settings.public_dir}/resources/images/icons/{$icon}' alt='{if $torrent.active == 1}A{else}I{/if}' />
            </form>
            <form action='{$display_settings.public_dir}/remove-torrent' method='post'>
                <input type='hidden' name='hash_id' value='{$torrent.hash}' />
                <input type='image' src='{$display_settings.public_dir}/resources/images/icons/red_x.png' alt='Rm' />
            </form>
        </td>
        <td class='{$class}{$inactive}'>
            {$torrent.title|truncate:37:"...":true}<br/>
            {$torrent.size.downloaded} / {$torrent.size.total} ({$torrent.percent_complete}%)</td>
        <td class='{$class}{$inactive}' width='130'>
            {if $torrent.active == 1}
		{$torrent.rate.up}/s / {$torrent.rate.down}/s<br/>
            {/if}
            {$torrent.eta}
        </td>
    </tr>
    {sectionelse}
    <tr>
        <td colspan='7' class='inputTableRowAlt empty-table'>No torrents are being downloaded.</td>
    </tr>
    {/section}
</table>

<br /><br />

<a name='seeding' />
<table class='inputTable' width='95%'>
    <tr>
        <td colspan='6' class='inputTableHead'>Seeding</td>
    </tr>
    <tr>
        <td class='inputTableRow inputTableSubhead center' style='width: 20px;'>&nbsp;</td>
        <td class='inputTableRow inputTableSubhead center' style='width: 20px;'>&nbsp;</td>
        <td class='inputTableRow inputTableSubhead center'>Name</td>
        <td class='inputTableRow inputTableSubhead center'>Size</td>
        <td class='inputTableRow inputTableSubhead center'>Upload Speed</td>
        <td class='inputTableRow inputTableSubhead center'>Ratio</td>
    </tr>
    {section name=index loop=$complete_torrents}
    {assign var='torrent' value=$complete_torrents[index]}

    {if $torrent.active == 1}
        {assign var='inactive' value=''}
        {assign var='icon' value='green.png'}
    {else}
        {assign var='inactive' value=' inactive'}
        {assign var='icon' value='red.png'}
    {/if}

    {cycle values='inputTableRowAlt,inputTableRow' assign='class'}
    <tr>
        <td class='{$class}{$inactive} center'>
            <form action='{$display_settings.public_dir}/toggle-status' method='post'>
                <input type='hidden' name='hash_id' value='{$torrent.hash}' />
                <input type='image' src='{$display_settings.public_dir}/resources/images/icons/{$icon}' alt='{if $torrent.active == 1}A{else}I{/if}' />
            </form>
        </td>
         <td class='{$class}{$inactive} center'>
            <form action='{$display_settings.public_dir}/remove-torrent' method='post'>
                <input type='hidden' name='hash_id' value='{$torrent.hash}' />
                <input type='image' src='{$display_settings.public_dir}/resources/images/icons/red_x.png' alt='Rm ' />
            </form>
        </td>
        <td class='{$class}{$inactive}'><span title='{$torrent.title}'>{$torrent.title|truncate:45:"...":true}</span></td>
        <td class='{$class}{$inactive}'>{$torrent.size.total}</td>
        <td class='{$class}{$inactive}'>{$torrent.rate.up}/s</td>
        <td class='{$class}{$inactive}'>{$torrent.ratio}</td>
    </tr>
    {sectionelse}
    <tr>
        <td colspan='6' class='inputTableRowAlt empty-table'>No torrents are being seeded.</td>
    </tr>
    {/section}
</table>

<br /><br />

<div align='right'>
    <table border='0'>
        <tr>
            <td align='center'>
                <form action='{$display_settings.public_dir}/add-torrent' method='get'>
                    <input type='submit' value='Add Torrent' />
                </form>
            </td>
            <td align='center'>
                <form action='{$display_settings.public_dir}/stop-all-torrents' method='post'>
                    <input type='submit' value='Stop All Torrents' />
                </form>
            </td>
        </tr> 
    </table>
</div>
