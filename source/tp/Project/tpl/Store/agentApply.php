<include file="Public:header"/>
<div class="mainbox">
    <div id="nav" class="mainnav_title">
        <ul>
            <a href="{pigcms{:U('Store/agentApply')}" class="on">申请列表</a>
        </ul>
    </div>
    <table class="search_table" width="100%">
        <tr>
            <td>
                <form action="{pigcms{:U('Store/agentApply')}" method="get">
                    <input type="hidden" name="c" value="Store"/>
                    <input type="hidden" name="a" value="agentApply"/>
                    筛选: <input type="text" name="keyword" class="input-text" value="{pigcms{$_GET['keyword']}"/>
                    <select name="type">
                        <option value="id"<if condition="$_GET['type'] eq 'store_id'">selected="selected"</if>>申请编号</option>
                        <option value="store_id"<if condition="$_GET['type'] eq 'uid'">selected="selected"</if>>店铺编号</option>
                        <option value="name"<if condition="$_GET['type'] eq 'name'">selected="selected"</if>>申请姓名</option>
                        <option value="tel"<if condition="$_GET['type'] eq 'tel'">selected="selected"</if>>联系电话</option>
                        <option value="uid"<if condition="$_GET['type'] eq 'uid'">selected="selected"</if>>用户id</option>
                    </select>
                    &nbsp;&nbsp;代理类型：
                    <select name="agent_type">
                        <option value="*">代理类型</option>
                        <option value="1">食品</option>
                        <option value="2">数码</option>
                        <option value="3">日用百货</option>
                    </select>
                    &nbsp;&nbsp;认证：
                    <select name="status">
                        <option value="*">认证状态</option>
                        <option value="0" <?php if (isset($_GET['status']) && is_numeric($_GET['status']) && $_GET['status'] == 0) { ?>selected<?php } ?>>
                            未认证
                        </option>
                        <option value="1"<if condition="$Think.get.status eq 1">selected</if>>已认证</option>
                    </select>
                    <input type="submit" value="查询" class="button"/>
                </form>
            </td>
        </tr>
    </table>
    <form name="myform" id="myform" action="{pigcms{:U('Store/agentApply')}" method="post">
        <div class="table-list">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>编号</th>
                    <th >用户id</th>
                    <th >店铺id</th>
                    <th >申请姓名</th>
                    <th >申请店铺名称</th>
                    <th >代理品类</th>
                    <th >手机</th>
                    <th >身份证号</th>
                    <th >所在地区</th>
                    <th >详细地址</th>
                    <th >是否付款</th>
                    <th >申请时间</th>
                    <th >操作</th>
                </tr>
                </thead>
                <tbody>
                <if condition="is_array($agents)">
                    <volist name="agents" id="agent">
                        <tr>
                            <td>{pigcms{$agent.id}</td>
                            <td>{pigcms{$agent.uid}</td>
                            <td>{pigcms{$agent.store_id}</td>
                            <td>{pigcms{$agent.name}</td>
                            <td>{pigcms{$agent.store_name}</td>
                            <td>
                                <?php echo str_replace(array('464','175','176'),array('食品类','数码类','日用百货'),$agent['agent_type']);?>
                            </td>
                            <td>{pigcms{$agent.tel}</td>
                            <td>{pigcms{$agent.idcard}</td>
                            <td>{pigcms{$agent.area}</td>
                            <td>{pigcms{$agent.address_detail}</td>
                            <td style="color:<?= $agent['status']==1?'green':'red'?>;">
                                <if condition="$agent['status'] eq 1">已付款
                                    <else/>
                                    未付款
                                </if>
                            </td>
                            <td>{pigcms{$agent.apply_time}</td>
                            <?php if(session('system.account')=='ywswatch'):?>
                                <td></td>
                            <?php else:?>
                                <td class="cate_status">
                                    <span class="cb-enable status-enable">
                                        <label class="cb-enable <if condition="$agent['approve'] eq 1">selected</if>
                                                "data-id="<?php echo $agent['store_id']; ?>
                                                " data-status="{pigcms{$agent.approve}">
                                            <span>认证</span>
                                            <input type="radio" name="status" value="1" <if condition="$agent['status'] eq 1">checked="checked"</if> />
                                        </label>
                                    </span>

                                    <span class="cb-disable status-disable">
                                        <label class="cb-disable <if condition="$agent['approve'] eq 0">selected</if>
                                                " data-id="<?php echo $agent['store_id']; ?>
                                        " data-status="{pigcms{$agent.approve}">
                                        <span>取消</span>
                                        <input type="radio" name="status" value="0" <if condition="$agent['status'] eq 0">checked="checked"</if>/>
                                        </label>
                                    </span>
                                </td>
                            <?php endif;?>
                        </tr>
                    </volist>
                    <tr>
                        <td class="textcenter pagebar" colspan="13">{pigcms{$page}</td>
                    </tr>
                <else/>
                    <tr>
                        <td class="textcenter red" colspan="13">列表为空！</td>
                    </tr>
                </if>
                </tbody>
            </table>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('.cate_status > .status-enable > .cb-enable').click(function () {
            if (!$(this).hasClass('selected')) {
                var url = window.location.href;
                var store_id = $(this).data('id');
                $.post("<?php echo U('Store/approve'); ?>", {
                    'approve': 1,
                    'store_id': store_id
                }, function (data) {
                    window.location.href = url;
                });
            }
            if (parseFloat($(this).data('status')) == 0) {
                $(this).removeClass('selected');
            }
            return false;
        });
        $('.cate_status > .status-disable > .cb-disable').click(function () {
            if (!$(this).hasClass('selected')) {
                var url = window.location.href;
                var store_id = $(this).data('id');
                if (!$(this).hasClass('selected')) {
                    $.post("<?php echo U('Store/approve'); ?>", {
                        'approve': 0,
                        'store_id': store_id
                    }, function (data) {
                        window.location.href = url;
                    });
                }
            }
            return false;
        });

    })
</script>
<include file="Public:footer"/>