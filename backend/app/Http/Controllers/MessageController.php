<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Model\Channel;
use App\Model\Message;
use App\Model\Workspace;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // 指定チャンネルのメッセージを昇順に取得する
    public function indexInChannel(Request $request, Workspace $workspace, Channel $channel)
    {
        // todo: あとで、authorize

        // 投稿先がチャンネルで、かつチャンネルidが一致するもの
        $messages = Message::where([
            ['messageable_type', '=', 'App\\Model\\Channel'],
            ['messageable_id', '=', $channel->id],
        ])->get();

        return MessageResource::collection($messages);
    }

    public function storeToChannel(Request $request, Workspace $workspace, Channel $channel)
    {
        // todo: あとで、authorize入れる

        // メッセージ作成
        $message = new Message;
        $message->body = $request->body;
        $message->user()->associate($request->user()); // 投稿者の設定
        $channel->messages()->save($message); // チャンネルに対してメッセージを投稿する

        return new MessageResource($message);
    }
}
