<div>
    <table border='0'>
        <tr>
            <td style='font-weight: bold;'>View Feed:</td>
            <td>
                <form action='{$display_settings.public_dir}/{$self.slug}' method='get'>
                    <select name='feed_id' id='feed_id' onChange="if(this.form.feed_id[this.form.feed_id.selectedIndex].value != '{$feed.id}') this.form.submit()">
                        {html_options options=$feed_menu selected=$feed.id}
                    </select>
                </form>
            </td>
        </tr>
    </table>
    <table class='inputTable' width='100%'>
        <tr>
            <td colspan='2' class='inputTableHead'>{$feed.name}</td>
       </tr>
<!--
       <tr>
            <td class='inputTableRow inputTableSubhead'>&nbsp;</td>
            <td class='inputTableRow inputTableSubhead'>Title</td>
            <td class='inputTableRow inputTableSubhead'>Published</td>
            <td class='inputTableRow inputTableSubhead'>InfoHash</td>
        </tr>
-->
        {section name=index loop=$items}
        {assign var='item' value=$items[index]}
        {cycle values='inputTableRowAlt,inputTableRow' assign='class'}
        <tr>
            <td class='{$class}' style='text-align: center; {$item.style}'>
                <form action='{$display_settings.public_dir}/add-torrent' method='post'>
                    <input type='hidden' name='state' value='add' />
                    <input type='hidden' name='torrent[uri]' value='{$item.url}' />
                    <input type='image' src='{$display_settings.public_dir}/resources/images/icons/green_plus.png' alt='+' />
                </form>
            </td>
            <td class='{$class}' style='{$item.style}'>{if $item.icon != ''}<img src='{$display_settings.public_dir}/resources/images/icons/{$item.icon}' border='0' alt='-->' />&nbsp;{/if}<span title='{$item.title}'>{$item.title|truncate:60:"...":true}</span><br/>{$item.datetime}</td>
            <!--<td class='{$class}' style='{$item.style}'>{$item.info_hash}</td>-->
        </tr>
        {sectionelse}
        <tr>
            <td colspan='3' class='inputTableRowAlt empty-table'>There are no items in this RSS feed.</td>
        </tr>
        {/section}
    </table>
</div>
