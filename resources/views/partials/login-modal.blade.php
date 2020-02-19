 <!-- Ad creation modal -->
 <div class="modal fade {{ old('modal') == 'login' ? 'open-it' : null }}" id="login-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('login.post') }}" method="POST">
                <div class="modal-body">
                    @if ($errors->any() && old('modal') == 'login')
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <i class="fas fa-info"></i> {{ $error }}<br>
                            @endforeach       
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="email" name="email" id="email" placeholder="John.p@example.com" value="{{ old('modal') == 'login' ? old('email') : null }}" required class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" placeholder="Password" required class="form-control">
                    </div>
                    <input type="hidden" name="modal" value="login">
                    {{ csrf_field() }}                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>