@extends('redminportal::layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('redminportal::menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/products') }}">{{ Lang::get('redminportal::menus.products') }}</a></li>
                <li class="active">{{ Lang::get('redminportal::forms.edit') }}</li>
            </ol>
        </div>
    </div>
    
    @include('redminportal::partials.errors')

    {!! Form::open(array('files' => TRUE, 'action' => '\Redooor\Redminportal\App\Http\Controllers\ProductController@postStore', 'role' => 'form')) !!}
        {!! Form::hidden('id', $product->id) !!}

    	<div class='row'>
            <div class="col-md-3 col-md-push-9">
                <div class="well">
                    <div class='form-actions'>
                        {!! HTML::link('admin/products', Lang::get('redminportal::buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                        {!! Form::submit(Lang::get('redminportal::buttons.save'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                    </div>
                </div>
                <div class='well well-small'>
                    <div class="form-group">
                        <div class="checkbox">
                            <label for="featured-checker">
                                {!! Form::checkbox('featured', $product->featured, $product->featured, array('id' => 'featured-checker')) !!} {{ Lang::get('redminportal::forms.featured') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="active-checker">
                                {!! Form::checkbox('active', $product->active, $product->active, array('id' => 'active-checker')) !!} {{ Lang::get('redminportal::forms.active') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">{{ Lang::get('redminportal::forms.category') }}</div>
                    </div>
                    <div class="panel-body">
                        {!! Form::hidden('category_id', $product->category_id, array('id' => 'category_id')) !!}
                        <ul class="redooor-hierarchy">
                        @foreach ($categories as $item)
                            <li>{!! $item->printCategory() !!}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
                <div>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                      <div>
                        <span class="btn btn-default btn-file"><span class="fileupload-new">{{ Lang::get('redminportal::forms.select_image') }}</span><span class="fileupload-exists">{{ Lang::get('redminportal::forms.change_image') }}</span>{!! Form::file('image') !!}</span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">{{ Lang::get('redminportal::forms.remove_image') }}</a>
                      </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-md-pull-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('redminportal::forms.edit_product') }}</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs" id="lang-selector">
                           @foreach(\Config::get('redminportal::translation') as $translation)
                           <li><a href="#lang-{{ $translation['lang'] }}">{{ $translation['name'] }}</a></li>
                           @endforeach
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="lang-en">
                                <div class="form-group">
                                    {!! Form::label('name', Lang::get('redminportal::forms.title')) !!}
                                    {!! Form::text('name', $product->name, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('short_description', Lang::get('redminportal::forms.summary')) !!}
                                    {!! Form::text('short_description', $product->short_description, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('long_description', Lang::get('redminportal::forms.description')) !!}
                                    {!! Form::textarea('long_description', $product->long_description, array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                </div>
                            </div>
                            @foreach(\Config::get('redminportal::translation') as $translation)
                                @if($translation['lang'] != 'en')
                                <div class="tab-pane" id="lang-{{ $translation['lang'] }}">
                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_name', Lang::get('redminportal::forms.title')) !!}
                                        @if ($translated)
                                        {!! Form::text($translation['lang'] . '_name', (array_key_exists($translation['lang'], $translated) ? $translated[$translation['lang']]->name : ''), array('class' => 'form-control')) !!}
                                        @else
                                        {!! Form::text($translation['lang'] . '_name', null, array('class' => 'form-control')) !!}
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_short_description', Lang::get('redminportal::forms.summary')) !!}
                                        @if ($translated)
                                        {!! Form::text($translation['lang'] . '_short_description', (array_key_exists($translation['lang'], $translated) ? $translated[$translation['lang']]->short_description : ''), array('class' => 'form-control')) !!}
                                        @else
                                        {!! Form::text($translation['lang'] . '_short_description', null, array('class' => 'form-control')) !!}
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_long_description', Lang::get('redminportal::forms.description')) !!}
                                        @if ($translated)
                                        {!! Form::textarea($translation['lang'] . '_long_description', (array_key_exists($translation['lang'], $translated) ? $translated[$translation['lang']]->long_description : ''), array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                        @else
                                        {!! Form::textarea($translation['lang'] . '_long_description', null, array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('redminportal::forms.product_properties') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label('sku', Lang::get('redminportal::forms.sku')) !!}
                            {!! Form::text('sku', $product->sku, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('price', Lang::get('redminportal::forms.price')) !!}
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!! Form::text('price', $product->price, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', Lang::get('redminportal::forms.tags_separated_by_comma')) !!}
                            {!! Form::text('tags', $tagString, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                @if (count($product->images) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('redminportal::forms.uploaded_photos') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class='row'>
                            @foreach ($product->images as $image)
                            <div class='col-md-3'>
                                {!! HTML::image($imagine->getUrl($image->path), $product->name, array('class' => 'img-thumbnail', 'alt' => $image->path)) !!}
                                <br><br>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ URL::to('admin/products/imgremove/' . $image->id) }}" class="btn btn-danger btn-confirm">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a href="{{ URL::to($imagine->getUrl($image->path, 'large')) }}" class="btn btn-primary btn-copy">
                                        <span class="glyphicon glyphicon-link"></span>
                                    </a>
                                    <a href="{{ URL::to($imagine->getUrl($image->path, 'large')) }}" class="btn btn-info" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <script src="{{ URL::to('vendor/redooor/redminportal/js/bootstrap-fileupload.js') }}"></script>
    <script>
        !function ($) {
            $(function(){
                $('#lang-selector li').first().addClass('active');
                $('#lang-selector a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
                // On load, check if previous category exists for error message
                function checkCategory() {
                    $selected_val = $('#category_id').val();
                    if ($selected_val != '') {
                        $('.redooor-hierarchy a').each(function() {
                            if ($(this).attr('href') == $selected_val) {
                                $(this).addClass('active');
                            }
                        });
                    }
                }
                checkCategory();
                // Change selected category
                $(document).on('click', '.redooor-hierarchy a', function(e) {
                    e.preventDefault();
                    $selected = $(this).attr('href');
                    $('#category_id').val($selected);
                    $('.redooor-hierarchy a.active').removeClass('active');
                    $(this).addClass('active');
                });
            })
        }(window.jQuery);
    </script>
    @include('redminportal::plugins/tinymce')
@stop
