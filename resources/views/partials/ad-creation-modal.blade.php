 <!-- Ad creation modal -->
 <div class="modal fade {{ old('modal') == 'ad' ? 'open-it' : null }}" id="post-ad-modal" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Post an ad</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="{{ route('ads.create.post') }}" method="POST" id="ad-submission-form">
                 <div class="modal-body">
                    @if ($errors->any() && old('modal') == 'ad')
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <i class="fas fa-info"></i> {{ $error }}<br>
                            @endforeach       
                        </div>
                    @endif
                     <div class="form-group">
                         <input type="text" name="title" id="title" placeholder="Post title" class="form-control">
                     </div>
                     <div class="form-group">
                         <textarea rows="4" name="description" id="description" placeholder="Post description"
                             class="form-control"></textarea>
                     </div>
                     <div class="form-group">
                         <select name="category_id" id="category" class="form-control">
                             <option value="-" selected>Pick a category</option>
                             @foreach ($categories as $mainCategory)
                                 @if ($mainCategory->children->count() > 0)
                                    <optgroup label="{{ $mainCategory }}">
                                        @foreach ($mainCategory->children as $subCategory)                                            
                                            <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    </optgroup>
                                 @else
                                    <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                 @endif
                             @endforeach
                         </select>
                     </div>
                     <div class="form-group">
                         <input type="email" name="email" id="email" placeholder="Enter your email address"
                             class="form-control">
                     </div>
                     <div class="form-group">
                         <input type="text" name="phone_number" id="phone-number"
                             placeholder="Enter a phone number (Optional)" class="form-control">
                     </div>
                     <input type="hidden" name="modal" value="ad">
                     {{ csrf_field() }}
                 </div>
                 <div id="dropzone" class="dropzone"></div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-primary">Post</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
