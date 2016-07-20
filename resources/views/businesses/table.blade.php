<table class="table table-responsive" id="businesses-table">
    <thead>
        <th>Name</th>
        <th>Lat</th>
        <th>Long</th>
        <th>Created At</th>
        <th>Show in Map</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($businesses as $business)
        <tr id="{!!$business['id']!!}">
            <td>{!! $business['name'] !!}</td>
            <td>{!! $business['lat'] !!}</td>
            <td>{!! $business['long'] !!}</td>
            <td>{!! $business['created_at'] !!}</td>
            <td>
                {!! Form::checkbox('showInMap', 1, null, ['id' => 'check']) !!}
            </td>
            <td>
                {!! Form::open(['route' => ['businesses.destroy', $business['id']], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('businesses.show', [$business['id']]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('businesses.edit', [$business['id']]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>