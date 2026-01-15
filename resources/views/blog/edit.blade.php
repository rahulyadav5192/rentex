{{Form::model($blog, array('route' => array('blog.update', $blog->id), 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'blog-form')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('title',__('Blog Title'),array('class'=>'form-label'))}}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Blog Title'), 'required' => 'required'))}}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('image', __('Thumbnail Image'), ['class' => 'form-label']) }}
            {{ Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) }}
            <small class="text-muted">{{ __('Leave empty to keep current image. Recommended size: 800x600px') }}</small>
            @if (!empty($blog->image))
                @php
                    $currentImageUrl = fetch_file($blog->image, 'upload/blog/image/');
                @endphp
                @if (!empty($currentImageUrl))
                    <div class="mt-2">
                        <img src="{{ $currentImageUrl }}" alt="Current Image" 
                             style="max-width: 200px; max-height: 150px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;"
                             onerror="this.style.display='none';">
                    </div>
                @endif
            @endif
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('category', __('Category'), ['class' => 'form-label']) }}
            {{ Form::text('category', null, ['class' => 'form-control', 'placeholder' => __('e.g., Technology, Business, Development')]) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('author', __('Author'), ['class' => 'form-label']) }}
            {{ Form::text('author', null, ['class' => 'form-control', 'placeholder' => __('Author Name')]) }}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('tags', __('Tags'), ['class' => 'form-label']) }}
            {{ Form::text('tags', null, ['class' => 'form-control', 'placeholder' => __('Comma separated tags, e.g., tag1, tag2, tag3')]) }}
            <small class="text-muted">{{ __('Separate tags with commas') }}</small>
        </div>

        <div class="form-group col-md-12">
            {{Form::label('description',__('Short Description'),array('class'=>'form-label'))}}
            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('Brief description of the blog (max 500 characters)'), 'maxlength' => '500']) }}
            <small class="text-muted">{{ __('This will be shown in blog listings') }}</small>
        </div>

        <div class="form-group col-md-12">
            {{Form::label('content',__('Content'),array('class'=>'form-label'))}}
            {!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'classic-editor', 'required' => 'required', 'rows' => 15]) !!}
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('meta_title', __('Meta Title (SEO)'), ['class' => 'form-label']) }}
            {{ Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => __('SEO meta title (max 255 characters)'), 'maxlength' => '255']) }}
            <small class="text-muted">{{ __('For search engines') }}</small>
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('meta_description', __('Meta Description (SEO)'), ['class' => 'form-label']) }}
            {{ Form::textarea('meta_description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('SEO meta description (max 500 characters)'), 'maxlength' => '500']) }}
            <small class="text-muted">{{ __('For search engines') }}</small>
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('enabled', __('Publish Blog'), ['class' => 'form-label']) }}
            {{ Form::hidden('enabled', 0) }}
            <div class="form-check form-switch">
                {{ Form::checkbox('enabled', 1, $blog->enabled, ['class' => 'form-check-input', 'role' => 'switch', 'id' => 'enabled']) }}
                {{ Form::label('enabled', __('Enable this blog to be visible on the website'), ['class' => 'form-check-label']) }}
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Update'),array('class'=>'btn btn-secondary btn-rounded'))}}
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
</div>
{{ Form::close() }}
