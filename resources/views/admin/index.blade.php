@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">

                <div class="card-header">Admin Panel</div>

                @if (session('status'))

                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>

                @endif

                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                         @foreach($errors->all() as $error)
                         {{ $error }}
                         @endforeach
                    </div>
                @endif

                    <div class="card-body">

                        <h2> Add City </h2>

                        <form action="{{ route( "city.add" ) }}" method="POST" id="addCity">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="country">Country:</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea type="text" class="form-control" id="description" name="description" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>

                        </form>

                    </div>

                </div>
                <div class="card">

                    <div class="card-body">

                        <h2>Import Data</h2>
                        <form action="{{ route( "import.data" ) }}" method="POST" enctype="multipart/form-data" id="importData">
                            {{ csrf_field() }}

                            <div class="row">

                                <div class="col-md-3">
                                    <label for="airports">Impor Airports:</label><br>
                                    <input type="file" name="airports" id="airports">
                                </div>

                                <div class="col-md-3">
                                    <label for="routes">Impor Routes:</label>
                                    <input type="file" name="routes" id="routes">
                                </div>

                            </div><br>

                            <button type="submit" class="btn btn-primary" id="importDataButton">Import Data</button>


                        </form>

                     </div>

            </div>

        </div>

    </div>

</div>
<div id="overlay"></div>
<div id="loader"></div>



@endsection


