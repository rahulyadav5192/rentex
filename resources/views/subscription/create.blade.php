{{ Form::open(array('url' => 'subscriptions')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{Form::label('title',__('Title'),array('class'=>'form-label'))}}
            {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter subscription title'),'required'=>'required'))}}
        </div>
        <div class="form-group">
            {{ Form::label('interval', __('Interval'),array('class'=>'form-label')) }}
            {!! Form::select('interval', $intervals, null,array('class' => 'form-control basic-select','required'=>'required')) !!}
        </div>
        <div class="form-group">
            {{Form::label('package_amount',__('Package Amount'),array('class'=>'form-label'))}}
            {{Form::number('package_amount',null,array('class'=>'form-control','placeholder'=>__('Enter package amount'),'step'=>'0.01'))}}
        </div>
        <div class="form-group">
            {{Form::label('user_limit',__('User Limit'),array('class'=>'form-label'))}}
            {{Form::number('user_limit',null,array('class'=>'form-control','placeholder'=>__('Enter user limit'),'required'=>'required'))}}
        </div>
        <div class="form-group">
            {{Form::label('property_limit',__('Property Limit'),array('class'=>'form-label'))}}
            {{Form::number('property_limit',null,array('class'=>'form-control','placeholder'=>__('Enter property limit'),'required'=>'required'))}}
        </div>
        <div class="form-group">
            {{Form::label('tenant_limit',__('Tenant Limit'),array('class'=>'form-label'))}}
            {{Form::number('tenant_limit',null,array('class'=>'form-control','placeholder'=>__('Enter tenant limit'),'required'=>'required'))}}
        </div>
        <div class="form-group">
            {{Form::label('description',__('Description'),array('class'=>'form-label'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter plan description'),'rows'=>'3'))}}
        </div>
        <div class="form-group col-md-6">
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-secondary" name="enabled_logged_history" id="enabled_logged_history">
                {{Form::label('enabled_logged_history',__('Show User Logged History'),array('class'=>'form-label'))}}
              </div>
        </div>
        <div class="form-group col-md-6">
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-secondary" name="most_popular" id="most_popular">
                {{Form::label('most_popular',__('Most Popular Plan'),array('class'=>'form-label'))}}
              </div>
        </div>
        <div class="form-group col-md-6">
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-secondary" name="email_notification" id="email_notification">
                {{Form::label('email_notification',__('Email Notification'),array('class'=>'form-label'))}}
              </div>
        </div>
        <div class="form-group col-md-6">
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-secondary" name="subdomain" id="subdomain">
                {{Form::label('subdomain',__('Subdomain'),array('class'=>'form-label'))}}
              </div>
        </div>
        <div class="form-group col-md-6">
            <div class="form-check form-switch custom-switch-v1 mb-2">
                <input type="checkbox" class="form-check-input input-secondary" name="custom_domain" id="custom_domain">
                {{Form::label('custom_domain',__('Add Custom Domain'),array('class'=>'form-label'))}}
              </div>
        </div>
        <div class="form-group">
            {{Form::label('yearly_discount',__('Yearly Discount (%)'),array('class'=>'form-label'))}}
            {{Form::number('yearly_discount',20,array('class'=>'form-control','placeholder'=>__('Enter yearly discount percentage'),'min'=>'0','max'=>'100','step'=>'1'))}}
            <small class="form-text text-muted">{{ __('Discount percentage applied when billing annually (e.g., 20 for 20% off)') }}</small>
        </div>

    </div>
</div>
<div class="modal-footer">
    {{Form::submit(__('Create'),array('class'=>'btn btn-secondary btn-rounded'))}}
</div>
{{ Form::close() }}

