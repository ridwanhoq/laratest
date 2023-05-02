@extends('layouts.app')

@section('content')
    <div class="card m-4">
        <div class="card-header">
            Chat with your friend
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="text-success text-left">
                                <strong>You : </strong> Username 1
                                <p>
                                    your message
                                </p>
                            </div>
                            <div class="text-info pull-right">
                                <strong>Friend : </strong> Username 2
                                <p>
                                    friend's message
                                </p>
                            </div>

                            {!! Form::open() !!}

                                {!! Form::label('message', 'Message') !!}

                                {!! Form::textarea('message', null, ['class' => 'form-control']) !!}

                                {!! Form::button('Send', ['class' => 'btn btn-sm btn-success mt-2', 'id' => 'sendButton']) !!}
                                
                            {!! Form::close() !!}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        $('#sendButton').on('click', function(){
            $.ajax({
                url: '',
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
                ,
                type: 'POST',
                data: data,
                success: function(res){

                }
            });
        });
    </script>
    
@endsection
