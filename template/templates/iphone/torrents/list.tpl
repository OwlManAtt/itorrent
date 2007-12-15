<ul id='torrent-list' title='{$page_html_title}' selected='true'>
    <li class='group'>Leeching</li>
    {section name=index loop=$incomplete_torrents}
    {assign var='torrent' value=$incomplete_torrents[index]}
    
    {if $torrent.active == 1}
        {assign var='color' value='black'}
    {else}
        {assign var='color' value='gray'}
    {/if}
    <li><a style='color: {$color}' href='#torrent_{$torrent.hash}'>{$torrent.title|truncate:24:"...":true}</a></li> 
    {sectionelse}
    <li style='font-style: italic; color: gray;'>None</li>
    {/section}
    <li class='group'>Seeding</li>
    {section name=index loop=$complete_torrents}
    {assign var='torrent' value=$complete_torrents[index]}
    
    {if $torrent.active == 1}
        {assign var='color' value='black'}
    {else}
        {assign var='color' value='gray'}
    {/if}
    <li><a style='color: {$color}' href='#torrent_{$torrent.hash}'>{$torrent.title|truncate:24:"...":true}</a></li> 
    {sectionelse}
    <li style='font-style: italic; color: gray;'>None</li>
    {/section}
</ul>

{section name=index loop=$torrents}
{assign var='torrent' value=$torrents[index]}
<div id='torrent_{$torrent.hash}' class='panel'>
    <h2>{$torrent.title|truncate:30:"...":true}</h2>
    <fieldset>
        <div class='row'>
            <label>Status</label>
            <span>{if $torrent.active == 1}Active{else}Paused{/if}</span>
        </div>
        <div class='row'>
            <label>Size</label>
            <span>{if $torrent.status == 'incomplete'}{$torrent.size.downloaded} / {/if}{$torrent.size.total}</span>
        </div>
        <div class='row'>
            <label>UL Speed</label>
            <span>{$torrent.rate.up}</span>
        </div>
        {if $torrent.status == 'incomplete'}
        <div class='row'>
            <label>DL Speed</label>
            <span>{$torrent.rate.down}</span>
        </div>
        <div class='row'>
            <label>ETA</label>
            <span>{$torrent.eta}</span>
        </div>
        <div class='row'>
            <label>Progress</label>
            <span>
                <div class='progress-border'>
                    <div class='progress-bar' style='width: {$torrent.percent_complete}%;'>&nbsp;</div>
                </div>
            </span>
        </div>
        {/if}
        <div class='row'>
            <label>Ratio</label>
            <span>{$torrent.ratio}</span>
        </div>
    </fieldset>
    
    <form id='s-{$torrent.hash}' action='{$display_settings.public_dir}/toggle-status' method='post' onSubmit="return confirm('Are you sure?');">
        <input type='hidden' name='hash_id' value='{$torrent.hash}' />
        <a type='submit' class='whiteButton' href='#'>{if $torrent.active == 1}Pause{else}Start{/if}</a>
    </form>
    <form id='r-{$torrent.hash}' action='{$display_settings.public_dir}/remove-torrent' method='post'>
        <input type='hidden' name='hash_id' value='{$torrent.hash}' />
        <a type='submit' class='grayButton' href='#'>Remove</a>
    </form>

</div>
{/section}
