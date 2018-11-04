<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelCreateRequest;
use App\Http\Resources\ChannelResource;
use App\Model\Channel;
use App\Model\Workspace;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function show(Request $request, Workspace $workspace, Channel $channel)
    {
        // 今のところ、ワークスペースに参加しているユーザーのみ
        $this->authorize('showChannel', $workspace); // workspacePolicyが発動
        return new ChannelResource($channel);
    }

    public function store(ChannelCreateRequest $request, Workspace $workspace)
    {
        // 今のところ、ワークスペースに参加しているユーザーのみ
        $this->authorize('storeChannel', $workspace); // workspacePolicyが発動
        $channel = new Channel;
        $channel->name = $request->name;
        $channel->workspace_id = $workspace->id;
        $channel->save();

        return new ChannelResource($channel);
    }
}
