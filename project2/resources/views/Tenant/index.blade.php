@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tenants') }}</div>

                <div class="card-body">
                    <a class='btn btn-primary' href="{{route('tenants.create')}}">Add new Tenant</a>
                    <br/>
                  <table class="table">
                      <thead>
                          <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Domaine</th>
                          <th></th>
                        </tr>
                        @forelse ($tenants as $item)
                            
                        
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->domain}}</td>
                            <td><a href="{{route('tenants.edit',$item->id)}}" class='btn btn-sm btn-info'>Edit</a></td>
                            <td>
                                <form action='{{route('tenants.destroy',$item->id)}} ' method='POST'>

                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class='btn btn-sm btn-danger' onclick="return confirm('Are you sure')">Delete</button>
                                    </form>
                                </td>
                        </tr>
                        @empty
                         <tr>
                             <td colspan="4">No Tenants</td>
                         </tr>
                        @endforelse
                      </thead>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
