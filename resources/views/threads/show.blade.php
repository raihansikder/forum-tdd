@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>

                    <div class="card-body">
                        <article>
                            <h4>{{$thread->title}}</h4>
                            <div class="body">{{$thread->body}}</div>
                        </article>

                        <ul>
                            @foreach($thread->replies as $reply)
                                <li>{{$reply->body}}</li>
                            @endforeach
                        </ul>
                        <hr/>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
