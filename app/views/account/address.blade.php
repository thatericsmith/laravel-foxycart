@include('_partials/header')
<div class="main">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    @if(Session::get('alert'))
                    <div class="alert alert-{{Session::has('alert-type') ? Session::get('alert-type') : 'danger'}}">
                        {{Session::get('alert')}}
                    </div>
                    @endif

                    <h1>Address</h1>

                        {{Form::model($user, ['route' => 'account.address.post'])}}

                            <div class="form-group">
                                {{Form::label('first_name', 'First Name')}}
                                {{Form::text('first_name',null,['class'=>'form-control'])}}
                            </div>                            
                            <div class="form-group">
                                {{Form::label('last_name', 'Last Name')}}
                                {{Form::text('last_name',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('company', 'Company')}}
                                {{Form::text('company',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('address1', 'Address')}}
                                {{Form::text('address1',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('address2', 'Address 2')}}
                                {{Form::text('address2',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('city', 'City')}}
                                {{Form::text('city',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('state', 'State')}}
                                {{Form::text('state',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('postal_code', 'Zip')}}
                                {{Form::text('postal_code',null,['class'=>'form-control'])}}
                            </div>
                            
                            <div class="form-group">
                                {{Form::label('phone', 'Phone')}}
                                {{Form::text('phone',null,['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('email', 'Email')}}
                                {{Form::email('email',null,['class'=>'form-control'])}}
                            </div>
                        <div class="footer">                                                               
                            <button type="submit" class="btn btn-primary">Save</button>  
                            <a href="{{route('account.index')}}" class="btn btn-link">Cancel and go back</a>  
                            
                        </div>
                    {{Form::close()}}

                </div>
            </div>
</div>

@include('_partials/footer')