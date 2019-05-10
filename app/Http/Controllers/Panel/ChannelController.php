<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $channels = $request->user()->channels()->where('status', '=', 1)->orderBy('id', 'desc')->paginate(15);

        return view('panel.channels.index')
            ->with([
                'pageTitle' => __('Channels'),
                'channels' => $channels
            ]);
    }

    public function add(Request $request)
    {
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:channels,username',
            'allowed_users' => 'required'
        ];
        $this->validate($request, $rules);

        try {
            return \DB::transaction(function () use ($request) {
                $channel = $request->user()->channels()->create([
                    'name' => $request->name,
                    'username' => $request->username,
                ]);
                $channel->channel_users()->delete();
                foreach (explode(',', $request->allowed_users) as $user) {
                    if($user) {
                        $channel->channel_users()->create([
                            'username' => $user
                        ]);
                    }
                }
                return redirect()->back()
                    ->with([
                        'alert' => 'success',
                        'message' => __('Added')
                    ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->with([
                    'alert' => 'error',
                    'message' => __('Error')
                ]);
        }
    }

    public function edit(Request $request)
    {
        $rules = [
            'id' => 'required|exists:channels,id,user_id,' . $request->user()->id,
            'allowed_users' => 'required'
        ];
        $this->validate($request, $rules);

        try {
            return \DB::transaction(function () use ($request) {
                $channel = $request->user()->channels()->where('id', '=', $request->id)->first();

                $channel->channel_users()->delete();
                foreach (explode(',', $request->allowed_users) as $user) {
                    if($user) {
                        $channel->channel_users()->create([
                            'username' => $user
                        ]);
                    }
                }
                return redirect()->back()
                    ->with([
                        'alert' => 'success',
                        'message' => __('Changes Saved')
                    ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->with([
                    'alert' => 'error',
                    'message' => __('Error')
                ]);
        }
    }

    public function delete(Request $request)
    {
        $rules = [
            'id' => 'required|exists:channels,id,user_id,' . $request->user()->id,
        ];
        $this->validate($request, $rules);

        try {
            return \DB::transaction(function () use ($request) {

                $channel = $request->user()->channels()->where('id', '=', $request->id)->first();
                $channel->channel_users()->delete();
                $channel->delete();

                return redirect()->back()
                    ->with([
                        'alert' => 'success',
                        'message' => __('Deleted')
                    ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->with([
                    'alert' => 'error',
                    'message' => __('Error')
                ]);
        }
    }
}
