<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed" style="padding:10px;">
<style>
    td p {
        font-size: 12px;
        color: #999999;
    }
</style>
<div id="app">
    <div class="h_a">搜索</div>
    <div>
        <div class="search_type cc mb10">
            消息源：<input type="text" v-model="where.target" name="" class="input">
            发送者：<input type="text" v-model="where.sender" name="" class="input">
            接收者：<input type="text" v-model="where.receiver" name="" class="input">
            是否处理：<select v-model="where.process_status" name="" id="">
                <option value="">处理状态</option>
                <option value="0">未处理</option>
                <option value="1">已处理</option>
            </select>
            是否阅读：<select v-model="where.read_status" name="" id="">
                <option value="">处理状态</option>
                <option value="0">未读</option>
                <option value="1">已读</option>
            </select>
            <button @click="getList" class="btn">搜索</button>
        </div>
    </div>
    <form class="J_ajaxForm" action="" method="post">
        <div class="table_list">
            <table width="100%">
                <thead>
                <tr>
                    <td width="50" align="center">id</td>
                    <td width="100" align="center">消息源</td>
                    <td width="100" align="center">发送者</td>
                    <td width="100" align="center">接收者</td>
                    <td align="center">内容</td>
                    <td width="80" align="center">阅读状态</td>
                    <td width="80" align="center">处理状态</td>
                    <td width="120" align="center">创建时间</td>
                    <td width="120" align="center">发送时间</td>
                    <td width="100" align="center">消息类型</td>
                    <td width="120" align="center">实例化的类名</td>
                </tr>
                </thead>
                <tr v-for="item in lists">
                    <td align="center">
                        {{ item.id }}
                    </td>
                    <td align="center">
                        {{ item.target }}
                        <p>{{ item.target_type }}</p>
                    </td>
                    <td align="center">
                        {{ item.sender }}
                        <p>
                            {{ item.sender_type }}
                        </p>
                    </td>
                    <td align="center">
                        {{ item.receiver }}
                        <p>
                            {{ item.receiver_type }}
                        </p>
                    </td>
                    <td align="center">{{ item.content }}</td>
                    <td align="center">
                        <span class="label"
                              :class="{'label-success':item.read_status==1,'label-danger':item.read_status!=1}">
                        {{ item.read_status == 1 ? '已读':'未读' }}
                        </span>
                    </td>
                    <td align="center">
                        <span class="label"
                              :class="{'label-success':item.process_status==1,'label-danger':item.process_status!=1}">
                        {{ item.process_status==1 ? '已处理': '未处理' }}
                        </span>
                    </td>
                    <td align="center">
                        <p>{{ item.create_time | getFormatTime }}</p>
                    </td>
                    <td align="center">
                        <p>{{ item.send_time | getFormatTime }}</p>
                    </td>
                    <td align="center">
                        {{ item.type }}
                    </td>
                    <td align="center">
                        <p>{{ item.class }}</p>
                    </td>
                </tr>
            </table>
            <div v-if="page_count > 1" style="text-align: center">
                <ul class="pagination pagination-sm no-margin">
                    <li>
                        <a @click="page > 1 ? (page--) : '' ;getList()" href="javascript:;">上一页</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ page }} / {{ page_count }}</a>
                    </li>
                    <li><a @click="page<page_count ? page++ : '' ;getList()" href="javascript:;">下一页</a></li>
                </ul>
            </div>
        </div>
    </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script src="//cdn.bootcss.com/vue/2.2.6/vue.js"></script>
<script>
    $(document).ready(function () {
        new Vue({
            el: '#app',
            data: {
                lists: [],
                page: 1,
                limit: 20,
                page_count: 0,
                total: 0,
                where: {
                    process_status: '',
                    read_status: ''
                }
            },
            filters: {
                getFormatTime: function (value) {
                    var time = new Date(parseInt(value * 1000));
                    var y = time.getFullYear();
                    var m = time.getMonth() + 1;
                    var d = time.getDate();
                    var h = time.getHours();
                    var i = time.getMinutes();
                    var res = y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d)
                    res += '  ' + (h < 10 ? '0' + h : h) + ':' + (i < 10 ? '0' + i : i);
                    return res;
                },
            },
            methods: {
                getList: function () {
                    var that = this
                    var where = {
                        page: this.page,
                        limit: this.limit,
                        where: this.where
                    }
                    $.ajax({
                        url: "{:U('index')}",
                        data: where,
                        dataType: 'json',
                        type: 'get',
                        success: function (res) {
                            console.log(res)
                            var data = res.info
                            that.lists = data.lists
                            that.page = data.page
                            that.limit = data.limit
                            that.page_count = data.page_count
                        }
                    })
                },
            },
            mounted: function () {
                this.getList();
            }
        })
    })
</script>
</body>
</html>