<div class="form-group col-sm-12">
    @include('users.partials.role_select')
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group col-sm-12">
            {!! Form::label('name', 'Name', ['class' => 'required']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter name', 'tabindex' => 1]) !!}
        </div>

        @if(isset($user))
            <div class="form-group col-sm-12">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['id' => 'userPassword', 'class' => 'form-control', 'minlength' => 8, 'placeholder' => 'Enter password at least 8 characters', 'tabindex' => 3]) !!}
                <p>Keep the <strong>password</strong> blank if you do not want to change.</p>
            </div>
        @else
            <div class="form-group col-sm-12">
                {!! Form::label('password', 'Password', ['class' => 'required']) !!}
                {!! Form::password('password', ['id' => 'userPassword', 'class' => 'form-control', 'required' => 'required', 'minlength' => 8, 'placeholder' => 'Enter password at least 8 characters', 'tabindex' => 3]) !!}
            </div>
        @endif
    </div>

    <div class="col-sm-6">
        @if(isset($user))
            <div class="form-group col-sm-12">
                {!! Form::label('email', 'Email', ['class' => 'required']) !!}
                {!! Form::email('email', $user->email, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
            </div>

            <div class="form-group col-sm-12">
                {!! Form::label('confirm_password', 'Confirm password') !!}
                {!! Form::password('confirm_password', ['id' => 'userConfirmPassword', 'class' => 'form-control', 'minlength' => 8, 'placeholder' => 'Enter confirm password at least 8 characters', 'tabindex' => 4]) !!}
                <p>Keep the <strong>confirm password</strong> blank if you do not want to change.</p>
            </div>
        @else
            <div class="form-group col-sm-12">
                {!! Form::label('email', 'Email', ['class' => 'required']) !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter email', 'tabindex' => 2]) !!}
            </div>

            <div class="form-group col-sm-12">
                {!! Form::label('confirm_password', 'Confirm password', ['class' => 'required']) !!}
                {!! Form::password('confirm_password', ['id' => 'userConfirmPassword', 'class' => 'form-control', 'required' => 'required', 'minlength' => 8, 'placeholder' => 'Enter confirm password at least 8 characters', 'tabindex' => 4]) !!}
            </div>
        @endif
    </div>
</div>

@include('partials.save_edit_action', ['route' => route('users.index')])