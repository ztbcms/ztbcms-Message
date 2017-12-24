<extend name="../../Admin/View/Common/base_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;" v-cloak>
        <h4>搜索</h4>
        <hr>
        <div class="search_type cc mb10">
            消息源：<input type="text" v-model="where.target" name="" class="input">
            发送者：<input type="text" v-model="where.sender" name="" class="input">
            接收者：<input type="text" v-model="where.receiver" name="" class="input">
            是否处理：<select v-model="where.process_status"  style="background: white;height: 28px;">
                <option value="">处理状态</option>
                <option value="0">未处理</option>
                <option value="1">已处理</option>
            </select>
            是否阅读：<select v-model="where.read_status" style="background: white;height: 28px;">
                <option value="">处理状态</option>
                <option value="0">未读</option>
                <option value="1">已读</option>
            </select>
            <button @click="getList" class="btn btn-primary" style="margin-left: 8px;">搜索</button>
        </div>
        <hr>
        <form action="" method="post">
            <div class="table_list">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr style="background: ghostwhite;">
                            <td width="50" align="center">ID</td>
                            <td width="100" align="center">消息源</td>
                            <td width="100" align="center">发送者</td>
                            <td width="100" align="center">接收者</td>
                            <td align="center">标题</td>
                            <td align="center">内容</td>
                            <td width="80" align="center">阅读状态</td>
                            <td width="80" align="center">处理状态</td>
                            <td width="120" align="center">创建时间</td>
                            <td width="120" align="center">发送时间</td>
                            <td width="120" align="center">阅读时间</td>
                            <td width="100" align="center">消息类型</td>
                            <td width="120" align="center">类名</td>
                            <td width="120" align="center">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items">
                            <td align="center">
                                {{ item.id }}
                            </td>
                            <td align="center">
                                {{ item.target }}
                                <p style="color: grey">{{ item.target_type }}</p>
                            </td>
                            <td >
                                {{ item.sender }}
                                <p style="color: grey">
                                    {{ item.sender_type }}
                                </p>
                            </td>
                            <td >
                                {{ item.receiver }}
                                <p style="color: grey">
                                    {{ item.receiver_type }}
                                </p>
                            </td>
                            <td >{{ item.title }}</td>
                            <td >{{ item.content }}</td>
                            <td >
                            <span class="label"
                                  :class="{'label-success':item.read_status==1,'label-danger':item.read_status!=1}">
                            {{ item.read_status == 1 ? '已读':'未读' }}
                            </span>
                            </td>
                            <td align="center">
                            <span class="label"
                                  :class="{'label-success':item.process_status == 1,'label-danger':item.process_status == 0, 'label-warning':item.process_status == 2}">

                                <template v-if="item.process_status == 0">
                                    未处理
                                </template>

                                <template v-if="item.process_status == 1">
                                    已处理
                                </template>

                                 <template v-if="item.process_status == 2">
                                    处理中
                                </template>
                            </span>
                            </td>
                            <td align="center">
                                <p>{{ item.create_time | getFormatTime }}</p>
                            </td>
                            <td align="center">
                                <p>{{ item.send_time | getFormatTime }}</p>
                            </td>
                            <td align="center">
                                <p>{{ item.read_time | getFormatTime }}</p>
                            </td>
                            <td align="center">
                                {{ item.type }}
                            </td>
                            <td align="center">
                                <p>{{ item.class }}</p>
                            </td>
                            <td >
                                <button type="button" class="btn btn-primary" @click="handleMessage(item.id)">触发处理</button>
                            </td>
                        </tr>
                    </tbody>
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

    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    items: [],
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
                        if(value == '' || value == 0){
                            return '/';
                        }
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
                        var that = this;
                        var where = {
                            page: this.page,
                            limit: this.limit,
                            where: this.where
                        };
                        $.ajax({
                            url: "{:U('Message/Message/getMessageList')}",
                            data: where,
                            dataType: 'json',
                            type: 'get',
                            success: function (res) {
                                var data = res.data;
                                that.items = data.items;
                                that.page = data.page;
                                that.limit = data.limit;
                                that.page_count = data.page_count;
                            }
                        })
                    },
                    //处理消息
                    handleMessage: function (message_id){
                        $.ajax({
                            url: "{:U('Message/Message/handleMessage')}",
                            data: {
                                message_id: message_id
                            },
                            dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                if(res.status){
                                    layer.msg('操作完成！');
                                }else{
                                    layer.msg(res.msg);
                                }
                            }
                        });
                    }
                },
                mounted: function () {
                    this.getList();
                }
            })
        })
    </script>
</block>
