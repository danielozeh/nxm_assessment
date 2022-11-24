@extends('layouts.main')

@section('content')
<div class="content-page killa">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Start transaction log Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title" style=" color: black !important; ">{{$invoice_id}}</h4>
                </div>
            </div>

            @if(session()->has('status'))
                <div class="alert alert-{{ session()->get('status') }} fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('message') }}
                </div>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card-box table-responsive">
                        <h3 class="btn btn-inverse  btn-block waves-effect waves-light" style="background-color: #83c324 !important;">
                             VIEW ORDER
                        </h3>

                        <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">

                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>

                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($order_info as $order)
                                <tr>
                                    <td>{{ $order->sku }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>${{ $order->price }}</td>
                                    <td>{{ $order->qantity }}</td>
                                    <td>${{ $order->qantity * $order->price }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- container -->

    </div> <!-- content -->

</div>

@endsection

    @section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>

    <!-- Key Tables -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

    <!-- Selection table -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.select.min.js') }}"></script>


@endsection
