<div class="col-md-12 categories">
    @foreach($categories as $category)
    <a href="#" class="cats col-md-2 col-sm-6" data-id="{{$category['category_id']}}" id="{{ $category['alias'] }}">
        <img id="" class="" src="{{ asset($category['img']) }}" alt="{{ $category['name'] }}">
        <p>{{ $category['name'] }}</p>
    </a>
    @endforeach
    <br class="clear">
</div>