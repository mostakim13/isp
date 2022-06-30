@extends('admin.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form" action="{{ route('dailyIncome.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$dailyincome->id}}" name="id">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="last-name-column">Date</label>
                                <input type="date" class="form-control flatpickr-basic" placeholder="Select date"
                                    name="date" value="{{ $dailyincome->date }}" required />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Category</label>
                                <select class="select2 select2-lg mb-3" name="category_id"
                                    aria-label=".select2-lg example">
                                    <option selected disabled>Select category</option>
                                    @foreach ($incomecategories as $incomecategory)
                                    <option value="{{$incomecategory->id}}" {{ $incomecategory->id ==
                                        $dailyincome->category_id ? 'selected':''
                                        }}>{{$incomecategory->service_category_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Served By</label>
                                <select class="select2 select2-lg mb-3" name="served_by"
                                    aria-label=".select2-lg example">
                                    <option selected disabled>Served by</option>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}" {{ $user->id == $dailyincome->served_by ?
                                        'selected':'' }}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Amount</label>
                                <input type="number" value="{{ $dailyincome->amount }}" class="form-control"
                                    name="amount" placeholder="Enter amount" required />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="email-id-column">Paid Amount</label>
                                <input type="number" value="{{ $dailyincome->paid_amount }}" class="form-control"
                                    name="paid_amount" placeholder="Enter amount" required />
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="company-column">Description</label>
                                <input type="text" class="form-control" name="description"
                                    placeholder="Enter description" value="{{ $dailyincome->description }}" required />
                            </div>
                        </div>

                        <div class="mt-2">
                            <button href="" type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
