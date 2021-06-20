@extends('master')
@section('content')
    <div class="container beta-relative">
        <div class="pull-left">
            <h2>List</h2>
        </div>
        <div class="pull-right">
            <input type="text" placeholder="Search">
        </div>
    </div>
    <div class="container">
        <table class="table table-striped table dark">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Unit_price</th>
                    <th>Promotion_price</th>
                    <th>Unit</th>
                    <th>New</th>
                    <td>
                        <a href="/getadminadd" class="btn btn-success" style="width:80px">Add</button>
                        </a>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th>{{ $product->id }}</th>
                        <td><img src="source/image/product/{{ $product->image }}" alt=""></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->id_type }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->unit_price }}</td>
                        <td>{{ $product->promotion_price }}</td>
                        <td>{{ $product->unit }}</td>
                        <td>{{ $product->new }}</td>
                        <td>
                            <form role="form" action="/getadminedit/{{ $product->id }}" method="get">
                                @csrf
                                <button name="edit" class="btn btn-warning" style="width:80px">Edit</button>
                            </form>
                            &nbsp;
                            <form role="form" action="/admindelete/{{ $product->id }}" method="post">
                                @csrf
                                <button name="edit" class="btn btn-danger" style="width:80px">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
