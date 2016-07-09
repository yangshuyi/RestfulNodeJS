import {Component, Input} from '@angular/core';
import { OnInit } from '@angular/core';
import {Topic} from "./topic.model";

//A @Component decorator that tells Angular what template to use and how to create the component.
//associate metadata with the component class
@Component({
    selector: 'app-footer', //The selector specifies a simple CSS selector for an HTML element that represents the component.
    template: '' +
    '<div class="container">' +
    '    <div class="row">' +
    '       <div class="col-sm-12 center">&copy; 2013 <a target="_blank" href="{{url}}" title="{{footName}}">{{footName}}</a>. All Rights Reserved.</div>' +
    '   </div>' +
    '</div>' +
    '',
    styles: ['']
})

//
// <table cellspacing="0" cellpadding="0" width="100%" border=0>
// <!--{loop $list $key $value}-->
// <tr>
//     <td align="left" colspan="2">
// <span class="gray">$value[typename]名：</span><a href="space.php?do=topic&topicforecastid=$value[topicforecastid]" title="$value[subject]">$value[subject]</a><br/>
// <span class="gray">发布时间：</span>$value['producedatedisp']<br/>
// <span class="gray">标签　　：</span>$value['label']<br/>
// </td>
// <td width="24px" >&nbsp;</td>
// </tr>
// <tr>
//     <td align="left" valign="top" width="50%" >
// <span class="gray">作品类型：</span>$value[productclassname]<br/>
// <span class="gray">所属团队：</span><!--{if empty($value[clubtagid])}-->$value[club]<!--{else}--><a class="black" href="space.php?do=mtag&tagid=$value[clubtagid]" target="_blank">$value[club]</a><!--{/if}--><br/>
// <span class="gray">原著　　：</span>$value[yuanzhu]<br/>
// </td>
// <td align="left" valign="top" width="50%" >
// <span class="gray">导演：</span>$value[director]<br/>
// <span class="gray">编剧：</span>$value[writer]<br/>
// <span class="gray">后期：</span>$value[effector]<br/>
// </td>
// <td width="24px" >&nbsp;</td>
// </tr>
// <tr>
//     <td align="left" colspan="2">
// <span style="color: #EF9822;">$value[viewnum]&nbsp;次访问,&nbsp;$value[joinnum]&nbsp;次关注</span>
// </td>
// <td width="24px" >&nbsp;</td>
// </tr>
// <tr>
//     <td align="left" colspan="2" style="border-top:1px dashed #ECB2C5;">&nbsp;</td>
// <td width="24px" >&nbsp;</td>
// </tr>
// <!--{/loop}-->
// </table>
//


export class TopicSnapshotComponent{
    @Input()
    private topic: Topic;

    constructor() {
    }
}
