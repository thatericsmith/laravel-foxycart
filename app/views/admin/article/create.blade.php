{{Form::open(array('route' => 'admin.article.store'))}}
    <div class="box-body">
        <div class="form-group">
            @if(isset($topic))
            <label for="add-topic-input">Topic: <strong>{{$topic->title}}</strong></label>
            <input name="topic_id" type="hidden" value="{{$topic->id}}">
            <input name="view" type="hidden" value="topic">
            @else
            <label for="add-topic-input">Topic</label>
            <input name="topic_title" type="text" class="form-control" id="add-topic-input" placeholder="Topic (2016 Elections, Missing Plane, etc.)">
            <input name="topic_id" type="hidden" id="add-topic-input-id">
            @endif
        </div>
        @for($i=1;$i<6;$i++)
        <div class="form-group">
            <label for="add-article-url-{{$i}}">Article URL {{$i}}</label>
            <input id="add-article-url-{{$i}}" name="urls[]" type="text" class="form-control add-article-url" placeholder="URL">
        </div>
        @endfor
        

    </div><!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
{{Form::close()}}