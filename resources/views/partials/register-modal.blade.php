 <!-- Ad creation modal -->
 <div class="modal fade {{ $errors->any() ? 'open-it' : null }}" id="register-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('register.post') }}" method="POST">
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <i class="fas fa-info"></i> {{ $error }}<br>
                            @endforeach       
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="first_name" id="first=bame" placeholder="First name" value="{{ old('first_name') }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" id="first=name" placeholder="Last name" value="{{ old('last_name') }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="John.p@example.com" value="{{ old('email') }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone_number" id="phone-number" placeholder="Enter a phone number (optional)" value="{{ old('phone_number') }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="password-confirmation" placeholder="confirm password" required class="form-control">
                    </div>
                    {{ csrf_field() }}                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>