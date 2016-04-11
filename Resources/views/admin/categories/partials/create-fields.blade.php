<div class="box-body">
    <div class='form-group{{ $errors->has("{$lang}[title]") ? ' has-error' : '' }}'>
        {!! Form::label("{$lang}[title]", trans('blog::category.form.name')) !!}
        {!! Form::text("{$lang}[title]", Input::old("{$lang}[title]"), ['class' => 'form-control', 'data-slug' => 'source', 'placeholder' => trans('blog::category.form.name')]) !!}
        {!! $errors->first("{$lang}[title]", '<span class="help-block">:message</span>') !!}
    </div>
    <div class='form-group{{ $errors->has("{$lang}[slug]") ? ' has-error' : '' }}'>
       {!! Form::label("{$lang}[slug]", trans('blog::category.form.slug')) !!}
       {!! Form::text("{$lang}[slug]", Input::old("{$lang}[slug]"), ['class' => 'form-control slug', 'data-slug' => 'target', 'placeholder' => trans('blog::category.form.slug')]) !!}
       {!! $errors->first("{$lang}[slug]", '<span class="help-block">:message</span>') !!}
   </div>
</div>
