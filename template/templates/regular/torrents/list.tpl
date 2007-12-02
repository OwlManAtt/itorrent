<table class='inputTable' width='95%'>
    <tr>
        <td colspan='6' class='inputTableHead'>Leeching</td>
    </tr>
    <tr>
        <td class='inputTableRow inputTableSubhead center' style='width: 20px;'>&nbsp;</td>
        <td class='inputTableRow inputTableSubhead center'>Name</td>
        <td class='inputTableRow inputTableSubhead center'>Size</td>
        <td class='inputTableRow inputTableSubhead center'>Speed (U / D)</td>
        <td class='inputTableRow inputTableSubhead center'>ETA</td>
        <td class='inputTableRow inputTableSubhead center' style='width: 140px'>Progress</td>
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
        <td class='{$class}{$inactive} center'><img src='{$display_settings.public_dir}/resources/images/icons/{$icon}' border='0' alt='{if $torrent.active == 1}A{else}I{/if}' /></td>
        <td class='{$class}{$inactive}'>{$torrent.title}</td> 
        <td class='{$class}{$inactive}'>{$torrent.size.downloaded} / {$torrent.size.total}</td> 
        <td class='{$class}{$inactive}'>{$torrent.rate.up} / {$torrent.rate.down}</td> 
        <td class='{$class}{$inactive}'>{$torrent.eta}</td> 
        <td class='{$class}{$inactive}'>
            <div class='progress-border'>
                <div class='progress-bar' style='width: {$torrent.percent_complete}%;'>&nbsp;</div>
            </div>
        </td> 
    </tr>
    {sectionelse}
    <tr>
        <td class='inputTableAlt empty-table'>No torrents are being downloaded.</td> 
    </tr>
    {/section}
    
    
</table>

<br /><br />

<table class='inputTable' width='95%'>
    <tr>
        <td colspan='5' class='inputTableHead'>Seeding</td>
    </tr>
    <tr>
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
        <td class='{$class}{$inactive} center'><img src='{$display_settings.public_dir}/resources/images/icons/{$icon}' border='0' alt='{if $torrent.active == 1}A{else}I{/if}' /></td>
        <td class='{$class}{$inactive}'>{$torrent.title}</td> 
        <td class='{$class}{$inactive}'>{$torrent.size.total}</td> 
        <td class='{$class}{$inactive}'>{$torrent.rate.up}</td> 
        <td class='{$class}{$inactive}'>{$torrent.ratio}</td> 
    </tr>
    {sectionelse}
    <tr>
        <td class='inputTableAlt empty-table'>No torrents are being seeded.</td> 
    </tr>
    {/section}

    
</table>
