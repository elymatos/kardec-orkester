<div>
    <div class="ui label right">
        <i class="file alternate icon"></i>{{$itemCode}}
    </div>
    @foreach($data->item->tags as $tag)
        <a class="ui tag label right">{{$tag['name']}}</a>
    @endforeach
    <div class="clear"></div>
</div>

