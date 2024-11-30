<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use Illuminate\Http\Request;

class TestEventController extends Controller
{
    public function fireTestEvent(Request $request) {
        $data = $request->data;
        // $data = [
        //     'user_id' => 1,
        //     'message' => 'hello world',
        // ];
        TestEvent::dispatch($data);
        // return json_encode($message);
        return json_encode(['message' => 'success']);
    }

}
