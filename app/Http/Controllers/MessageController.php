<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\UserCred;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cred = UserCred::where('user_id', auth()->id())->first();
        return Message::Create([
            'id' => $request->id,
            'user_id' => $cred->user_id,
            'credential_id' => $cred->credential_id,
            'chatId' => $request->chatId,
            'body' => isset($request->body) ? $request->body : null,
            'from_me' => $request->from_me,
            'type' => $request->type,
            'author' => isset($request->author) ? $request->author : null,
            'caption' => isset($request->caption) ? $request->caption : null,
            'sender_name' => isset($request->senderName) ? $request->senderName : null,
            'message_number' => isset($request->messageNumber) ? $request->messageNumber : null,
            'time' => date('Y-m-d H:i:s', now()->timestamp)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    public function sendText(Request $request)
    {
        $client = new Client();
        $data = [
            "body" => $request->body,
            "chatId" => $request->chatId,
        ];
        // dd($data);
        $result = $client->request('POST', $request->instance . 'sendMessage?token=' . $request->token, ['form_params' => $data])->getBody()->getContents();
        return $result;
    }

    public function sendFile(Request $request)
    {
        $client = new Client();
        $data = [
            "body" => 'https://e-lpkn.id' . $request->url,
            "filename" => $request->filename,
            "chatId" => $request->chatId,
            "caption" => isset($request->caption) ? $request->caption : null
        ];
        // dd($data);
        $result = $client->request('POST', $request->instance . 'sendFile?token=' . $request->token, ['form_params' => $data])->getBody()->getContents();
        return $result;
    }

    public function messages()
    {
        $client = new Client();
        $result = $client->request('GET', env('WA_URL') . 'messages' . env('WA_TOKEN'))->getBody()->getContents();
        return $result;
    }

    public function latest()
    {
        $client = new Client();
        $result = $client->request('GET', env('WA_URL') . 'messagesHistory' . env('WA_TOKEN'))->getBody()->getContents();
        return $result;
    }

    public function delete()
    {
        $client = new Client();
        $data = [
            "messageId" => "aa"
        ];
        $result = $client->request('POST', env('WA_URL') . 'deleteMessage' . env('WA_TOKEN'), ['form_params' => $data])->getBody()->getContents();
        return $result;
    }

    public function contact()
    {
        return Message::whereNotNull('user_id')->with('user')->get();
    }
}
