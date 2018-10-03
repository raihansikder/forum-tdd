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
                                <li>
                                    <b><a href="#">{{$reply->owner->name}}</a>
                                        said {{$reply->created_at->diffForHumans()}}</b>
                                    {{$reply->body}}
                                </li>
                            @endforeach
                        </ul>
                        <hr/>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    hello
                </div>
            </div>
        @endif
    </div>
@endsection
