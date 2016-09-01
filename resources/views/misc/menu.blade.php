<div class="col-md-12 categories">
    @foreach($categories as $category)
    <a href="#" class="cats" data-id="{{$category['category_id']}}" id="{{ $category['alias'] }}"><img id="" class="col-md-2 col-sm-6" src="{{ $category['img'] }}" alt="{{ $category['name'] }}"></a>
    @endforeach
    <br class="clear">
</div>