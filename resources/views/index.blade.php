@extends('layouts.default')
<!-- content -->
@section('main')
<div class="am-g am-g-fixed blog-g-fixed">
  <div class="am-u-md-8">
    {{-- foreach article --}}
    @foreach($articles as $article)
    	<article class="blog-main">
    		<h3 class="am-article-title blog-title"><a href="{{URL::route('article.show',$article->id)}}" title="">{{{ $article->title }}}</a></h3>
    		<h4 class="am-article-meta blog-meta">
    			by <a href="{{ URL::to('user/'.$article->user->id . '/articles')}}" title="">{{{ $article->user->nickname}}} </a> posted on {{$article->created_at->format('Y/m/d H:i')}} under
    			{{-- echo tags --}}
    			@foreach($article->tags as $tag)
    			<a href="{{URL::to('tag/'.$tag->id.'/articles')}}" title="" style="color:#fff" class="am-badge am-badge-success am-radius">{{ $tag->name}}</a>
    			@endforeach
    		</h4>
    		<div class="am-g">
    			<div class="am-u-sm-12">
    				@if($article->summary)
    					<p>{!! $article->summary !!}</p>
    				@endif
    				<hr class="am-article-divider" />
    			</div>
    		</div>
    	</article>
    @endforeach
    {{-- foreach article --}}
  </div>
  <div class="am-u-md-4 blog-sidebar">
  	<br>
  	<div class="am-panel-group">
  		<section class="am-panel am-panel-default"><div class="am-panel-hd"><span class="am-icon-tags"></span><a href="{{URL::to('tag')}}" title="Tags">Tags</a></div>
  			<ul class="am-list">
  				@for($i=0,$len = count($tags);$i<$len ;$i++)
  				<li><a href="{{URL::to('tag/'.$tags[$i]->id.'/articles')}}" title="">{{$tags[$i]->name}}
  					@if($i==0)
  					<span class="am-fr am-badge am-badge-danger am-round">{{$tags[$i]->count}}</span>
  					@elseif($i ==1)
  					<span class="am-fr am-badge am-badge-warning am-round">{{$tags[$i]->count}}</span>
  					@elseif($i ==2)
  					<span class="am-fr am-badge am-badge-success am-round">{{$tags[$i]->count}}</span>
  					@else
  					<span class="am-fr am-badge am-round">{{$tags[$i]->count}}</span>
  					@endif
  				</a>
  				</li>
  				@endfor
  			</ul>
  		</section>
  	</div>
  </div>
</div>
{!! $articles->render() !!}
@endsection