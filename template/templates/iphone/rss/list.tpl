<h2>{$feed.name}</h2>
<ul id='rss_list' title='RSS Feeds' selected='true' showFeedButton='true'>
    <li class='group'>{$feed.name}</li>
    {section name=index loop=$items}
    {assign var='item' value=$items[index]}
    {cycle values='inputTableRowAlt,inputTableRow' assign='class'}
        <li><a style='{$item.style}' href='#rss_{$item.internal_id}'>{$item.title_details.title|truncate:24:"...":true}</a></li>
    {sectionelse}
    <li style='color; gray;'>No items</li>
    {/section}
</ul>

<form id='feedList' class='dialog' action='{$display_settings.public_dir}/{$self.slug}' method='post'>
    <fieldset>
        <h1>RSS Feeds</h1>
        <a type='cancel' href='#' class='button leftButton'>Cancle</a>
        <a type='submit' href='#' class='button rightButton'>View</a>

        <div class='row'>
            <label>Feed</label>
            <span>
                <select name='feed_id'>
                    {html_options options=$feed_menu selected=$feed.id}
                </select>
            </span>
        </div>
    </fieldset>
</form>

{section name=index loop=$items}
{assign var='item' value=$items[index]}
{cycle values='inputTableRowAlt,inputTableRow' assign='class'}
<div id='rss_{$item.internal_id}' class='panel'>
    <h2>{$item.title_details.title|truncate:30:"...":true}</h2>
    <fieldset>
        <div class='row'>
            <label>Date</label>
            <span>{$item.datetime}</span>
        </div>
        {if $item.title_details.group != ''}
         <div class='row'>
            <label>Group</label>
            <span>{$item.title_details.group}</span>
        </div>
        {/if}
        {if $item.title_details.filetype != ''}
         <div class='row'>
            <label>Filetype</label>
            <span>{$item.title_details.filetype}</span>
        </div>
        {/if}
    </fieldset>

    <form action='{$display_settings.public_dir}/add-torrent' method='post'>
        <input type='hidden' name='state' value='add' />
        <input type='hidden' name='torrent[uri]' value='{$item.url}' />
        <a type='submit' href='#' class='whiteButton'>Download</a>
    </form>
</div>
{/section}

