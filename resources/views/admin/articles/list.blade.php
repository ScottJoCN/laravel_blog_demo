@extends('layouts.default')
@section('main')
<div class="am-g am-g-fixed blog-g-fixed">
	<div class="am-u-sm-12">
		<table class="am-table">
			<thead>
				<tr>
				<th>Title</th>
				<th>Tags</th>
				<th>Author</th>
				<th>Managment</th>
				</tr>
			</thead>
			<tbody>
				@foreach($articles as $article)
				<tr>
					<td><span class="am-badge am-badge-success am-radius">{{$tag->name}}</span>
					</td>
					<td>
						<a href="{{ URL::to('user/'.$article->user->id.'/articles')}}" title="">{{{$article->user->nickname}}}</a>
					</td>
					<td>
						<a href="{{URL::to('article/'.$article->id.'/edit')}}" title="" class="am-btn am-btn-xs am-btn-primary"><span class="am-icon-pencil"></span>Edit</a>
						<form action="{{URL::to('article/'.$article->id.'/delete')}}" method="get" accept-charset="utf-8" style="display:inline;">
							<button class="am-btn am-btn-xs am-btn-danger" id="delete{{$article->id}}"><span class="am-icon-remove"></span>Delete</button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</div>
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
	<div class="am-modal-dialog">
		<div class="am-modal-bd"></div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel>No</span>
			<span class="am-modal-btn" data-am-modal-confirm>Yes</span>
		</div>
	</div>
</div>
<script>
$(function(){
	$('[id^=delete]').on('click',function(){
		$('.am-modal-bd').text('Sure you want tu delete it?');
		$('#my-confirm').modal({
			relatedTarget:this,
			onConfirm:function(options){
				$(this.relatedTarget).parent().submit();
			},
			onCancel:function(){
				
			}
		});
	});

});
</script>
@endsection