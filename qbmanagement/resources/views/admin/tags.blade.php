@extends('admin.adminhome')

	@section('tags')
    
    <head> <h2><i>Tags</i></h2><br></head>

    

    </br>
        <head><h4><legend>Add Tags</legend></h4></head>
      
        <div class="panel panel-default">
                <div class="panel-heading">Add a New Tag</div>
                <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="/tags" >
            
            {!! Form::model(new App\tags, ['route' => ['tags.store']]) !!}
                {{ csrf_field() }}
                 
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label">Tag Name</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                         @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-5 col-md-offset-5">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i> Add Tag
                        </button>
                    </div>
                </div>
            </form></div>
        </div></br></br></br></br>
    </div>


    <head><h4><legend>View or Delete</legend></h4></head>
    <table class="table table-striped table-bordered table-hover tablecondensed"> 
        <thead> 
            <tr><th>No.</th> 
                <th>Name</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Remove</th>                
            </tr>
        </thead>
        <tbody>
        
            @foreach( $tags as $key=>$tag   )          <!--for loop for each tag-->
                    <tr class="table-row" data-href="{{ URL::to('adminhome')}}">
                        <td>{{ (Input::get('page', 1) - 1) * $tags->perPage() + $key + 1 }}</td>          <!--tag[tagname]  to show tags name and so on-->
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->created_at }}</td>
                        <td>{{ $tag->updated_at }}</td>
                        <td> {{ Form::open(array('method' => 'DELETE', 'route' => array('tags.destroy',$tag->id))) }} 
                            {{ Form::submit('Delete', array('class'=> 'btn btn-secondary')) }} 
                            {{ Form::close() }}
                        </td>                        
                    </tr>
            @endforeach        
        </tbody>
    </table>
    <center>{{ $tags->links() }}</center>  



    

    @stop



    
    
    
	

                        