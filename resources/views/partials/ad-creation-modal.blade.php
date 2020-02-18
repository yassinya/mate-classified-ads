 <!-- Ad creation modal -->
 <div class="modal fade" id="post-ad-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Post an ad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/" method="POST">
                        <div class="form-group">
                            <input type="text" name="title" id="title" placeholder="Post title" class="form-control">
                        </div>
                        <div class="form-group">
                            <textarea rows="4" name="description" id="description" placeholder="Post description" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <select name="category-id" id="category" class="form-control">
                                <option value="-" selected>Pick a category</option>
                                <optgroup label="Electronics">
                                    <option value="1">Samsungs Phones</option>
                                    <option value="2">Iphones</option>
                                    </optgroup>
                                    <optgroup label="German Cars">
                                    <option value="3">Mercedes</option>
                                    <option value="4">Audi</option>
                                    </optgroup>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="Enter your email address" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone-number" id="phone-number" placeholder="Enter a phone number (Optional)" class="form-control">
                        </div>
                    </form>
                </div>
                    <div id="dropzone" class="dropzone"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Post</button>
                </div>
            </div>
        </div>
    </div>