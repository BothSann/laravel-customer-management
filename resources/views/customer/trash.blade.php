@extends("layouts.app")

@section("content")
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <h3>Deleted Customers List</h3>
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col-md-2">
                    <a href="{{ route("customers.index") }}" class="btn" style="background-color: #4643d3; color: white;"><i class="fas fa-chevron-left"></i> Back</a>
                </div>
                <div class="col-md-8">
                    <form action="{{ route("customers.index") }}">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search anything..." aria-describedby="button-addon2" name="search" value="{{ request()->search }}">    
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                    <div class="input-group mb-3">
                        <form action="{{ route("customers.index") }}" method="GET" class="form-order">
                            <select class="form-select" name="order" id="" onchange="$('.form-order').submit()">
                                <option @selected(request()->order == "desc") value="desc">Newest to Oldest</option>
                                <option @selected(request()->order == "asc") value="asc">Oldest to Newest</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
                  
            </div>
            <div class="card-body">
                <table class="table table-bordered" style="border: 1px solid #dddddd">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Email</th>
                        <th scope="col">Bank Account Number</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ( $customers as $customer )
                            <tr>
                                <th class="text-danger" style="text-decoration: line-through;"  scope="row">{{ $loop->iteration }}</th>
                                <td class="text-danger" style="text-decoration: line-through;" >{{ $customer->first_name }}</td>
                                <td class="text-danger" style="text-decoration: line-through;" >{{ $customer->last_name }}</td>
                                <td class="text-danger" style="text-decoration: line-through;" >{{ $customer->phone }}</td>
                                <td class="text-danger" style="text-decoration: line-through;" >{{ $customer->email }}</td>
                                <td class="text-danger" style="text-decoration: line-through;" >{{ $customer->bank_account_number }}</td>
                                <td>
                                    <a href="{{ route("customers.restore", $customer->id) }}" style="color: #2c2c2c;" class="ms-1 me-1"><i class="fas fa-undo"></i></a>
                                    <a href="javascript:;" onclick="
                                    if(confirm('Are you sure you want to delete this item permanently?')) 
                                    $('.form-{{ $customer->id }}').submit()" style="color: #2c2c2c;" class="ms-1 me-1"><i class="fas fa-trash-alt"></i></a>
                                    <form action="{{ route("customers.force.destroy", $customer->id) }}" class="form-{{ $customer->id }}" method="POST" >
                                        @csrf
                                        @method("DELETE")
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                      
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection