<?php

namespace App\Http\Controllers;

use App\Model\Channel;
use App\Model\Message;
use App\Model\Workspace;
use Illuminate\Http\Request;

class StarController extends Controller
{
    // スターがついていなかったら、付ける
    // そうでなければ、はずす
    public function changeStar(Request $request, Workspace $workspace, Channel $channel, Message $message)
    {
        // 対象のメッセージにスターを付けた人を取得する
        $staredUsers = $message->starUsers;

        $count = 0;
        foreach ($staredUsers as $staredUser) {
            if ($staredUser->pivot->user_id == $request->user()->id && $staredUser->pivot->message_id == $message->id) {
                $count++;
            }
        }

        // 既にスターした
        if ($count > 0) {
            $message->starUsers()->detach([
                'user_id' => $request->user()->id,
                'message_id' => $message->id,
            ]);
        } else {
            $message->starUsers()->attach([
                'user_id' => $request->user()->id,
                'message_id' => $message->id,
            ]);
        }
    }
}
