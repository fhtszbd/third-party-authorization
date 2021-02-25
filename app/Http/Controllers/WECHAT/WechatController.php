<?php


namespace App\Http\Controllers\WECHAT;


use App\Http\Controllers\Controller;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;


class WechatController extends Controller
{
    public function serve()
    {
        $app = app('wechat.official_account');

        $app->server->push(function ($message){
            if($message['MsgType'] == 'event'){
                if($message['Event'] == 'subscribe'){
                    return "感谢关注，请回复关键字，获取您想要的信息";
                }
            }elseif ($message['MsgType'] == 'text'){
                //查询数据的信息，根据回复的信息回复相应的数据$message['Content']
                $news = new NewsItem([
                    'title' => '方海婷测试',
                    'description' => '方海婷的描述',
                    'url' => 'https://www.baidu.com/',
                    'image' => 'https://gimg2.baidu.com/image_search/src=http%3A%2F%2Fb-ssl.duitang.com%2Fuploads%2Fitem%2F201902%2F20%2F20190220211449_BHP2F.thumb.400_0.jpeg&refer=http%3A%2F%2Fb-ssl.duitang.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1616807454&t=7304aca4b0c58e037cc1b21d3e991fe5'
                ]);
                return new News([$news]);
            }
        });
        return $app->server->serve();
    }

}
