@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add marks</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/add/marks/1') }}">
                        {{ csrf_field() }}
                        @foreach (array_combine($sub,$marks_1_1) as $subs )
                          <?php
                            $subject=$subs['1'];
                            $marks=$subs['2'];
                            $temp=explode('x',$subject);
                            //var_dump($temp);
                            $showName=$temp['1'];
                          ?>
                        <div class="form-group{{ $errors->has('$subject') ? ' has-error' : '' }}">
                            <label for="{{ $subject }}" class="col-md-4 control-label">{{ strtoupper($showName) }}</label>

                            <div class="col-md-6">
                                <input id="{{ $subject }}" type="text" class="form-control" name="{{ $subject }}" value="{{ $marks }}">

                                @if ($errors->has('$subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('$subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        <!--<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Save
                                </button>
                            </div>
                        </div>-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
