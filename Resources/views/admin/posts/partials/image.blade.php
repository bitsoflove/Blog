<div class="row">
    {{-- a list of images associated with this resource (filled with ajax) --}}

    @if(isset($post))
        <div id="images" @if(!is_null($post->id)) data-fetch-images data-endpoint="/api/v1/blog/posts/{{$post->id}}/media?type=images" @endif></div>
    @endif

    {{-- for upload handling --}}
    <div id="tmp_images">
        @foreach(old('images', []) as $tmp)
            <input type="hidden" name="images[]" value="{{ $tmp }}" />
        @endforeach
    </div>

    {{--<div class="col-xs-12">--}}
    {{-- @todo: replace this by dropzone --}}
    {{--<input type="file" name="images[]" multiple="multiple">--}}
    {{--</div>--}}
    <div class="col-xs-12">
        <div class="well dropzone" id="dropzone" data-max-files="1"></div>
    </div>
</div>